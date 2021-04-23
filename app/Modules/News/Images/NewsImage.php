<?php

namespace App\Modules\News\Images;

use App\Components\Image\ImagesGroup;
use App\Core\Abstractions\ImageContainer;

/**
 * Class ArticlesImage
 *
 * @package App\Modules\Articles\Images
 */
class NewsImage extends ImageContainer
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
        return 'news';
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
            ->setWidth(350)
            ->setHeight(260)
            ->setWatermark(true)
            ->setCrop(false);
        $image
            ->addTo('big')
            ->setWidth(920);
        return $image;
    }
    
}
