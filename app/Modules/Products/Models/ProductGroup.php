<?php

namespace App\Modules\Products\Models;

use App\Core\Modules\Images\Models\Image;
use App\Modules\Brands\Models\Brand;
use App\Modules\Categories\Models\Category;
use App\Modules\Features\Models\Feature;
use App\Modules\LabelsForProducts\Models\Label;
use App\Modules\Products\Filters\Filter;
use App\Modules\Products\Filters\ProductGroupAdminFilter;
use App\Modules\Products\Images\GroupImage;
use App\Traits\ActiveScopeTrait;
use App\Traits\CheckRelation;
use App\Traits\Commentable;
use CustomForm\Element;
use CustomForm\SimpleElement;
use Greabock\Tentacles\EloquentTentacle;
use Illuminate\Http\Request;
use App\Traits\Imageable;
use App\Traits\ModelMain;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Widget, Catalog, Html;

/**
 * App\Modules\Products\Models\ProductGroup
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $active
 * @property bool $available
 * @property int $position
 * @property int|null $brand_id
 * @property int|null $category_id
 * @property int|null $feature_id
 * @property float $price_min
 * @property float $price_max
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Core\Modules\Images\Models\Image[] $allImages
 * @property-read \App\Modules\Brands\Models\Brand|null $brand
 * @property-read \App\Modules\Categories\Models\Category|null $category
 * @property-read \App\Modules\Products\Models\ProductGroupTranslates $current
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Products\Models\ProductGroupTranslates[] $data
 * @property-read \App\Modules\Features\Models\Feature $feature
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Products\Models\ProductGroupFeatureValue[] $featureValues
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Products\Models\ProductGroupFeatureValue[] $filters
 * @property-read EloquentCollection|Product[] $filtered_products
 * @property-read mixed $ignored_for_live_search
 * @property-read mixed $mark
 * @property-read mixed $name
 * @property-read mixed $other_categories_ids
 * @property-read string $main_features
 * @property-read Product $relevant_product
 * @property-read EloquentCollection|Product[] $sorted_products
 * @property-read \App\Core\Modules\Images\Models\Image $image
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Core\Modules\Images\Models\Image[] $images
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\LabelsForProducts\Models\Label[] $labels
 * @property-read \App\Modules\Products\Models\Product $mainProduct
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Categories\Models\Category[] $otherCategories
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Products\Models\Product[] $products
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Products\Models\ProductGroup[] $related
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Products\Models\ProductGroupFeatureValue[] $same
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroup active($active = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroup filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroup paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroup simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroup whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroup whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroup whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroup whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroup whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroup whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroup whereFeatureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroup whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroup wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroup wherePriceMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroup wherePriceMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read mixed $preview
 * @property-read mixed $print_categories
 */
class ProductGroup extends Model
{
    use Filterable, Imageable, ModelMain, Commentable, EloquentTentacle, CheckRelation, ActiveScopeTrait;
    
    const LIMIT_PER_PAGE_BY_DEFAULT_ADMIN_PANEL = 20;
    
    const LIMIT_PER_PAGE_BY_DEFAULT = 16;
    
    const LIMIT_SLIDER_WIDGET = 15;
    
    const DEFAULT_POSITION = 500;
    
    protected $table = 'products_groups';
    
    protected $casts = ['active' => 'boolean', 'available' => 'boolean'];
    
    protected $fillable = ['brand_id', 'category_id', 'position', 'active', 'feature_id', 'available'];
    
    protected function imageClass()
    {
        return GroupImage::class;
    }
    
    public function modelFilter()
    {
        return $this->provideFilter(ProductGroupAdminFilter::class);
    }
    
    public function filters()
    {
        return $this->hasMany(ProductGroupFeatureValue::class, 'group_id', 'id');
    }
    
    public function getPrintCategoriesAttribute(): string
    {
        $categories = [];
        $this->otherCategories->each(function (Category $category) use (&$categories) {
            $categories[] = Html::link($category->link_in_admin_panel, $category->current->name, ['target' => '_blank']);
        });
        return count($categories) > 0 ? implode(', ', $categories) : '&nbsp;';
    }
    
