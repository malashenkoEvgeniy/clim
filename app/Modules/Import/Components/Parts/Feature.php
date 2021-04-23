<?php

namespace App\Modules\Import\Components\Parts;

use Illuminate\Support\Collection;
use App\Modules\Features\Models\Feature as FeatureModel;
use App\Modules\Features\Models\FeatureTranslates as FeatureTranslatesModel;
use Illuminate\Support\Str;

/**
 * Class Feature
 *
 * @package App\Components\Parsers\PromUa\Parts
 */
class Feature
{
    /**
     * @var string|null
     */
    protected $name;
    
    /**
     * @var int|null
     */
    protected $id;
    
    /**
     * @var string|null
     */
    protected $slug;
    
    /**
     * @var Collection|FeatureValue[]
     */
    protected $values;
    
    /**
     * @var FeatureModel
     */
    protected $model;
    
    /**
     * Feature constructor.
     */
    public function __construct()
    {
        $this->values = new Collection();
    }
    
    /**
     * @return FeatureModel
     */
    public function getModel(): FeatureModel
    {
        return $this->model;
    }
    
    /**
     * @param FeatureModel $model
     * @return self
     */
    public function setModel(FeatureModel $model): self
    {
        $this->model = $model;
        $this->setId($model->id);
        $this->setName($model->current->name);
        $this->setSlug($model->current->slug);
        
        return $this;
    }
    
    /**
     * @param mixed $slug
     * @return self
     */
    public function setSlug($slug): self
    {
        $this->slug = Str::substr($slug, 0, 190);
        
        return $this;
    }
    
    /**
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = Str::substr($name, 0, 190);
    
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * @return Collection|FeatureValue[]
     */
    public function getValues(): Collection
    {
        return $this->values;
    }
    
    /**
     * @param Collection|FeatureValue[] $values
     * @return self
     */
    public function setValues(Collection $values): self
    {
        $this->values = $values;
    
        return $this;
    }
    
    /**
     * @param FeatureValue $featureValue
     * @return Feature
     */
    public function addExistedValue(FeatureValue $featureValue): self
    {
        $this->values->put($featureValue->getSlug(), $featureValue);
        
        return $this;
    }
    
    /**
     * @param string $name
     * @param string|null $measure
     * @return FeatureValue
     * @throws \Exception
     */
    public function addValue(string $name, ?string $measure = null): FeatureValue
    {
        $featureValueName = $name . ($measure ? ' ' . $measure : '');
        return $this->searchOrCreateValue($featureValueName);
    }
    
    /**
     * @param string $featureValueName
     * @return FeatureValue
     * @throws \Exception
     */
    private function searchOrCreateValue(string $featureValueName): FeatureValue
    {
        $slug = Str::slug($featureValueName);
        $slug = Str::substr($slug, 0, 190);
        if ($this->values->has($slug)) {
            return $this->values->get($slug);
        }
        $value = new FeatureValue();
        $value->setName($featureValueName);
        $value->setSlug($slug);
        $value->setFeatureId($this->getId());
        $value->create();
        $this->values->put($slug, $value);
        return $value;
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
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    
    /**
     * @throws \Exception
     */
    public function create(): void
    {
        if ($this->getId() || !$this->getSlug() || !$this->getName()) {
            return;
        }
        $feature = FeatureModel::create([
            'active' => true,
            'main' => false,
            'in_filter' => false,
        ]);
        if (!$feature) {
            throw new \Exception('Can not create feature ' . $this->name);
        }
        $this->setId($feature->id);
        $this->model = $feature;
        foreach (config('languages', []) as $languageAlias => $language) {
            $translate = new FeatureTranslatesModel;
            $translate->name = $this->name;
            $translate->slug = $this->slug;
            $translate->row_id = $feature->id;
            $translate->language = $languageAlias;
            $translate->save();
        }
    }
    
}
