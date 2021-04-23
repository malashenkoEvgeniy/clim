<?php

namespace App\Modules\Products\Widgets\Site;

use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\Product;

/**
 * Class ProductImage
 *
 * @package App\Modules\Products\Widgets\Site
 */
class ProductImage implements AbstractWidget
{

    /**
     * @var int
     */
    protected $productId;

    /**
     * @var string
     */
    protected $size;

    /**
     * @var array
     */
    protected $attr;
    
    /**
     * ProductImage constructor.
     *
     * @param int $productId
     * @param string $size
     * @param array $attr
     */
    public function __construct(int $productId, string $size = 'small', array $attr = [])
    {
        $this->productId = $productId;
        $this->size = $size;
        $this->attr = $attr;
    }

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        $product = Product::getOne($this->productId);
        if (!$product || !$product->preview) {
            return null;
        }
        return $product->preview->imageTag($this->size, $this->attr);
    }

}