    public function getMainFeaturesAttribute(): string
    {
        $features = [];
        $this->featureValues = $this->featureValues->sortBy('feature.position');
        foreach ($this->featureValues as $productFeatureValue) {
            if ($productFeatureValue->feature_id !== $this->feature_id && $productFeatureValue->value && $productFeatureValue->feature->main) {
                $features[$productFeatureValue->feature->current->name] = $features[$productFeatureValue->feature->current->name] ?? [];
                $features[$productFeatureValue->feature->current->name][$productFeatureValue->value_id] = $productFeatureValue->value->current->name;
            }
        }
        $descriptions = [];
        foreach ($features as $featureName => $values) {
            $descriptions[] = '<b>' . $featureName . ':</b> ' . implode(', ', $values);
        }
        return implode('<br />', $descriptions);
    }
    
    public function getRelevantProductAttribute()
    {
        $products = $this->filtered_products->where('available', true);
        if ($products->isEmpty()) {
            $products = $this->filtered_products;
        }
        switch (request()->query('order')) {
            case 'price-asc':
                return $products->sortBy('price')->first();
            case 'price-desc':
                return $products->sortByDesc('price')->first();
        }
        return $products->first();
    }
    
    public function getFilteredProductsAttribute()
    {
        list ($priceMin, $priceMax) = array_pad(explode('-', request()->query('price')), 2, null);
        $priceMin = (float)$priceMin;
        $priceMax = (float)$priceMax;
        if (Catalog::currenciesLoaded()) {
            $priceMin = Catalog::currency()->calculateBack($priceMin);
            $priceMax = Catalog::currency()->calculateBack($priceMax);
        }
        $filter = \ProductsFilter::getFilterParametersIdsFromQuery()->toArray();
        $currentFeatureFilter = array_get($filter, $this->feature_id, []);
        unset($currentFeatureFilter['brand']);
        return $this->sorted_products->filter(function (Product $product) use ($priceMin, $priceMax, $currentFeatureFilter) {
            if(count($currentFeatureFilter) > 0 && in_array($product->value_id, $currentFeatureFilter) === false) {
                return false;
            }
            if ($priceMin > 0 && $product->price < $priceMin) {
                return false;
            }
            if ($priceMax > 0 && $product->price > $priceMax) {
                return false;
            }
            return true;
        });
    }
    
    /**
     * @param EloquentCollection|LengthAwarePaginator|ProductGroup[] $groups
     */
    public static function loadMissingForLists($groups): void
    {
        $groups->loadMissing(
            'products', 'current', 'images', 'comments', 'images.current',
            'labels', 'labels.current', 'products.current', 'products.images', 'products.images.current',
            'products.value', 'products.value.current'
        );
    
        if (config('db.products.show-brand-in-item-card', true)) {
            $groups->loadMissing(
                'brand',
                'brand.current'
            );
        }
    
        if (config('db.products.show-main-features')) {
            $groups->loadMissing(
                'featureValues.value',
                'featureValues.feature',
                'featureValues.value.current',
                'featureValues.feature.current'
            );
        }
    }
    
    /**
     * @return Collection|Image[]
     */
    public function gallery()
    {
        return $this->images->merge($this->products->first()->images);
    }
    
    public function getPreviewAttribute()
    {
        foreach ($this->gallery() as $image) {
            if ($image->isImageExists()) {
                return $image;
            }
        }
        return new Image();
    }
    
    /**
     * @param array $filter
     * @param int|null $limit
     * @return LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|ProductGroup[]
     */
    public static function getFilteredList(array $filter = [], ?int $limit = null)
    {
        return ProductGroup::where((new self)->getTable() . '.active', true)
            ->filter($filter, Filter::class)
            ->paginate($limit ?: config('db.products.site-per-page', ProductGroup::LIMIT_PER_PAGE_BY_DEFAULT));
    }
    
    /**
     * @param int|null $groupId
     * @return string|null
     */
    public static function getElementForList(?int $groupId = null): ?string
    {
        if (!$groupId) {
            return null;
        }
        $group = ProductGroup::find($groupId);
        if (!$group) {
            return null;
        }
        return (string)\Html::link(
            route('admin.groups.edit', $group->id),
            $group->current->name,
            ['target' => '_blank']
        );
    }
    
