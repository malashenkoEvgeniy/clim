<?php

namespace App\Modules\Features\Models;

use App\Modules\Features\Requests\FeatureAjaxRequest;
use App\Modules\Products\Models\ProductGroup;
use App\Modules\Products\Models\ProductGroupFeatureValue;
use App\Traits\ActiveScopeTrait;
use App\Traits\CheckRelation;
use App\Traits\ModelMain;
use Greabock\Tentacles\EloquentTentacle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class Feature
 *
 * @property int $id
 * @property bool $active
 * @property int $in_filter
 * @property string $type
 * @property int $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $main
 * @property-read \App\Modules\Features\Models\FeatureTranslates $current
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Features\Models\FeatureTranslates[] $data
 * @property-read string $link_in_admin_panel
 * @property-read mixed $values_dictionary
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Features\Models\FeatureValue[] $values
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\Feature active($active = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\Feature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\Feature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\Feature query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\Feature whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\Feature whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\Feature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\Feature whereInFilter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\Feature whereMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\Feature wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\Feature whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Features\Models\Feature whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Products\Models\ProductGroup[] $groups
 */
class Feature extends Model
{
    use ModelMain, EloquentTentacle,  ActiveScopeTrait, CheckRelation;

    const TYPE_SINGLE = 'single';
    
    const TYPE_MULTIPLE = 'multiple';
    
    protected $casts = ['active' => 'boolean', 'main', 'in_filter', 'in_desc'];
    
    protected $fillable = ['in_filter', 'type', 'main', 'in_desc'];

    /**
     * Link in brand page in admin panel
     *
     * @return string
     */
    public function getLinkInAdminPanelAttribute(): string
    {
        return route('admin.features.edit', $this->id);
    }

    public static function allActive(?int $categoryId = null)
    {
        $query = Feature::with('current')->active(true);
        if ($categoryId) {
            $query->whereHas('groups', function (Builder $builder) use ($categoryId) {
                $builder->where('category_id', $categoryId);
            });
        }
        return $query->oldest('position')->get();
    }
    
    public function groups()
    {
        return $this->hasManyThrough(
            ProductGroup::class,
            ProductGroupFeatureValue::class,
            'feature_id',
            'id',
            'id',
            'group_id'
        );
    }

    /**
     * Values list
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function values()
    {
        return $this->hasMany(FeatureValue::class, 'feature_id', 'id')
            ->with('current')
            ->oldest('position');
    }
    
    /**
     * Get list of features
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getList()
    {
        return Feature::with(['current'])->oldest('position')->get();
    }
    
    public static function getAllActiveByIds(array $ids): Collection
    {
        return Feature::with('current', 'values', 'values.current')
            ->whereIn('id', $ids)
            ->active(true)
            ->oldest('position')
            ->get();
    }
    
    public function getValuesDictionaryAttribute(): array
    {
        $dictionary = [];
        $this->values->loadMissing('current')->each(function (FeatureValue $value) use (&$dictionary) {
            $dictionary[$value->id] = $value->current->name;
        });
        return $dictionary;
    }

    /**
     * @param  FeatureAjaxRequest $request
     * @param string|null $imageGroupType
     * @return string|null
     */
    public function createRowAjax(FeatureAjaxRequest $request, ?string $imageGroupType = null): ?string
    {
        $input = [];
        foreach ($request->input() as $key => $value) {
            $newKey = str_replace('features-', '', $key);
            $input[$newKey] = $value;
        }

        try {
            DB::beginTransaction();
            $this->fill($input);
            if ($this->save() !== true) {
                return 'Can not execute SQL request!';
            }

            $modelName = $this->relatedModelName();

            foreach (config('languages', []) AS $language) {
                $translate = new $modelName();
                $values = [];

                foreach ($request->input($language['slug']) as $key => $value) {
                    if(mb_strpos($key, 'features-') !== false) {
                        $newKey = str_replace('features-', '', $key);
                        $values[$newKey] = $value;
                    }
                }
                $translate->fill($values);
                $translate->language = $language['slug'];
                $translate->row_id = $this->id;
                $translate->save();
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return $exception->getMessage();
        }
        return null;
    }
    
}
