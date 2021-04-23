<?php

namespace App\Modules\Services\Models;

use App\Traits\ModelMain;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Services\Images\ServicesRubricImage;
use App\Traits\Imageable;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use App\Traits\ActiveScopeTrait;

class ServicesRubric extends Model
{
    use ModelMain, Imageable, ActiveScopeTrait;

    protected $fillable = ['active', 'position'];


    public static $dump;

    /**
     * App\Modules\Services\Models\ServiceRubric
     *
     * @property int $id
     * @property bool $active
     * @property int $position
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property int|null $menu
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Pages\Models\Page[] $children
     * @property-read \App\Modules\Pages\Models\ServicesRubricTranslates $current
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Pages\Models\ServicesRubricTranslates[] $data
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServicesRubric newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServicesRubric newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServicesRubric published()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServicesRubric query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServicesRubric topLevel()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServicesRubric whereActive($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServicesRubric whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServicesRubric whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServicesRubric whereMenu($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServicesRubric whereParentId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServicesRubric wherePosition($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Services\Models\ServicesRubric whereUpdatedAt($value)
     * @mixin \Eloquent
     */
    public static function getList()
    {
        $rubrics = ServicesRubric::with(['current', 'image', 'image.current']);
        return $rubrics->oldest('position')->get();
    }

    public function translations()
    {
        return $this->hasMany(ServicesRubricTranslates::class, 'row_id');
    }

    /**
     * Image config
     *
     * @return string|array
     */
    protected function imageClass()
    {
        return ServicesRubricImage::class;
    }

    /**
     * @param int $id
     * @return array|null
     */
    public function getPagesLinksByIdForImage(int $id)
    {
        $links = [];
        $item = ServicesRubric::active()->find($id);
        if($item){
            if($item->parent){
                $links[] = url(route('site.services', ['slug' => $item->parent->current->slug], false), [], isSecure());
            } else {
                $links[] = url(route('site.services', [], false), [], isSecure());
            }

        }
        return $links;
    }


    /**
     * Link on the show service-rubric inner page
     *
     * @return string
     */
    public function getLinkAttribute(): string
    {
        return route('site.services-rubric', [
            'slug' => $this->current->slug,
        ]);
    }


    public static function dump(): void
    {
        if (static::$dump !== null) {
            return;
        }
        static::$dump = new EloquentCollection();

        if (\Schema::hasTable('services_rubrics') === false) {
            return;
        }

        ServicesRubric::with(
            'current',
            'image', 'image.current'
            )
            ->active()
            ->oldest('position')
            ->latest('id')
            ->get()
            ->each(function (ServicesRubric $servicesRubric) {
                static::$dump->put($servicesRubric->id, $servicesRubric);
            });
    }

    public static function getOneBySlug(string $slug): ?ServicesRubric
    {
        static::dump();
        foreach (static::$dump as $servicesRubric) {
            if ($servicesRubric->current->slug === $slug) {
                return $servicesRubric;
            }
        }
        return null;
    }
}