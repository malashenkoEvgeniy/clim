<?php

namespace App\Modules\Import\Components\Parts;

use App\Modules\Brands\Models\Brand as BrandModel;
use App\Modules\Brands\Models\BrandTranslates as BrandTranslatesModel;

/**
 * Class Brand
 *
 * @package App\Components\Parsers\PromUa\Parts
 */
class Brand
{
    /**
     * @var BrandModel|null
     */
    protected $model;
    
    /**
     * @var string|null
     */
    protected $name;
    
    /**
     * @var string|null
     */
    protected $slug;
    
    /**
     * @var int|null
     */
    protected $id;
    
    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    
    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }
    
    /**
     * @return string
     */
    public function getSlug(): ?string
    {
        return $this->slug;
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
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;
    
        return $this;
    }
    
    /**
     * @param string $slug
     * @return self
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
    
        return $this;
    }
    
    /**
     * @return BrandModel|null
     */
    public function getModel(): ?BrandModel
    {
        return $this->model;
    }
    
    /**
     * @param BrandModel $model
     * @return self
     */
    public function setModel(BrandModel $model): self
    {
        $this->model = $model;
        $this->setId($model->id);
        $this->setName($model->current->name);
        $this->setSlug($model->current->slug);
        
        return $this;
    }
    
    /**
     * @throws \Exception
     */
    public function create(): void
    {
        if ($this->getId()) {
            return;
        }
        $brand = BrandModel::create([
            'active' => true,
        ]);
        if (!$brand) {
            throw new \Exception('Can not create brand ' . $this->name);
        }
        $this->model = $brand;
        $this->setId($brand->id);
        foreach (config('languages', []) as $languageAlias => $language) {
            $translate = new BrandTranslatesModel;
            $translate->name = $this->name;
            $translate->slug = $this->slug;
            $translate->row_id = $brand->id;
            $translate->language = $languageAlias;
            $translate->save();
        }
    }
}
