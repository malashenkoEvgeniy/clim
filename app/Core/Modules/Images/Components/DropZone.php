<?php

namespace App\Core\Modules\Images\Components;

use App\Core\Abstractions\ImageContainer;
use App\Traits\Imageable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DropZone
 *
 * @package App\Components\DropZone
 */
class DropZone
{
    /**
     * @var string
     */
    const ROOT_VIEW_FOLDER = 'images::dropzone.';
    
    /**
     * @var Model
     */
    private $model;
    
    /**
     * @var null|string
     */
    private $imageConfigurationType;
    
    /**
     * @var ImageContainer
     */
    private $imageInstance;
    
    /**
     * @var string
     */
    private $getImagesListUrl;
    
    /**
     * @var string
     */
    private $uploadImageUrl;
    
    /**
     * @var string
     */
    private $deleteImageUrl;
    
    /**
     * @var string
     */
    private $sortImagesUrl;
    
    /**
     * DropZone constructor.
     *
     * @param Model|Imageable $model
     * @param null|string $imageConfigurationType
     * @throws
     */
    public function __construct(Model $model, ?string $imageConfigurationType = null)
    {
        $this->model = $model;
        $this->setGetImagesListUrl(route('admin.images.index'));
        $this->setUploadImageUrl(route('admin.images.store'));
        $this->setDeleteImageUrl(route('admin.images.delete'));
        $this->setSortImagesUrl(route('admin.images.sortable'));
        $this->imageConfigurationType = $imageConfigurationType;
        $this->imageInstance = $model->imageInstance($imageConfigurationType);
    }
    
    /**
     * @param Model $model
     * @param null|string $imageConfigurationType
     * @return DropZone
     */
    public static function make(Model $model, ?string $imageConfigurationType = null): DropZone
    {
        return new DropZone($model, $imageConfigurationType);
    }
    
    /**
     * @return string
     */
    public function getGetImagesListUrl(): string
    {
        return $this->getImagesListUrl;
    }
    
    /**
     * @param string $url
     * @return DropZone
     */
    public function setGetImagesListUrl(string $url): self
    {
        $this->getImagesListUrl = $url;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getUploadImageUrl(): string
    {
        return $this->uploadImageUrl;
    }
    
    /**
     * @param string $url
     * @return DropZone
     */
    public function setUploadImageUrl(string $url): self
    {
        $this->uploadImageUrl = $url;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getDeleteImageUrl(): string
    {
        return $this->deleteImageUrl;
    }
    
    /**
     * @param string $url
     * @return DropZone
     */
    public function setDeleteImageUrl(string $url): self
    {
        $this->deleteImageUrl = $url;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getSortImagesUrl(): string
    {
        return $this->sortImagesUrl;
    }
    
    /**
     * @param string $url
     * @return DropZone
     */
    public function setSortImagesUrl(string $url): self
    {
        $this->sortImagesUrl = $url;
        
        return $this;
    }
    
    /**
     * @return ImageContainer
     */
    public function getImageInstance(): ImageContainer
    {
        return $this->imageInstance;
    }
    
    /**
     * @return Model|Imageable
     */
    public function getModel(): Model
    {
        return $this->model;
    }
    
    /**
     * Render view with DropZone
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        return view(static::ROOT_VIEW_FOLDER . 'index', [
            'dropZone' => $this,
            'model' => $this->getModel(),
            'image' => $this->getImageInstance(),
        ]);
    }
    
    /**
     * Render images
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function renderImages()
    {
        return view(static::ROOT_VIEW_FOLDER . 'images', [
            'dropZone' => $this,
            'model' => $this->getModel(),
            'images' => $this->getModel()->getImages($this->imageConfigurationType),
        ]);
    }
    
}