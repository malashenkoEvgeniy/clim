<?php

namespace App\Modules\LabelsForProducts\Models;

use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\ProductGroup;
use App\Modules\Products\Models\ProductGroupLabel;
use App\Traits\ActiveScopeTrait;
use App\Traits\CheckRelation;
use App\Traits\ModelMain;
use Greabock\Tentacles\EloquentTentacle;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\LabelsForProducts\Models\Label
 *
 * @property int $id
 * @property bool $active
 * @property string $color
 * @property int $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\LabelsForProducts\Models\LabelTranslates $current
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\LabelsForProducts\Models\LabelTranslates[] $data
 * @property-read string $link_in_admin_panel
 * @property-read bool $seo_block_needed
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Products\Models\ProductGroup[] $groups
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Products\Models\Product[] $products
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\LabelsForProducts\Models\Label active($active = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\LabelsForProducts\Models\Label newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\LabelsForProducts\Models\Label newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\LabelsForProducts\Models\Label query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\LabelsForProducts\Models\Label whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\LabelsForProducts\Models\Label whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\LabelsForProducts\Models\Label whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\LabelsForProducts\Models\Label whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\LabelsForProducts\Models\Label wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\LabelsForProducts\Models\Label whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Label extends Model
{
    use ModelMain, ActiveScopeTrait, CheckRelation, EloquentTentacle;
    
    const DEFAULT_MINIMUM_PRODUCTS_IN_WIDGET = 1;
    
    const DEFAULT_MAXIMUM_PRODUCTS_IN_WIDGET = 10;

    protected $casts = ['active' => 'boolean'];

    protected $fillable = ['active', 'color'];
    
    public function getPaginatedGroups()
    {
        return $this
            ->groups()
            ->limit(config('db.labels.limit-in-widget', static::DEFAULT_MAXIMUM_PRODUCTS_IN_WIDGET))
            ->latest('id')
            ->get();
    }
    
    public function groups()
    {
        return $this->hasManyThrough(
            ProductGroup::class,
            ProductGroupLabel::class,
            'label_id',
            'id',
            'id',
            'group_id'
        )->where('active', true);
    }
    
    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            ProductGroupLabel::class,
            'label_id',
            'group_id',
            'id',
            'group_id'
        )->where('active', true)->where('is_main', true);
    }
    
    /**
     * @param bool|null $active
     * @return Label[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getList(?bool $active = null)
    {
        $query = Label::with('current');
        if ($active !== null) {
            $query->where('active', $active);
        }
        return $query->oldest('position')->get();
    }

    /**
     * Label link in admin panel
     *
     * @return string
     */
    public function getLinkInAdminPanelAttribute(): string
    {
        return route('admin.product-labels.edit', ['label' => $this->id]);
    }

    /**
     * Checks if we need to show SEO block
     *
     * @return bool
     */
    public function getSeoBlockNeededAttribute()
    {
        $seoText = strip_tags($this->current->content);
        $seoText = trim($seoText);
        return $this->current->h1 || $seoText;
    }

}