    public function getMarkAttribute(): int
    {
        $mark = 0;
        if ($this->comments->isNotEmpty()) {
            $count = 0;
            $total = 0;
            $this->comments->each(function (Model $comment) use (&$total, &$count) {
                if ($comment->mark) {
                    $count++;
                    $total += $comment->mark;
                }
            });
            if ($count > 0) {
                $mark = round($total / $count);
            }
        }
        return $mark;
    }
    
    /**
     * @param int|null $commentableId
     * @return Element|null
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function formElementForComments(?int $commentableId = null): ?Element
    {
        return SimpleElement::create()
            ->setLabel('products::admin.choose-product')
            ->setDefaultValue(Widget::show('products::groups::live-search', [], 'commentable_id', $commentableId))
            ->required();
    }
    
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function feature()
    {
        return $this->hasOne(Feature::class, 'id', 'feature_id');
    }
    
    public function labels()
    {
        $relation = $this->hasManyThrough(
            Label::class,
            ProductGroupLabel::class,
            'group_id',
            'id',
            'id',
            'label_id'
        );
        if (config('app.place') === 'site') {
            $relation->where('active', true);
        }
        return $relation;
    }
    
    public function related()
    {
        return $this->hasManyThrough(
            ProductGroup::class,
            ProductGroupRelated::class,
            'group_id',
            'id',
            'id',
            'related_id'
        );
    }
    
    public function featureValues()
    {
        return $this->hasMany(ProductGroupFeatureValue::class, 'group_id', 'id');
    }
    
    public function products()
    {
        return $this->hasMany(Product::class, 'group_id', 'id');
    }
    
    public function getSortedProductsAttribute()
    {
        return $this->products->sort(function (Product $prevProduct, Product $product) {
            if ($prevProduct->value_id && $product->value_id) {
                return $prevProduct->value->position <=> $product->value->position;
            }
            return $prevProduct->position <=> $product->position;
        });
    }
    
    public function same()
    {
        return $this->hasMany(ProductGroupFeatureValue::class, 'group_id', 'id');
    }
    
    public function otherCategories()
    {
        return $this->hasManyThrough(
            Category::class,
            ProductGroupCategory::class,
            'group_id',
            'id',
            'id',
            'category_id'
        )->with('current');
    }
    
    public function getOtherCategoriesIdsAttribute(): array
    {
        $ids = [];
        ProductGroupCategory::whereGroupId($this->id)->get()->each(function (ProductGroupCategory $relation) use (&$ids) {
            $ids[] = $relation->category_id;
        });
        return $ids;
    }
    
    public function getNameAttribute(): ?string
    {
        return $this->current->name;
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function mainProduct()
    {
        return $this->hasOne(Product::class, 'group_id', 'id')
            ->latest('is_main')
            ->latest('available')
            ->latest('id');
    }
    
    /**
     * @param int|null $limit
     * @return LengthAwarePaginator
     */
    public static function getList(?int $limit = null): LengthAwarePaginator
    {
        return ProductGroup::with(
            'current',
            'products', 'products.current',
            'otherCategories',
            'brand', 'brand.current'
        )
            ->filter(request()->all())
            ->latest('id')
            ->paginate($limit ?: config('db.products.per-page', ProductGroup::LIMIT_PER_PAGE_BY_DEFAULT_ADMIN_PANEL));
    }
    
    /**
     * @param Request $request
     * @return ProductGroup
     * @throws \Exception
     */
    public static function store(Request $request): ProductGroup
    {
        $group = new ProductGroup;
        $group->createRow($request);
        $group->syncWithProducts($request);
        $group->updatePrices();
        $group->syncOtherCategories($request->input('categories', []), $request->input('category_id'));
        $group->syncLabels($request->input('labels', []));
        return $group;
    }
    
    /**
     * @param Request $request
     * @throws \Exception
     */
    public function edit(Request $request): void
    {
        $this->updateRow($request);
        $this->syncWithProducts($request);
        $this->updatePrices();
        $this->syncLabels($request->input('labels', []));
        $this->syncOtherCategories($request->input('categories', []), $request->input('category_id'));
    }
    
    public function updatePrices(): void
    {
        $products = $this->fresh()->products;
        $availableProducts = $products->where('available', true);
        if ($availableProducts->isNotEmpty()) {
            $this->price_min = $availableProducts->min('price');
            $this->price_max = $availableProducts->max('price');
            $this->available = true;
        } else {
            $this->price_min = $products->min('price');
            $this->price_max = $products->max('price');
            $this->available = false;
        }
        $this->save();
    }
    
