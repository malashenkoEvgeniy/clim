<?php

namespace App\Modules\Brands\Models;

use App\Modules\Brands\Filters\BrandsFilter;
use App\Modules\Brands\Images\BrandImage;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\ProductGroup;
use App\Traits\ActiveScopeTrait;
use App\Traits\Imageable;
use App\Traits\ModelMain;
use EloquentFilter\Filterable;
use Greabock\Tentacles\EloquentTentacle;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Brands\Models\Brand
 *
 * @property int $id
 * @property bool $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Core\Modules\Images\Models\Image[] $allImages
 * @property-read \App\Modules\Brands\Models\BrandTranslates $current
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Brands\Models\BrandTranslates[] $data
 * @property-read string $link
 * @property-read string $link_in_admin_panel
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Products\Models\ProductGroup[] $groups
 * @property-read \App\Core\Modules\Images\Models\Image $image
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Core\Modules\Images\Models\Image[] $images
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Products\Models\Product[] $products
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Brands\Models\Brand active($active = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Brands\Models\Brand filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Brands\Models\Brand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Brands\Models\Brand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Brands\Models\Brand paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Brands\Models\Brand query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Brands\Models\Brand simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Brands\Models\Brand whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Brands\Models\Brand whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Brands\Models\Brand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Brands\Models\Brand whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Brands\Models\Brand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Brands\Models\Brand whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Brands\Models\Brand whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Brand extends Model
{
    use ModelMain, Imageable, EloquentTentacle, ActiveScopeTrait, Filterable;
    
    const DEFAULT_LIMIT_IN_ADMIN_PANEL = 10;
    
    protected $casts = ['active' => 'boolean'];
    
    protected $fillable = ['active'];
    
    /**
     * Product image configurations class
     *
     * @return string
     */
    protected function imageClass()
    {
        return BrandImage::class;
    }
    
    /**
     * Register filter model
     *
     * @return string
     */
    public function modelFilter()
    {
        return $this->provideFilter(BrandsFilter::class);
    }
    
    /**
     * Link in brand page in admin panel
     *
     * @return string
     */
    public function getLinkInAdminPanelAttribute(): string
    {
        return route('admin.brands.edit', $this->id);
    }
    
    /**
     * Returns list of brands to show in admin panel
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getList()
    {
        return Brand::with('current')
            ->filter(request()->only('name', 'active'))
            ->latest('id')
            ->paginate(config('db.brands.per-page', 10));
    }
    
    /**
     * Returns all active brands list
     *
     * @return Brand[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function allActive()
    {
        return Brand::with('current', 'image', 'image.current')->active(true)->latest('id')->get();
    }

    public static function allActiveForFilter()
    {
        return Brand::with('current')
            ->active(true)
            ->latest('id')
            ->get();
    }
    
    /**
     * Returns URl on brand landing page
     *
     * @return string
     */
    public function getLinkAttribute(): string
    {
        return route('site.brands.show', [$this->current->slug]);
    }
    
    public function groups()
    {
        return $this->hasMany(ProductGroup::class, 'brand_id', 'id');
    }
    
    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id', 'id');
    }


    /**
     * @param int $id
     * @return array|null
     */
    public function getPagesLinksByIdForImage(int $id)
    {
        $links = [];
        $item = Brand::active()->find($id);
        if($item){
            $links[] = url(route('site.brands.show', ['slug' => $item->current->slug], false), [], isSecure());

        }
        return $links;
    }
}
