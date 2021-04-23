<?php

namespace App\Modules\Brands\Widgets\Admin;

use App\Components\Widget\AbstractWidget;
use App\Modules\Brands\Models\Brand;
use Illuminate\Support\Collection;
use Html;

/**
 * Class BrandWithLinkInAdminPanel
 *
 * @package App\Modules\Brands\Widgets\Admin
 */
class BrandWithLinkInAdminPanel implements AbstractWidget
{
    
    /**
     * @var int|null
     */
    protected $brandId;
    
    protected $noBrand = '&mdash;';
    
    /**
     * @var Collection|Brand[]
     */
    private static $brands;
    
    /**
     * BrandWithLinkInAdminPanel constructor.
     *
     * @param null|int $brandId
     */
    public function __construct(?int $brandId = null)
    {
        $this->brandId = $brandId;
        if (!static::$brands) {
            static::$brands = new Collection();
        }
    }
    
    /**
     * @return string
     */
    public function render()
    {
        if (!$this->brandId) {
            return $this->noBrand;
        }
        if (static::$brands->has($this->brandId)) {
            return $this->getLink(static::$brands->get($this->brandId));
        }
        $brand = Brand::find($this->brandId);
        if (!$brand || !$brand->exists) {
            return $this->noBrand;
        }
        static::$brands->put($this->brandId, $brand);
        return $this->getLink($brand);
    }
    
    /**
     * @param Brand $brand
     * @return \Illuminate\Support\HtmlString
     */
    private function getLink(Brand $brand)
    {
        return Html::link($brand->link_in_admin_panel, $brand->current->name, [
            'target' => '_blank',
        ]);
    }
    
}