    /**
     * @param Request $request
     */
    public function syncWithProducts(Request $request): void
    {
        $hasProducts = $this->products->isNotEmpty();
        
        $modifications = new Collection();
        foreach ($request->input('modification', []) as $field => $values) {
            foreach ($values as $index => $value) {
                $modification = $modifications->get($index, []);
                $modification[$field] = $value;
                $modifications->put($index, $modification);
            }
        }
        foreach (config('languages', []) as $lang => $language) {
            foreach ($request->input($lang . '.modification', []) as $field => $values) {
                foreach ($values as $index => $value) {
                    $modification = $modifications->get($index, []);
                    $modification[$lang][$field] = $value;
                    $modifications->put($index, $modification);
                }
            }
        }
        $modifications->each(function ($modification, $index) use ($hasProducts, $request) {
            if ($hasProducts === false) {
                $modification['is_main'] = $index === 0;
            }
            $modification['images'] = $request->file("modification.$index.images", []);
            Product::createOrUpdateFromArray($modification, $this);
        });
    }
    
    /**
     * @param array $labelsIds
     * @throws \Exception
     */
    public function syncLabels(array $labelsIds = [])
    {
        ProductGroupLabel::whereGroupId($this->id)->whereNotIn('label_id', $labelsIds)->delete();
        foreach ($labelsIds as $labelId) {
            ProductGroupLabel::updateOrCreate([
                'label_id' => $labelId,
                'group_id' => $this->id,
            ]);
        }
    }
    
    /**
     * @param array $categoryIds
     * @param int|null $categoryId
     * @throws \Exception
     */
    public function syncOtherCategories(array $categoryIds = [], ?int $categoryId = null)
    {
        if (in_array($categoryId, $categoryIds) === false) {
            $categoryIds[] = $categoryId;
        }
        $realCategoryIds = [];
        if ($categoryIds) {
            Category::with('parent')->whereIn('id', $categoryIds)->get()->each(function (Category $category) use (&$realCategoryIds) {
                $this->iterativeWithParents($realCategoryIds, $category);
            });
        }
        ProductGroupCategory::whereGroupId($this->id)->whereNotIn('category_id', $realCategoryIds)->delete();
        foreach ($realCategoryIds as $categoryId) {
            ProductGroupCategory::updateOrCreate([
                'category_id' => $categoryId,
                'group_id' => $this->id,
            ]);
        }
    }
    
    /**
     * @param array $dictionary
     * @param Category $category
     */
    private function iterativeWithParents(array &$dictionary, Category $category): void
    {
        $dictionary[] = $category->id;
        if ($category->parent_id && $category->parent) {
            $this->iterativeWithParents($dictionary, $category->parent);
        }
    }
    
    public function getIgnoredForLiveSearchAttribute(): array
    {
        $ignored = [$this->id];
        $this->related->each(function (ProductGroup $group) use (&$ignored) {
            $ignored[] = $group->id;
        });
        return $ignored;
    }
    
    /**
     * @param int|null $limit
     * @param array $ignored
     * @return LengthAwarePaginator|EloquentCollection
     */
    public static function search(?int $limit = null, array $ignored = []): LengthAwarePaginator
    {
        $forFilter = request()->only('query', 'order');
        $forFilter['order'] = $forFilter['order'] ?? 'default';
        $groupsQuery = ProductGroup::whereNotIn('id', $ignored)->filter($forFilter);
        $limit = (int)$limit ?: request()->query('per-page');
        $groups = $groupsQuery->paginate(
            $limit ?: config('db.products.per-page', static::LIMIT_PER_PAGE_BY_DEFAULT_ADMIN_PANEL)
        );
        return $groups;
    }
    
    public function toggleActiveStatus(): void
    {
        $this->active = !$this->active;
        $this->save();
        
        $this->products->each(function (Product $product) {
            $product->active = $this->active;
            $product->save();
        });
    }


    /**
     * @param int $id
     * @return array|null
     */
    public function getPagesLinksByIdForImage(int $id)
    {
        $links = [];
        $item = ProductGroup::active()->find($id);
        if($item && $item->products){
            foreach($item->products as $product){
                $links[] = url(route('site.product', ['slug' => $product->current->slug], false), [], isSecure());
            }
        }
        return $links;
    }
    
}
