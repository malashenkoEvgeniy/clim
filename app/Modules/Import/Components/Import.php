<?php

namespace App\Modules\Import\Components;

use App\Components\Parsers\AbstractParser;
use App\Components\Parsers\Entry;
use App\Modules\Currencies\Models\Currency;
use App\Modules\Import\Models\CategoriesRemote;
use App\Modules\Import\Models\ProductsGroupsRemote;
use Illuminate\Support\Collection;
use App\Modules\Brands\Models\Brand as BrandModel;
use App\Modules\Features\Models\Feature as FeatureModel;
use App\Modules\Features\Models\FeatureValue as FeatureValueModel;
use App\Modules\Products\Models\ProductTranslates as ProductTranslatesModel;
use App\Modules\Products\Models\ProductGroup as ProductGroupModel;
use App\Modules\Products\Models\Product as ProductModel;
use App\Modules\Categories\Models\Category as CategoryModel;
use App\Modules\Categories\Models\CategoryTranslates as CategoryTranslatesModel;
use App\Modules\Import\Components\Parts\Brand;
use App\Modules\Import\Components\Parts\Category;
use App\Modules\Import\Components\Parts\Feature;
use App\Modules\Import\Components\Parts\FeatureValue;
use App\Modules\Import\Components\Parts\Product;
use Illuminate\Support\Str;

/**
 * Class Import
 *
 * @package App\Modules\Import\Components
 */
class Import
{
    /**
     * Type of parsing
     *
     * @var string
     */
    private $type;
    
    /**
     * @var AbstractParser
     */
    private $parser;
    
    /**
     * @var Collection
     */
    public $productsSlugs;
    
    /**
     * @var Collection
     */
    public $categoriesSlugs;
    
    /**
     * @var array
     */
    public $productsToRemote;
    
    /**
     * @var array
     */
    public $innerToRemoteCategories;
    
    /**
     * @var array
     */
    public $remoteToInnerCategories;
    
    /**
     * @var Collection|Category[]
     */
    public $categories;
    
    /**
     * @var Collection|Brand[]
     */
    public $brands;
    
    /**
     * @var Collection|Feature[]
     */
    public $features;
    
    /**
     * @var ImportSettings
     */
    protected $settings;
    
    /**
     * @var string
     */
    protected $path;
    
    /**
     * Import constructor.
     *
     * @param string $path
     * @param ImportSettings|null $settings
     * @param string|null $type
     */
    public function __construct(string $path, ?ImportSettings $settings = null, ?string $type = null)
    {
        $this->categories = new Collection();
        $this->brands = new Collection();
        $this->features = new Collection();
        $this->productsSlugs = new Collection();
        $this->path = $path;
        $this->settings = $settings ?? new ImportSettings();
        $this->type = $type ?? Entry::TYPE_PROM_UA;
    }
    
    /**
     * @throws \Throwable
     */
    public function start(): void
    {
        $this->parse();
        $this->existedData();
        if ($this->settings->updateCategories === true) {
            $this->importCategories();
        }
        if ($this->settings->updateProducts === true) {
            $this->importProducts();
        }
    }
    
    /**
     * @throws \Throwable
     */
    private function parse(): void
    {
        $this->parser = Entry::getParser($this->type, $this->path);
        $this->parser->start();
    }
    
    /**
     * @return AbstractParser
     */
    public function getParser(): AbstractParser
    {
        return $this->parser;
    }
    
    /**
     * Load existed data to the memory
     */
    private function existedData(): void
    {
        // Save existed products slugs to the memory
        $this->fillProductsSlugs();
        // Save existed categories slugs to the memory
        $this->fillCategoriesSlugs();
        // Add products relations with remote
        $this->fillProductsRelationsWithRemote();
        // Add existed brands to list
        $this->fillWithExistedBrands();
        // Add existed features to list
        $this->fillWithExistedFeatures();
        // Add categories relations with remote
        $this->fillCategoriesRelationsWithRemote();
        // Add existed categories to list
        $this->fillWithExistedCategories();
    }
    
