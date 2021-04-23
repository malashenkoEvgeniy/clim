<?php

namespace App\Modules\Products\Widgets\Site;

use App\Components\Widget\AbstractWidget;

/**
 * Class SortProductsBar
 *
 * @package App\Modules\Products\Widgets\Site
 */
class SortProductsBar implements AbstractWidget
{
    /**
     * Do we need to show this widget at the moment
     *
     * @var bool
     */
    public $show;
    
    /**
     * Do we need to show widget as <form> or as <div>
     *
     * @var bool
     */
    public $asForm;
    
    /**
     * SortProductsBar constructor.
     *
     * @param bool $show
     * @param bool $asForm
     */
    public function __construct(bool $show, bool $asForm = false)
    {
        $this->show = $show;
        $this->asForm = $asForm;
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if ($this->show === false) {
            return null;
        }
        return view('products::site.widgets.sort-products-bar', [
            'orderBy' => request()->query('order'),
            'perPage' => request()->query('per-page'),
            'query' => request()->query('query'),
            'asForm' => $this->asForm,
        ]);
    }
    
}
