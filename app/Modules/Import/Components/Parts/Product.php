<?php

namespace App\Modules\Import\Components\Parts;

use App\Components\Parsers\AbstractParsedProduct;
use App\Modules\Import\Models\ProductsGroupsRemote;
use App\Modules\Products\Models\ProductGroupFeatureValue;
use App\Modules\Products\Models\ProductWholesale;
use App\Modules\ProductsAvailability\Events\ChangeProductStatusEvent;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Modules\Products\Models\Product as ProductModel;
use App\Modules\Products\Models\ProductGroup as ProductGroupModel;
use App\Modules\Products\Models\ProductTranslates as ProductTranslatesModel;
use App\Modules\Products\Models\ProductGroupTranslates as ProductGroupTranslatesModel;
use Storage, Event;

/**
 * Class Product
 *
 * @package App\Modules\Import\Components\Parts
 */
class Product
{
    /**
     * Group ID
     *
     * @var int|null
     */
    protected $id;

    /**
     * Vendor code
     *
     * @var string
     */
    protected $vendorCode;

    /**
     * Images links list
     *
     * @var array
     */
    protected $images = [];

    /**
     * @var string|null
     */
    protected $name;

    /**
     * @var float|int
     */
    protected $price;

    /**
     * @var float|int|null
     */
    protected $oldPrice;

    /**
     * @var string|null
     */
    protected $keywords;

    /**
     * @var string|null
     */
    protected $content;

    /**
     * @var int|null
     */
    protected $remoteProductId;

    /**
     * @var array
     */
    protected $slugs = [];

    /**
     * @var int
     */
    protected $availability;

    /**
     * @var Brand
     */
    protected $brand;

    /**
     * @var Collection|FeatureValue[]
     */
    protected $featureValues;

    /**
     * @var int
     */
    protected $mainFeatureId;

    /**
     * @var Collection|FeatureValue[]
     */
    protected $mainFeatureValues;

    /**
     * @var int|null
     */
    protected $remoteCategoryId;

    /**
     * @var bool
     */
    protected $active = true;

    /**
     * @var ProductGroupModel
     */
    protected $model;

    /**
     * @var ProductModel[]
     */
    protected $productModifications;

    /**
     * @var Collection|ProductWholesale[]
     */
    protected $wholesalePrice;

    /**
     * @var Collection|ProductWholesale[]
     */
    protected $minUnitsForWholeSale;

    /**
     * @var null|string
     */
    protected $system;

    /**
     * @var string
     */
    protected $remoteProductUrl;

    /**
     * Product constructor.
     *
     * @param AbstractParsedProduct $parsedProduct
     * @param float $priceMultiplier
     * @param null|string $system
     */
    public function __construct(AbstractParsedProduct $parsedProduct, ?string $system, float $priceMultiplier = 1)
    {
        $this->featureValues = new Collection();
        $this->mainFeatureValues = new Collection();
        $this->productModifications = new Collection();
        $this->name = $parsedProduct->name;
        $this->price = (float)$parsedProduct->price * $priceMultiplier;
        if ($this->price > 100000000) {
            $this->price = 0;
            $this->active = false;
        }
        $this->vendorCode = $parsedProduct->vendorCode;
        $this->keywords = $parsedProduct->keywords;
        $this->content = $parsedProduct->content;
        $this->id = (int)$parsedProduct->productId ?: null;
        $this->remoteProductId = (int)$parsedProduct->remoteUniqueIdentifier ?: null;
        $this->images = $parsedProduct->images;
        $this->availability = $parsedProduct->availability;
        $this->remoteCategoryId = $parsedProduct->remoteCategoryId;
        $this->generateOldPrice($parsedProduct->discount, $priceMultiplier);
        $this->remoteProductUrl = $parsedProduct->productUrl;
        $this->wholesalePrice = $parsedProduct->wholesalePrice;
        $this->minUnitsForWholeSale = $parsedProduct->minUnitsForWholeSale;
        $this->system = $system;
    }

    /**
     * @return array
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @return int|null
     */
    public function getRemoteCategoryId(): ?int
    {
        return $this->remoteCategoryId;
    }

    /**
     * @return array
     */
    public function getSlugs(): array
    {
        return $this->slugs;
    }

