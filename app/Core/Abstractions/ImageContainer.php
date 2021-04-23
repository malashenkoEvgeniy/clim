<?php

namespace App\Core\Abstractions;

use App\Core\Interfaces\ImageInterface;

/**
 * Class Singleton
 *
 * @package App\Core\Abstractions
 */
abstract class ImageContainer implements ImageInterface
{
    
    /**
     * @var self
     */
    protected static $instance;
    
    /**
     * Gets the instance via lazy initialization (created on first usage)
     */
    public static function getInstance(): self
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }
    
    /**
     * Additional fields for form for one image editing page
     * In array could be elements with Element class and FieldSet and FieldSetLang
     *
     * @return array
     */
    public static function additionalFormFields(): array
    {
        return [];
    }

}