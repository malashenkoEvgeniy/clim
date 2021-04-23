<?php

namespace App\Modules\Products\Models;

use App\Core\Modules\Images\Models\Image;
use App\Modules\Brands\Models\Brand;
use App\Modules\Comments\Models\Comment;
use App\Modules\Features\Models\FeatureValue;
use App\Modules\LabelsForProducts\Models\Label;
use App\Modules\Products\Filters\ProductsAdminFilter;
use App\Modules\Products\Filters\SearchFilter;
use App\Modules\Products\Images\ProductImage;
use App\Modules\ProductsAvailability\Events\ChangeProductStatusEvent;
use App\Traits\ActiveScopeTrait;
use App\Traits\CheckRelation;
use App\Traits\Imageable;
use App\Traits\ModelMain;
use Carbon\Carbon;
use EloquentFilter\Filterable;
use Greabock\Tentacles\EloquentTentacle;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Catalog, Seo, Event;
use Illuminate\Http\UploadedFile;

/**
 * App\Modules\Products\Models\Product
 *
 * @property int $id
 * @property int $active
 * @property int $available
 * @property float $price
 * @property float|null $old_price
 * @property string|null $vendor_code
 * @property int $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $is_main
 * @property int|null $value_id
 * @property int|null $group_id
 * @property int|null $brand_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Core\Modules\Images\Models\Image[] $allImages
 * @property-read \App\Modules\Brands\Models\Brand|null $brand
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Comments\Models\Comment[] $comments
 * @property-read \App\Modules\Products\Models\ProductTranslates $current
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Products\Models\ProductTranslates[] $data
 * @property-read string $data_for_button
 * @property-read array $feature_values_as_array
 * @property-read Collection|ProductGroupFeatureValue[] $feature_values
 * @property-read array $features_list
 * @property-read array $features_desc_list
 * @property-read string $formatted_old_price
 * @property-read string $formatted_old_price_for_admin
 * @property-read string $formatted_price
 * @property-read string $formatted_price_for_admin
 * @property-read mixed $is_available
 * @property-read string $main_features
 * @property-read string|null $microdata
 * @property-read mixed $name
 * @property-read int $old_price_for_site
 * @property-read Image $preview
 * @property-read float $price_for_site
 * @property-read Collection|ProductGroup[] $related
 * @property-read string $site_link
 * @property-read Collection $tabs
 * @property-read \App\Modules\Products\Models\ProductGroup|null $group
 * @property-read \App\Core\Modules\Images\Models\Image $image
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Core\Modules\Images\Models\Image[] $images
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\LabelsForProducts\Models\Label[] $labels
 * @property-read \App\Modules\Features\Models\FeatureValue $value
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Products\Models\ProductWholesale[] $wholesale
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\Product active($active = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\Product filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\Product paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\Product simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\Product whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\Product whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\Product whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\Product whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\Product whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\Product whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\Product whereIsMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\Product whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\Product whereOldPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\Product wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\Product whereValueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\Product whereVendorCode($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    use ModelMain, Imageable, ActiveScopeTrait, EloquentTentacle, CheckRelation, Filterable;

    const LIMIT_PER_PAGE_BY_DEFAULT = 10;
    const LIMIT_PER_PAGE_BY_DEFAULT_ADMIN_PANEL = 10;
    const LIMIT_SLIDER_WIDGET = 15;

    const DEFAULT_POSITION = 500;

    const NOT_AVAILABLE = 0;
    const AVAILABLE = 1;

    const SEO_TEMPLATE_ALIAS = 'products';

    protected $casts = ['price' => 'float', 'old_price' => 'float', 'is_main' => 'boolean'];

    protected $fillable = [
        'brand_id', 'active', 'price', 'available', 'old_price', 'position',
        'vendor_code', 'group_id', 'is_main', 'value_id',
    ];

    public function getIsAvailableAttribute(): bool
    {
        return $this->available === static::AVAILABLE;
    }

    public function value()
    {
        return $this->hasOne(FeatureValue::class, 'id', 'value_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    /**
     * @return Collection|Image[]
     */
    public function gallery()
    {
        return $this->images->merge($this->group->images);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable', 'groups', null, 'group_id')
            ->where('active', true)
            ->where('published_at', '<=', Carbon::now());
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

    public function getNameAttribute(): string
    {
        if ($this->current->name) {
            return $this->current->name;
        }
        $parts = [];
        $parts[] = $this->group->name;
        if ($this->value_id) {
            $parts[] = $this->value->current->name;
        }
        return implode(' ', $parts);
    }

    /**
     * @param array $modification
     * @param ProductGroup $group
     * @return Product
     * @throws \App\Exceptions\WrongParametersException|\Exception
     */
    public static function createOrUpdateFromArray(array $modification, ProductGroup $group): Product
    {
        $price = array_get($modification, 'price');
        $oldPrice = array_get($modification, 'old_price');
        if ($price > $oldPrice && $oldPrice > 0) {
            $modification['price'] = $oldPrice;
            $modification['old_price'] = $price;
        } elseif ($price === $oldPrice && $oldPrice > 0) {
            $modification['old_price'] = ($oldPrice - 1) ?: 0;
        }
        $modification['brand_id'] = $group->brand_id;
        $modification['group_id'] = $group->id;
        $product = Product::findOrNew(array_get($modification, 'id', 0));
        $originalAvailable = $product->available;
        $lastValue = $product->value;
        $product->fill($modification);
        $product->active = $group->active;

        if ($product->id && isset($originalAvailable) && $originalAvailable !== (int)$product->available && (int)$product->available) {
            Event::fire(new ChangeProductStatusEvent($product->id));
        }

        $product->save();
        $needsFeatureRebase = $product->wasRecentlyCreated || $product->wasChanged('value_id');
        $product = $product->fresh();
        // Translations
        foreach (config('languages') as $lang => $language) {
            ProductTranslates::createOrUpdateFromArray($lang, array_get($modification, $lang, []), $product->id, $group, $product->value);
        }
        // Main feature
        if ($needsFeatureRebase) {
            ProductGroupFeatureValue::change($group, $product, $lastValue, $product->value);
        }
        // Upload images
        foreach (array_get($modification, 'images', []) as $image) {
            /** @var UploadedFile $image */
            $product->uploadImageFromResource($image);
        }
        // Wholesales
        $quantities = explode(';', array_get($modification, 'wholesaleQuantities'));
        $prices = explode(';', array_get($modification, 'wholesalePrices'));
        $product->addWholesales($quantities, $prices);
        return $product;
    }

    /**
     * @param array $quantities
     * @param array $prices
     * @throws \Exception
     */
    public function addWholesales(array $quantities, array $prices): void
    {
        ProductWholesale::whereProductId($this->id)->delete();
        foreach ($quantities as $key => $value) {
            if (array_get($quantities, $key) && array_get($prices, $key)) {
                ProductWholesale::whereProductId($this->id)
                    ->firstOrCreate([
                        'product_id' => $this->id,
                        'quantity' => array_get($quantities, $key),
                        'price' => array_get($prices, $key),
                    ]);
            }
        }
    }

    /**
     * @param Collection|LengthAwarePaginator|Product[]|Product $products
     */
    public static function loadMissingForLists($products): void
    {
        $products->loadMissing(
            'group', 'current', 'images', 'images.current', 'group.comments',
            'labels', 'labels.current', 'group.current', 'group.images', 'group.images.current',
            'value', 'value.current'
        );

        if (config('db.products.show-brand-in-item-card', true)) {
            $products->loadMissing(
                'brand',
                'brand.current'
            );
        }

        if (config('db.products.show-main-features')) {
            $products->loadMissing(
                'group.featureValues',
                'group.featureValues.value',
                'group.featureValues.feature',
                'group.featureValues.value.current',
                'group.featureValues.feature.current'
            );
        }
    }

    /**
     * @param array|null $productIds
     * @param int|null $ignoredId
     * @param int $limit
     * @return Collection
     */
    public static function getByIdsListWithIgnoredOne(?array $productIds = null, ?int $ignoredId = null, int $limit = 10): Collection
    {
        $productIds = $productIds ?? [];
        $query = Product::whereIn('id', $productIds);
        if ($ignoredId) {
            $query->where('id', '!=', $ignoredId);
        }
        return $query
            ->where('active', true)
            ->latest('available')
            ->limit($limit ?: 10)
            ->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(ProductGroup::class, 'group_id', 'id');
    }

    /**
     * @return Collection|ProductGroup[]
     */
    public function getRelatedAttribute(): Collection
    {
        $groups = new Collection();
        $this->group->related->each(function (ProductGroup $group) use ($groups) {
            if ($group->active) {
                $groups->push($group);
            }
        });
        return $groups;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function labels()
    {
        $relation = $this->hasManyThrough(
            Label::class,
            ProductGroupLabel::class,
            'group_id',
            'id',
            'group_id',
            'label_id'
        );
        if (config('app.place') === 'site') {
            $relation->where('active', true);
        }
        return $relation;
    }

    /**
     * Product image configurations class
     *
     * @return string
     */
    protected function imageClass()
    {
        return ProductImage::class;
    }

    /**
     * Register filter model
     *
     * @return string
     */
    public function modelFilter()
    {
        if (config('app.place') === 'site') {
            return $this->provideFilter(SearchFilter::class);
        }
        return $this->provideFilter(ProductsAdminFilter::class);
    }

    /**
     * Information for admin
     *
     * @return string
     */
    public function getFormattedPriceForAdminAttribute(): string
    {
        if (Catalog::currenciesLoaded()) {
            return Catalog::currency()->formatForAdmin($this->price);
        }
        return $this->price;
    }

    /**
     * Information for client
     *
     * @return string
     */
    public function getFormattedPriceAttribute(): string
    {
        if (Catalog::currenciesLoaded()) {
            return Catalog::currency()->format($this->price);
        }
        return $this->price_for_site;
    }

    /**
     * Price for client
     *
     * @return float
     */
    public function getPriceForSiteAttribute(): float
    {
        if (Catalog::currenciesLoaded()) {
            return Catalog::currency()->calculate($this->price);
        }
        return $this->price;
    }

    /**
     * Information for admin
     *
     * @return string
     */
    public function getFormattedOldPriceForAdminAttribute(): ?string
    {
        if (!$this->old_price) {
            return null;
        }
        if (Catalog::currenciesLoaded()) {
            return Catalog::currency()->formatForAdmin($this->old_price);
        }
        return $this->old_price;
    }

    /**
     * Information for client
     *
     * @return string
     */
    public function getFormattedOldPriceAttribute(): ?string
    {
        if (!$this->old_price_for_site) {
            return null;
        }
        if (Catalog::currenciesLoaded()) {
            return Catalog::currency()->format($this->old_price);
        }
        return $this->old_price_for_site;
    }

    /**
     * Price for client
     *
     * @return int
     */
    public function getOldPriceForSiteAttribute(): float
    {
        if (!$this->old_price) {
            return 0;
        }
        if (Catalog::currenciesLoaded()) {
            return Catalog::currency()->calculate($this->old_price);
        }
        return $this->old_price;
    }

    /**
     * Product url on the site
     *
     * @return string
     */
    public function getSiteLinkAttribute(): string
    {
        return route('site.product', ['slug' => $this->current->slug]);
    }

    /**
     * Searching on the site
     *
     * @param int|null $limit
     * @param array $ignored
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Collection|Product[]
     */
    public static function search(?int $limit = null, array $ignored = [])
    {
        $forFilter = request()->only('query', 'order');
        $forFilter['order'] = $forFilter['order'] ?? 'default';
        $productsQuery = Product::active()
            ->whereNotIn('id', $ignored)
            ->filter($forFilter);
        $limit = (int)$limit ?: request()->query('per-page');
        $products = $productsQuery->paginate(
            $limit ?: config('db.products.site-per-page', static::LIMIT_PER_PAGE_BY_DEFAULT)
        );
        return $products;
    }

    /**
     * @param int|null $limit
     * @return LengthAwarePaginator
     */
    public static function getList(?int $limit = null): LengthAwarePaginator
    {
        return Product::with('current', 'group', 'group.otherCategories', 'group.brand')
            ->filter(request()->all())
            ->latest('id')
            ->paginate($limit ?: config(
                'db.products.per-page',
                Product::LIMIT_PER_PAGE_BY_DEFAULT_ADMIN_PANEL
            ));
    }

    /**
     * @return int|null
     */
    public function getBrandIdAttribute(): ?int
    {
        return $this->group ? $this->group->brand_id : null;
    }

    /**
     * @param int $categoryId
     * @return float
     */
    public static function getMinPriceInCategory(int $categoryId): float
    {
        return (float)Product::whereHas('group.otherCategories', function (Builder $builder) use ($categoryId) {
            return $builder->where('category_id', $categoryId);
        })->active(true)->min('price');
    }

    /**
     * @param int $categoryId
     * @return float
     */
    public static function getMaxPriceInCategory(int $categoryId): float
    {
        return (float)Product::whereHas('group.otherCategories', function (Builder $builder) use ($categoryId) {
            return $builder->where('category_id', $categoryId);
        })->active(true)->max('price');
    }

    /**
     * @return Collection|ProductGroupFeatureValue[]
     */
    public function getFeatureValuesAttribute()
    {
        $collection = new Collection();
        $group = $this->group;
        $added = [];
        $group->featureValues->each(function (ProductGroupFeatureValue $featureValue) use ($collection, $group, &$added) {
            if ($group->feature_id === $featureValue->feature_id && $this->value_id !== $featureValue->value_id) {
                return;
            }
            if (in_array($featureValue->value_id, $added)) {
                return;
            }
            $added[] = $featureValue->value_id;
            $collection->push($featureValue);
        });
        return $collection;
    }

    /**
     * @return array
     */
    public function getFeaturesListAttribute(): array
    {
        $group = $this->group;
        $values = [];
        if ($this->brand && $this->brand->active) {
            $values[trans('products::site.brand')] = [
                \Html::link($this->brand->link, $this->brand->current->name),
            ];
        }
        if ($group->feature_id && $this->value_id) {
            $values[$group->feature->current->name] = [$this->value->current->name];
        }
        $featureValues = $group->featureValues;
        $featureValues->load('value', 'value.current', 'feature', 'feature.current');
        $featureValues = $featureValues->sortBy('feature.position');
        $featureValues->each(function (ProductGroupFeatureValue $featureValue) use (&$values, $group) {
            if (
                $group->feature_id && $group->feature_id === $featureValue->feature_id &&
                $this->value_id && $this->value_id !== $featureValue->value_id
            ) {
                return;
            }
            if (isset($values[$featureValue->feature->current->name])) {
                $values[$featureValue->feature->current->name][] = $featureValue->value->current->name;
            } else {
                $values[$featureValue->feature->current->name] = [$featureValue->value->current->name];
            }
        });
        foreach ($values as $featureName => $featureValues) {
            $featureValues = array_unique($featureValues);
            $values[$featureName] = implode(', ', $featureValues);
        }
        return $values;
    }

    /**
     * @return array
     */
    public function getFeaturesDescListAttribute(): array
    {
        $group = $this->group;
        $values = [];

        if ($this->brand && $this->brand->active) {
            $values[trans('products::site.brand')] = [
                \Html::link($this->brand->link, $this->brand->current->name),
            ];
        }

        if ($group->feature_id && $this->value_id) {
            $values[$group->feature->current->name] = [$this->value->current->name];
        }
        $featureValues = $group->featureValues;
        $featureValues->load('value', 'value.current', 'feature', 'feature.current');
        $featureValues = $featureValues->sortBy('feature.position');
        $featureValues->each(function (ProductGroupFeatureValue $featureValue) use (&$values, $group) {
            if (
                $group->feature_id && $group->feature_id === $featureValue->feature_id &&
                $this->value_id && $this->value_id !== $featureValue->value_id || $featureValue->feature->in_desc == 0
            ) {
                return;
            }

            if (isset($values[$featureValue->feature->current->name])) {

                $values[$featureValue->feature->current->name][] = $featureValue->value->current->name;
            } else {
                $values[$featureValue->feature->current->name] = [$featureValue->value->current->name];
            }
        });

        foreach ($values as $featureName => $featureValues) {
            $featureValues = array_unique($featureValues);
            $values[$featureName] = implode(', ', $featureValues);
        }
        return $values;
    }

    /**
     * @return array
     */
    public function getFeatureValuesAsArrayAttribute(): array
    {
        $dictionary = [];
        $this->feature_values->each(function (ProductGroupFeatureValue $featureValue) use (&$dictionary) {
            $dictionary[$featureValue->feature_id] = array_get($dictionary, $featureValue->feature_id, []);
            $dictionary[$featureValue->feature_id][] = $featureValue->value_id;
        });
        return $dictionary;
    }

    /**
     * @return Collection
     */
    public function getTabsAttribute(): Collection
    {
        $tabs = new Collection();
        $tabs->put('main', [
            'name' => __('products::site.all-about-product'),
            'widget' => \Widget::show('products::tab-main', $this),
        ]);
        $tabs->put('description', [
            'name' => __('products::site.description'),
            'widget' => \Widget::show('products::tab-description', $this),
        ]);
        $tabs->put('features', [
            'name' => __('products::site.features'),
            'widget' => \Widget::show('products::tab-features', $this),
        ]);
        $tabs->put('review', [
            'name' => __('products::site.reviews'),
            'widget' => \Widget::show('products::tab-reviews', $this),
            'count' => $this->group->comments->count(),
        ]);
        return $tabs;
    }

    public static function getOne(int $productId)
    {
        return Product::whereId($productId)
            ->active(true)
            ->first();
    }

    public static function getMany(array $productsIds)
    {
        if (!$productsIds) {
            return new Collection();
        }
        return Product::with('current', 'images', 'images.current')
            ->whereIn('id', $productsIds)
            ->active(true)
            ->get();
    }

    /**
     * @return string|null
     */
    public function getMicrodataAttribute(): ?string
    {
        if (!config('db.microdata.product', true)) {
            return null;
        }
        $data = [
            '@context' => 'http://schema.org/',
            '@type' => 'Product',
            'name' => $this->name,
            'image' => $this->preview ? $this->preview->link('small') : '',
        ];
        if (Seo::site()->getDescription()) {
            $data['description'] = Seo::site()->getDescription();
        }
        if ($this->group->brand) {
            $data['brand'] = $this->group->brand->current->name;
        }
        if ($this->vendor_code) {
            $data['sku'] = $this->vendor_code;
        }
        $data['offers'] = [
            '@type' => 'Offer',
            'priceCurrency' => Catalog::currency()->microdataName() ?: 'UAH',
            'price' => $this->price,
            'url' => $this->site_link,
            'availability' => 'http://schema.org/' . ($this->available === Product::NOT_AVAILABLE ? 'OutOfStock' : 'InStock'),
            'itemCondition' => 'http://schema.org/NewCondition',
        ];
        if ($this->group->comments && $this->group->comments->isNotEmpty() && $this->group->mark > 0) {
            $data['aggregateRating'] = [
                '@type' => 'AggregateRating',
                'ratingValue' => $this->group->mark,
                'ratingCount' => $this->group->comments->count(),
            ];
        }
        return json_encode($data);
    }

    /**
     * @return string
     */
    public function getMainFeaturesAttribute(): string
    {
        $features = [];
        foreach ($this->feature_values as $productFeatureValue) {
            if ($productFeatureValue->feature_id !== $this->group->feature_id && $productFeatureValue->value && $productFeatureValue->feature->main) {
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wholesale()
    {
        return $this->hasMany(ProductWholesale::class, 'product_id', 'id');
    }

    /**
     * @param int $quantity
     * @return float
     */
    public function getPriceForCart(int $quantity): float
    {
        if ($quantity < 2) {
            return $this->price;
        }

        $wholesale = $this->wholesale
            ->where('quantity', '<=', $quantity)
            ->sort(function (ProductWholesale $prev, ProductWholesale $current) {
                return $prev->quantity < $current->quantity || (
                        $prev->id < $current->id && $current->quantity === $prev->quantity
                    );
            })
            ->first();

        if ($wholesale) {
            return $quantity * $wholesale->price;
        }

        return $quantity * $this->price;
    }

    /**
     * Set current product as main product in group
     */
    public function setAsMain(): void
    {
        if ($this->group) {
            $this->group->products->each(function (Product $product) {
                if ($product->is_main) {
                    $product->update([
                        'is_main' => false,
                    ]);
                }
            });
        }
        $this->update([
            'is_main' => true,
        ]);
    }

    public static function getCategoriesIdsByProductsIds(array $ids): array
    {
        $categoryIds = [];
        ProductGroup::select('category_id')->whereHas('products', function (Builder $query) use ($ids) {
            $query->whereIn('id', $ids);
        })->get()->each(function (ProductGroup $group) use (&$categoryIds) {
            $categoryIds[] = $group->category_id;
        })->toArray();
        return $categoryIds;
    }

}