    /**
     * @param array $slugs
     */
    public function setSlug(array $slugs): void
    {
        $this->slugs = $slugs;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getRemoteProductId(): ?int
    {
        return $this->remoteProductId;
    }

    /**
     * @param string|null $discount
     * @param int $priceMultiplier
     */
    private function generateOldPrice(?string $discount, int $priceMultiplier): void
    {
        if (!$discount) {
            return;
        }
        if (Str::endsWith($discount, '%')) {
            $this->oldPrice = (float)number_format($this->price * (1 + (float)$discount / 100), 2, '.', '');
        } else {
            $this->oldPrice = $this->price + $discount;
        }
        $this->oldPrice *= $priceMultiplier;
    }

    /**
     * @param Brand $brand
     * @return self
     */
    public function setBrand(Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @param FeatureValue $value
     * @return self
     */
    public function addFeatureValue(FeatureValue $value): self
    {
        if (!$this->mainFeatureId) {
            $this->mainFeatureId = $value->getFeatureId();
        }
        if ($this->mainFeatureId === $value->getFeatureId()) {
            $this->mainFeatureValues->push($value);
        } else {
            $this->featureValues->push($value);
        }

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMainFeatureId(): ?int
    {
        return $this->mainFeatureId;
    }

    /**
     * @return bool
     */
    public function hasFeatures(): bool
    {
        return $this->mainFeatureValues->isNotEmpty();
    }

    /**
     * @param int|null $id
     * @return self
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return ProductGroupModel
     */
    public function getModel(): ProductGroupModel
    {
        return $this->model;
    }

    /**
     * @param int|null $categoryId
     * @throws \Throwable
     */
    public function create(?int $categoryId = null): void
    {
        try {
            // Product
            $this->updateOrCreateProduct($categoryId);
            // Store product id
            $this->setId($this->model->id);
            // Link to remote ID
            $this->linkToRemote();
            // Link features to products
            $this->linkFeaturesToProduct();
            // Link wholesale to products
            $this->linkWithWholesale();
        } catch (\Exception $exception) {
            dump($exception->getMessage());
            dd($this);
        }
    }

    /**
     * @throws \Exception
     */
    public function linkWithWholesale()
    {
        $productId = $this->getId();
        if (!$productId) {
            return;
        }
        $quantities = explode(';', $this->minUnitsForWholeSale);
        $prices = explode(';', $this->wholesalePrice);
        ProductWholesale::whereProductId($productId)->delete();
        if (!array_get($quantities, 0)) {
            return;
        }
        foreach ($quantities as $key => $value) {
            if (array_get($quantities, $key) && array_get($prices, $key)) {
                ProductWholesale::whereProductId($productId)
                    ->firstOrCreate([
                        'product_id' => $productId,
                        'quantity' => (int)array_get($quantities, $key),
                        'price' => (float)array_get($prices, $key),
                    ]);
            }
        }
    }

    /**
     * @throws \Exception
     */
    private function linkFeaturesToProduct(): void
    {
        $this->featureValues->each(function (FeatureValue $value) {
            if ($value->inProduct($this->id)) {
                $this->model->products->each(function (ProductModel $product) use ($value) {
                    if ($value->getFeatureId() && $value->getId()) {
                        ProductGroupFeatureValue::linkByIds($product->group_id, $product->id, $value->getFeatureId(), $value->getId());
                    }
                });
            }
        });
    }

    /**
     * @param int|null $categoryId
     * @return ProductGroupModel
     * @throws \Throwable
     */
    private function updateOrCreateProduct(?int $categoryId = null): ProductGroupModel
    {
        if ($this->id) {
            $this->model = ProductGroupModel::find($this->id);
        }
        if (!$this->model) {
            $this->model = $this->createProduct($categoryId);
        } else {
            $this->setId($this->model->id);
            $this->updateProduct($categoryId);
        }
        $this->model->updatePrices();
        $this->model->syncOtherCategories([], $this->model->category_id);
        return $this->model;
    }

    /**
     * @param int|null $categoryId
     * @return ProductGroupModel
     * @throws \Throwable
     */
    private function createProduct(?int $categoryId = null): ProductGroupModel
    {
        $createModifications = $this->mainFeatureId && $this->mainFeatureValues->isNotEmpty();

        $group = new ProductGroupModel;
        $group->position = 500;
        $group->brand_id = $this->brand ? $this->brand->getId() : null;
        $group->active = $categoryId ? true : false;
        $group->category_id = $categoryId;
        $group->feature_id = $createModifications ? $this->mainFeatureId : null;
        $group->saveOrFail();
        // Save it
        $this->model = $group;
        // Product group translates
        foreach (config('languages', []) as $languageAlias => $language) {
            $translate = new ProductGroupTranslatesModel;
            $translate->name = Str::substr($this->name, 0, 190);
            $translate->text = $this->content;
            $translate->row_id = $group->id;
            $translate->language = $languageAlias;
            $translate->save();
        }
        // Products
        if ($createModifications) {
            $isMain = true;
            foreach ($this->mainFeatureValues as $value) {
                $this->createModification($group, $value, $isMain);
                $isMain = false;
            }
        } else {
            $this->createModification($group, null, true);
        }

        return $group;
    }

    /**
     * @param ProductGroupModel $group
     * @param FeatureValue|null $value
     * @param bool $isMain
     * @throws \Throwable
     */
    public function createModification(ProductGroupModel $group, ?FeatureValue $value = null, bool $isMain = false)
    {
        $product = new ProductModel;
        $product->active = $group->active;
        $product->brand_id = $group->brand_id;
        $product->available = $this->availability;
        $product->price = $this->price;
        $product->old_price = $this->oldPrice;
        $product->vendor_code = $this->vendorCode ?: null;
        $product->position = 500;
        $product->group_id = $group->id;
        $product->is_main = $isMain;
        $product->value_id = $value ? $value->getId() : null;
        $product->saveOrFail();
        // Product translates
        foreach (config('languages', []) as $languageAlias => $language) {
            $translate = new ProductTranslatesModel;
            $translate->name = '';
            $translate->hidden_name = Str::substr($this->name, 0, 190);
            $translate->slug = $this->generateSlug($value);
            $translate->keywords = $this->keywords;
            $translate->row_id = $product->id;
            $translate->language = $languageAlias;
            $translate->save();
        }

        $this->productModifications->push($product);
    }

    /**
     * @param FeatureValue|null $value
     * @return string
     * @throws \Exception
     */
    private function generateSlug(?FeatureValue $value): string
    {
        if ($this->remoteProductUrl) {
            $urlParts = explode('/', $this->remoteProductUrl);
            $lastUrlPart = end($urlParts);
            $urlElementParts = explode('.', $lastUrlPart);
            $slug = array_shift($urlElementParts);
        } else {
            $slug = Str::slug($this->name);
        }
        if ($value) {
            $slug .= '-' . $value->getSlug();
        }
        if (in_array($slug, $this->slugs)) {
            $slug .= '-' . random_int(10000, 99999);
        }
        $this->slugs[] = Str::substr($slug, 0, 190);
        return $slug;
    }

    /**
     * @param int|null $categoryId
     * @throws \Throwable
     */
    public function updateProduct(?int $categoryId = null): void
    {
        $group = $this->model;
        if (!$group || !$group->products || $group->products->isEmpty()) {
            return;
        }
        // Manipulations with group
        $group->active = $categoryId ? true : false;
        $group->category_id = $categoryId;
        $group->brand_id = $this->brand ? $this->brand->getId() : $group->brand_id;
        $group->saveOrFail();
        // Manipulations with group translates
        $group->data->each(function (ProductGroupTranslatesModel $translate) {
            $translate->name = $this->name;
            $translate->text = $this->content;
            $translate->save();
        });
        $group->products->each(function (ProductModel $product) use ($group) {
            $originalAvailable = $product->is_available;
            // Manipulations with product
            $product->brand_id = $group->brand_id;
            $product->active = $group->active;
            $product->available = $this->availability;
            $product->price = $this->price;
            $product->old_price = $this->oldPrice;
            $product->vendor_code = $this->vendorCode ?: $product->vendor_code;
            $product->saveOrFail();
            // Manipulations with product translates
            $product->data->each(function (ProductTranslatesModel $translate) {
                $translate->name = '';
                $translate->hidden_name = $this->name;
                $translate->keywords = $this->keywords;
                $translate->save();
            });

            if (!$product->wasRecentlyCreated && ($originalAvailable !== $product->is_available) && $product->is_available) {
                Event::fire(new ChangeProductStatusEvent($product->id));
            }

            $this->productModifications->push($product);
        });
    }

    /**
     * @param string $image
     */
    public function uploadImage(string $image): void
    {
        if (!$image || !$this->model) {
            return;
        }
        $parts = explode('/', $image);
        $originalName = end($parts);
        try {
            \File::makeDirectory(storage_path('app/public/temp'), 0777, true, true);
            Storage::put(
                'temp/' . $originalName,
                file_get_contents(trim($image))
            );
            $this->model->uploadImageFromResource(new UploadedFile(storage_path('app/public/temp/' . $originalName), $originalName));
            Storage::delete('temp/' . $originalName);
        } catch (\Exception $exception) {
            dump($exception->getMessage());
        }
    }

    /**
     * Link our product with remote product
     */
    private function linkToRemote(): void
    {
        if (!$this->id || !$this->remoteProductId) {
            return;
        }
        ProductsGroupsRemote::updateOrCreate([
            'group_id' => $this->id,
            'system' => $this->system,
        ], [
            'remote_id' => $this->remoteProductId,
        ]);
    }

}
