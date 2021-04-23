<?php

namespace App\Modules\Products\Images;

use App\Components\Image\ImagesGroup;
use App\Core\Abstractions\ImageContainer;

/**
 * Class ArticlesImage
 *
 * @package App\Modules\Articles\Images
 */
class ProductImage extends ImageContainer
{
    
    /**
     * Field name in the form
     *
     * @return string
     */
    public static function getField(): string
    {
        return 'image';
    }
    
    /**
     * Folder name
     *
     * @return string
     */
    public static function getType(): string
    {
        return 'products';
    }
    
    /**
     * Configurations
     *
     * @return ImagesGroup
     * @throws \App\Exceptions\WrongParametersException
     */
    public function configurations(): ImagesGroup
    {
        $image = new ImagesGroup($this->getType());
        $image
            ->addTo('small')
            ->setWidth(220)
            ->setHeight(220)
            ->setCrop(false);
        $image
            ->addTo('medium')
            ->setWatermark(true)
            ->setWidth(680)
            ->setHeight(500);
        return $image;
    }
    
}