    /**
     * @throws \Throwable
     */
    private function importCategories(): void
    {
        $doNotDisableCategoriesIds = [];
        foreach ($this->getParser()->getCategories() as $parsedCategory) {
            // Generate parsed category object
            $category = $this->getCategoryRemoteId($parsedCategory->remoteCategoryId);
            if ($category === null) {
                $category = new Category($parsedCategory, $this->parser->getSystem());
                if ($this->categorySlugExists($category->getSlug())) {
                    $category->setSlug($category->getSlug() . '-' . random_int(100000, 999999));
                }
                if (isset($this->remoteToInnerCategories[$category->getRemoteId()])) {
                    $category->setId($this->remoteToInnerCategories[$category->getRemoteId()]);
                }
                if (isset($this->remoteToInnerCategories[$category->getRemoteParentId()])) {
                    $category->setParentId($this->remoteToInnerCategories[$category->getRemoteParentId()]);
                }
                $category->create();
                if ($category->getId() && $category->getRemoteId()) {
                    $this->remoteToInnerCategories[$category->getRemoteId()] = $category->getId();
                    $this->innerToRemoteCategories[$category->getId()] = $category->getRemoteId();
                }
                // Push to categories list
                $this->categories->put($category->getRemoteId(), $category);
            } else {
                $category->update($parsedCategory);
            }
            if ($this->settings->disableOldCategories === true && $category->getId()) {
                $doNotDisableCategoriesIds[] = $category->getId();
            }
        }
        $this->categories->each(function (Category $category) {
            if ($category->getParentId() || !$category->getId()) {
                return;
            }
            if (!$category->getRemoteParentId() || !isset($this->remoteToInnerCategories[$category->getRemoteParentId()])) {
                return;
            }
            $category->setParentId($this->remoteToInnerCategories[$category->getRemoteParentId()]);
            CategoryModel::whereId($category->getId())->update([
                'parent_id' => $category->getParentId(),
            ]);
        });
        if ($this->settings->disableOldCategories === true) {
            CategoryModel::query()->update([
                'active' => false,
            ]);
            foreach (array_chunk($doNotDisableCategoriesIds, 500) as $chunkWithIds) {
                CategoryModel::whereIn('id', $chunkWithIds)->update([
                    'active' => true,
                ]);
            }
        }
    }
    
    /**
     * @throws \Throwable
     */
    private function importProducts(): void
    {
        $doNotDisableProductsIds = [];
        foreach ($this->getParser()->getProducts() as $parsedProduct) {
            if (!$parsedProduct->price) {
                $parsedProduct->price = 0;
            }

            if (!$parsedProduct->currency) {
                $parsedProduct->currency = Currency::getDefaultOnSite();
            }

            // Generate parsed product object
            $product = new Product($parsedProduct, $this->parser->getSystem(), $this->settings->courses->get($parsedProduct->currency, 1));
            $product->setSlug($this->repairSlugs($product->getSlugs()));
            $this->productsSlugs->merge($product->getSlugs());
            if (isset($this->productsToRemote[$product->getRemoteProductId()])) {
                $product->setId($this->productsToRemote[$product->getRemoteProductId()]);
            }
            // Link brand
            $this->addBrand($product, $parsedProduct->brand);
            // Link features
            foreach ($parsedProduct->features as $index => $feature) {
                if (!$feature || !$parsedProduct->featuresValues[$index]) {
                    continue;
                }
                $feature = $this->searchOrCreateFeature($feature);
                foreach (explode('|', array_get($parsedProduct->featuresValues, $index)) ?: [] as $valueName) {
                    if (!trim($valueName)) {
                        continue;
                    }
                    $featureValue = $feature->addValue($valueName, array_get($parsedProduct->featuresMeasures, $index));
                    $featureValue->addProduct($product);
                    $product->addFeatureValue($featureValue);
                }
            }
            // Remove parsedProduct variable from the memory
            unset($parsedProduct);
            // Create or update product data
            $product->create($product->getRemoteCategoryId() ? array_get($this->remoteToInnerCategories, $product->getRemoteCategoryId()) : null);
            // Add images
            if ($product->getModel() && $this->settings->images !== ImportSettings::IMAGES_DO_NOT_UPLOAD) {
                if ($this->settings->images === ImportSettings::IMAGES_REWRITE) {
                    $product->getModel()->deleteImagesIfExist();
                }
                foreach ($product->getImages() as $image) {
                    $product->uploadImage($image);
                }
            }
            if ($this->settings->disableOldProducts === true && $product->getId()) {
                $doNotDisableProductsIds[] = $product->getId();
            }
        }
        if ($this->settings->disableOldProducts === true) {
            ProductGroupModel::query()->update([
                'active' => false,
            ]);
            ProductModel::query()->update([
                'active' => false,
            ]);
            foreach (array_chunk($doNotDisableProductsIds, 500) as $chunkWithIds) {
                ProductGroupModel::whereIn('id', $chunkWithIds)->update([
                    'active' => true,
                ]);
                ProductModel::whereIn('group_id', $chunkWithIds)->update([
                    'active' => true,
                ]);
            }
        }
    }
    
    /**
     * @param string $featureName
     * @return Feature
     * @throws \Exception
     */
    private function searchOrCreateFeature(string $featureName): Feature
    {
        $slug = Str::slug($featureName);
        $slug = Str::substr($slug, 0, 190);
        if ($this->features->has($slug)) {
            return $this->features->get($slug);
        }
        $feature = new Feature();
        $feature->setName($featureName);
        $feature->setSlug($slug);
        $feature->create();
        $this->features->put($slug, $feature);
        return $feature;
    }
    
