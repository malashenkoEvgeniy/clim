<?php

namespace App\Modules\Products\Images;

use App\Components\Image\ImagesGroup;
use App\Core\Abstractions\ImageContainer;

/**
 * Class GroupImage
 *
 * @package App\Modules\Products\Images
 */
class GroupImage extends ImageContainer
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
        return 'groups';
    }
    
    /**
     * Configurations
     *
     * @return ImagesGroup
     * @throws \App\Exceptions\WrongParametersException
     */
    public function configurations(): ImagesGroup
    {
        return (new ProductImage())->configurations();
    }
    
}
