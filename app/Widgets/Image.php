<?php

namespace App\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Core\Modules\Images\Models\Image as ImageModel;
use Illuminate\Support\HtmlString;
use Html;

/**
 * Class Image
 *
 * @package App\Widgets
 */
class Image implements AbstractWidget
{
    
    /**
     * @var \App\Core\Modules\Images\Models\Image
     */
    private $model;
    
    /**
     * @var string
     */
    private $size;
    
    /**
     * @var array
     */
    private $attributes;
    
    /**
     * @var bool
     */
    private $noPreview;
    
    /**
     * @var string
     */
    private $noPhotoLink;
    
    /**
     * Image constructor.
     *
     * @param ImageModel|null $image
     * @param string $size
     * @param array $attributes
     * @param bool $noPreview
     * @param string $noPhoto
     */
    public function __construct(?ImageModel $image, string $size, array $attributes = [], bool $noPreview = false, ?string $noPhoto = null)
    {
        $this->model = $image;
        $this->size = $size;
        $this->attributes = $attributes;
        $this->noPreview = $noPreview;
        $this->noPhotoLink = $noPhoto ?? site_media('static/images/placeholders/no-photo.png');
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if ($this->model && $this->model->exists) {
            $attributes = $this->attributes ?? [];
            if (!isset($attributes['title'])) {
                $attributes['title'] = $this->model->current->title;
            }
            if (!isset($attributes['alt'])) {
                $attributes['alt'] = $this->model->current->alt;
            }
            $attributes['class'] = array_get($attributes, 'class', []);
            if (!is_array($attributes['class'])) {
                $attributes['class'] = [$attributes['class']];
            }
            if (request()->ajax()) {
                return Html::image($this->model->link($this->size), $attributes['alt'] ?? '', $attributes);
            }
            $attributes['data-src'] = $this->model->link($this->size);
            $attributes['class'][] = 'js-lozad';
            $lazyLoad = 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="220" height="220"></svg>';
            return new HtmlString("<img src='$lazyLoad' " . Html::attributes($attributes) . ">");
        }
        return $this->noPreview === true
            ? null
            : Html::image($this->noPhotoLink, $this->attributes['alt'] ?? '', $this->attributes);
    }
    
}
