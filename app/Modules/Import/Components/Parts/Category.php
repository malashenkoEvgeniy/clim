<?php

namespace App\Modules\Import\Components\Parts;

use App\Components\Parsers\AbstractParsedCategory;
use App\Modules\Categories\Models\Category as CategoryModel;
use App\Modules\Categories\Models\CategoryTranslates as CategoryTranslatesModel;
use App\Modules\Import\Models\CategoriesRemote;
use Illuminate\Support\Str;

/**
 * Class Category
 *
 * @package App\Modules\Import\Components\Parts
 */
class Category
{
    /**
     * @var CategoryModel|null
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
     * @var int|null
     */
    protected $parentId;
    
    /**
     * @var int|null
     */
    protected $remoteId;
    
    /**
     * @var int|null
     */
    protected $remoteParentId;
    
    /**
     * @var null|string
     */
    protected $system;
    
    /**
     * Category constructor.
     *
     * @param AbstractParsedCategory $parsedCategory
     * @param $system
     */
    public function __construct(AbstractParsedCategory $parsedCategory, ?string $system)
    {
        $this->name = $parsedCategory->categoryName;
        $this->remoteId = $parsedCategory->remoteCategoryId;
        $this->remoteParentId = $parsedCategory->remoteParentId;
        $this->id = $parsedCategory->categoryId;
        $this->parentId = $parsedCategory->parentId;
        $this->slug = Str::slug($parsedCategory->categoryName);
        $this->system = $system;
    }
    
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
     * @return CategoryModel|null
     */
    public function getModel(): ?CategoryModel
    {
        return $this->model;
    }
    
    /**
     * @return int|null
     */
    public function getRemoteParentId(): ?int
    {
        return (int)$this->remoteParentId ?: null;
    }
    
    /**
     * @param int|null $remoteId
     * @return self
     */
    public function setRemoteId(?int $remoteId): self
    {
        $this->remoteId = $remoteId;
        
        return $this;
    }
    
    /**
     * @return int|null
     */
    public function getRemoteId(): ?int
    {
        return $this->remoteId;
    }
    
    /**
     * @param int|null $parentId
     * @return self
     */
    public function setParentId(?int $parentId): self
    {
        $this->parentId = $parentId;
    
        return $this;
    }
    
    /**
     * @return int|null
     */
    public function getParentId(): ?int
    {
        return $this->parentId;
    }
    
    /**
     * @param int|null $remoteParentId
     * @return self
     */
    public function setRemoteParentId(?int $remoteParentId): self
    {
        $this->remoteParentId = $remoteParentId;
    
        return $this;
    }
    
    /**
     * @param AbstractParsedCategory $parsedCategory
     * @throws \Throwable
     */
    public function update(AbstractParsedCategory $parsedCategory): void
    {
        $this->name = $parsedCategory->categoryName;
        $this->remoteParentId = $parsedCategory->remoteParentId;
        
        $this->create();
    }
    
    /**
     * @param CategoryModel $model
     * @return self
     */
    public function setModel(CategoryModel $model): self
    {
        $this->model = $model;
        $this->setId($model->id);
        $this->setName($model->current->name);
        $this->setSlug($model->current->slug);
        $this->setParentId($model->parent_id);
        
        return $this;
    }
    
    /**
     * @throws \Throwable
     */
    public function create(): void
    {
        try {
            // Product
            $this->model = $this->updateOrCreateCategory();
            // Store product id
            $this->setId($this->model->id);
            // Link to remote ID
            $this->linkToRemotes();
        } catch (\Exception $exception) {
            dump($exception->getMessage());
            dd($this);
        }
    }
    
    /**
     * Link our category with remote category
     */
    private function linkToRemotes(): void
    {
        if (!$this->remoteId || !$this->remoteId) {
            return;
        }
        CategoriesRemote::updateOrCreate([
            'category_id' => $this->model->id,
            'system' => $this->system,
        ], [
            'remote_id' => $this->remoteId,
        ]);
    }
    
    /**
     * @return CategoryModel
     * @throws \Throwable
     */
    private function updateOrCreateCategory(): CategoryModel
    {
        if ($this->getId()) {
            $category = $this->getModel() ?? CategoryModel::find($this->getId());
        }
        if (!isset($category) || !$category) {
            return $this->createCategory();
        } else {
            $this->updateCategory($category);
        }
        return $category;
    }
    
    /**
     * @return CategoryModel
     * @throws \Throwable
     */
    private function createCategory(): CategoryModel
    {
        $category = new CategoryModel;
        $category->active = true;
        $category->parent_id = $this->parentId ?: null;
        $category->saveOrFail();
        
        $this->model = $category;
        foreach (config('languages', []) as $languageAlias => $language) {
            $translate = new CategoryTranslatesModel;
            $translate->name = $this->name;
            $translate->slug = $this->slug;
            $translate->row_id = $category->id;
            $translate->language = $languageAlias;
            $translate->save();
        }
        
        return $category;
    }
    
    /**
     * @param CategoryModel $category
     * @throws \Throwable
     */
    public function updateCategory(CategoryModel $category): void
    {
        $category->active = true;
        $category->parent_id = $this->parentId ?: null;
        $category->saveOrFail();
        
        $category->data->each(function (CategoryTranslatesModel $translate) {
            $translate->name = $this->name;
            $translate->save();
        });
    }
}
