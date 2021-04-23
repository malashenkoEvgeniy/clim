<?php

namespace App\Core\Modules\Administrators\Images;

use App\Components\Image\ImagesGroup;
use App\Core\Abstractions\ImageContainer;

/**
 * Class ArticlesImage
 *
 * @package App\Modules\Articles\Images
 */
class AdminAvatar extends ImageContainer
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
        return 'administrators';
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
            ->setWidth(250)
            ->setHeight(250)
            ->setCrop(true);
        return $image;
    }
    
}