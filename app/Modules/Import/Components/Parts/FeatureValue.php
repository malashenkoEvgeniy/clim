<?php

namespace App\Modules\Import\Components\Parts;

use Illuminate\Support\Collection;
use App\Modules\Features\Models\FeatureValue as FeatureValueModel;
use App\Modules\Features\Models\FeatureValueTranslates as FeatureValueTranslatesModel;
use Illuminate\Support\Str;

/**
 * Class FeatureValue
 *
 * @package App\Components\Parsers\PromUa\Parts
 */
class FeatureValue
{
    /**
     * @var int|null
     */
    protected $id;
    
    /**
     * @var int|null
     */
    protected $featureId;
    
    /**
     * @var string|null
     */
    protected $slug;
    
    /**
     * @var string|null
     */
    protected $name;
    
    /**
     * @var Collection|Product[]
     */
    protected $products;
    
    /**
     * @var FeatureValueModel
     */
    protected $model;
    
    /**
     * FeatureValue constructor.
     */
    public function __construct()
    {
        $this->products = new Collection();
    }
    
    /**
     * @return int|null
     */
    public function getFeatureId(): ?int
    {
        return $this->featureId;
    }
    
    /**
     * @param int|null $featureId
     * @return self
     */
    public function setFeatureId(?int $featureId): self
    {
        $this->featureId = $featureId;
        
        return $this;
    }
    
    /**
     * @param Product $product
     */
    public function addProduct(Product $product): void
    {
        $this->products->push($product);
    }
    
    /**
     * @param int $productId
     * @return bool
     */
    public function inProduct(int $productId): bool
    {
        foreach ($this->products as $product) {
            if ($product->getId() === $productId) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * @return FeatureValueModel
     */
    public function getModel(): FeatureValueModel
    {
        return $this->model;
    }
    
    /**
     * @param FeatureValueModel $model
     * @return self
     */
    public function setModel(FeatureValueModel $model): self
    {
        $this->model = $model;
        $this->setId($model->id);
        $this->setFeatureId($model->feature_id);
        $this->setName($model->current->name);
        $this->setSlug($model->current->slug);
        
        return $this;
    }
    
    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    
    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }
    
    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }
    
    /**
     * @return Product[]|Collection
     */
    public function getProducts()
    {
        return $this->products;
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
     * @param string|null $name
     * @return self
     */
    public function setName(?string $name): self
    {
        $this->name = Str::substr($name, 0, 190);
    
        return $this;
    }
    
    /**
     * @param string|null $slug
     * @return self
     */
    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;
    
        return $this;
    }
    
    /**
     * @param Product[]|Collection $products
     * @return self
     */
    public function setProducts($products): self
    {
        $this->products = $products;
        
        return $this;
    }
    
    /**
     * @throws \Exception
     */
    public function create(): void
    {
        if ($this->getId() || !$this->getSlug() || !$this->getName() || !$this->getFeatureId()) {
            return;
        }
        $value = FeatureValueModel::create([
            'active' => true,
            'feature_id' => $this->getFeatureId(),
        ]);
        if (!$value) {
            throw new \Exception('Can not create feature value ' . $this->name);
        }
        $this->setId($value->id);
        $this->model = $value;
        foreach (config('languages', []) as $languageAlias => $language) {
            $translate = new FeatureValueTranslatesModel;
            $translate->name = $this->name;
            $translate->slug = $this->slug;
            $translate->row_id = $value->id;
            $translate->language = $languageAlias;
            $translate->save();
        }
    }
    
}
