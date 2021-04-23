<?php

namespace App\Core\Interfaces;

use App\Components\Image\ImagesGroup;

/**
 * Interface ImageInterface
 *
 * @package App\Core\Interfaces
 */
interface ImageInterface
{
    
    /**
     * Image configurations
     *
     * @return ImagesGroup
     */
    public function configurations(): ImagesGroup;
    
    /**
     * Folder name
     * Make this parameter unique
     *
     * @return string
     */
    public static function getType(): string;
    
    /**
     * Field name in the form
     *
     * @return string
     */
    public static function getField(): string;
    
}