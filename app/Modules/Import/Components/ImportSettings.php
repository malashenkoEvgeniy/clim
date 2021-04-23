<?php

namespace App\Modules\Import\Components;

use Illuminate\Support\Collection;

/**
 * Class ImportSettings
 *
 * @package App\Components\Parsers\PromUa
 */
class ImportSettings
{
    /**
     * Do nothing with images
     */
    const IMAGES_DO_NOT_UPLOAD = 'none';
    
    /**
     * Delete old images & upload new from the file
     */
    const IMAGES_REWRITE = 'rewrite';
    
    /**
     * Just upload new images from the file
     */
    const IMAGES_ADD = 'add';
    
    const PRODUCTS_DO_NOTHING = 'none';
    const PRODUCTS_JUST_UPDATE = 'just-update';
    const PRODUCTS_UPDATE_AND_DISABLE_OLD = 'update-and-disable-old';
    
    const CATEGORIES_DO_NOTHING = 'none';
    const CATEGORIES_JUST_UPDATE = 'just-update';
    const CATEGORIES_UPDATE_AND_DISABLE_OLD = 'update-and-disable-old';
    
    /**
     * @var string
     */
    public $images;
    
    /**
     * @var bool
     */
    public $updateProducts = false;
    
    /**
     * @var bool
     */
    public $disableOldProducts = false;
    
    /**
     * @var array
     */
    public $courses;
    
    /**
     * @var bool
     */
    public $updateCategories = false;
    
    /**
     * @var bool
     */
    public $disableOldCategories = false;
    
    /**
     * ImportSettings constructor.
     *
     * @param array $settings
     */
    public function __construct(array $settings = [])
    {
        if (array_get($settings, 'categories') === static::CATEGORIES_JUST_UPDATE) {
            $this->updateCategories = true;
        }
        if (array_get($settings, 'categories') === static::CATEGORIES_UPDATE_AND_DISABLE_OLD) {
            $this->updateCategories = true;
            $this->disableOldCategories = true;
        }
        if (array_get($settings, 'products') === static::PRODUCTS_JUST_UPDATE) {
            $this->updateProducts = true;
        }
        if (array_get($settings, 'products') === static::PRODUCTS_UPDATE_AND_DISABLE_OLD) {
            $this->updateProducts = true;
            $this->disableOldProducts = true;
        }
        $this->images = array_get($settings, 'images');
        if (in_array($this->images, [static::IMAGES_DO_NOT_UPLOAD, static::IMAGES_REWRITE, static::IMAGES_ADD]) === false) {
            $this->images = static::IMAGES_DO_NOT_UPLOAD;
        }
        $this->courses = new Collection();
        foreach (array_get($settings, 'course', []) as $currency => $course) {
            $this->courses->put($currency, (float)$course);
        }
    }
}