    /**
     * @param Product $product
     * @param string $newBrandName
     * @throws \Exception
     */
    private function addBrand(Product $product, ?string $newBrandName): void
    {
        if (!$newBrandName) {
            return;
        }
        $slug = Str::slug($newBrandName);
        if ($this->brands->has($slug)) {
            $product->setBrand($this->brands->get($slug));
            return;
        }
        $brand = new Brand();
        $brand->setName($newBrandName);
        $brand->setSlug($slug);
        $brand->create();
        $this->brands->put($brand->getSlug(), $brand);
        $product->setBrand($brand);
    }
    
    /**
     * @param int $remoteCategoryId
     * @return Category|null
     */
    private function getCategoryRemoteId(int $remoteCategoryId): ?Category
    {
        foreach ($this->categories as $category) {
            if ($category->getRemoteId() === $remoteCategoryId) {
                return $category;
            }
        }
        return null;
    }
    
    /**
     * Add existed brands to list
     */
    private function fillWithExistedBrands(): void
    {
        BrandModel::with('current')->get()->each(function (BrandModel $model) {
            if (!$model->current || !$model->current->exists) {
                $model->delete();
                return;
            }
            $brand = new Brand();
            $brand->setModel($model);
            $this->brands->put($brand->getSlug(), $brand);
        });
    }
    
    /**
     * Add existed features and values to list
     */
    private function fillWithExistedFeatures(): void
    {
        FeatureModel::with(['current', 'values', 'values.current'])->get()->each(function (FeatureModel $model) {
            if (!$model->current || !$model->current->exists) {
                $model->delete();
                return;
            }
            $feature = new Feature();
            $feature->setModel($model);
            $this->features->put($feature->getSlug(), $feature);
            
            $model->values->each(function (FeatureValueModel $value) use ($feature) {
                if (!$value->current || !$value->current->exists) {
                    $value->delete();
                    return;
                }
                $featureValue = new FeatureValue();
                $featureValue->setModel($value);
                $feature->addExistedValue($featureValue);
            });
        });
    }
    
    /**
     * Get all products slugs
     */
    private function fillProductsSlugs(): void
    {
        $this->productsSlugs = ProductTranslatesModel::select(['slug'])->get()->flatMap(function (ProductTranslatesModel $translate) {
            return [$translate->slug];
        });
    }
    
    /**
     * Get all products slugs
     */
    private function fillCategoriesSlugs(): void
    {
        $this->categoriesSlugs = CategoryTranslatesModel::select(['slug'])->get()->flatMap(function (CategoryTranslatesModel $translate) {
            return [$translate->slug];
        });
    }
    
    /**
     * Relations with prom ua products
     */
    private function fillProductsRelationsWithRemote(): void
    {
        ProductsGroupsRemote::whereSystem($this->parser->getSystem())->get()->each(function (ProductsGroupsRemote $relation) {
            $this->productsToRemote[$relation->remote_id] = $relation->group_id;
        });
    }
    
    /**
     * Relations with prom ua categories
     */
    private function fillWithExistedCategories(): void
    {
        CategoryModel::with('current')->get()->each(function (CategoryModel $model) {
            $category = new Category($this->parser->createEmptyParsedCategoryObject(), $this->parser->getSystem());
            $category->setModel($model);
            if (isset($this->innerToRemoteCategories[$model->id])) {
                $category->setRemoteId($this->innerToRemoteCategories[$model->id]);
            }
            if (isset($this->innerToRemoteCategories[$model->parent_id])) {
                $category->setRemoteParentId($this->innerToRemoteCategories[$model->parent_id]);
            }
            $this->categories->push($category);
        });
    }
    
    /**
     * Relations with prom ua categories
     */
    private function fillCategoriesRelationsWithRemote(): void
    {
        CategoriesRemote::whereSystem($this->parser->getSystem())->get()->each(function (CategoriesRemote $relation) {
            $this->remoteToInnerCategories[$relation->remote_id] = $relation->category_id;
            $this->innerToRemoteCategories[$relation->category_id] = $relation->remote_id;
        });
    }
    
    /**
     * @param array $slugs
     * @return array
     * @throws \Exception
     */
    private function repairSlugs(array $slugs): array
    {
        foreach ($slugs as &$slug) {
            if($this->productsSlugs->search($slug) !== false) {
                $slug .= random_int(10000, 99999);
            }
        }
        return $slugs;
    }
    
    /**
     * @param string|null $slug
     * @return bool
     */
    private function categorySlugExists(?string $slug): bool
    {
        return $this->categoriesSlugs->search($slug) !== false;
    }
    
}
