<?php

namespace App\Modules\Products\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\ProductGroup;
use Form;

/**
 * Class ProductGroupLiveSearchSelect
 *
 * @package App\Modules\Products\Widgets
 */
class ProductGroupLiveSearchSelect implements AbstractWidget
{
    
    /**
     * @var array
     */
    protected $ignored;
    
    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var int|null
     */
    protected $chosenGroupId;
    
    /**
     * @var array
     */
    protected $attributes;
    
    /**
     * ProductLiveSearchSelect constructor.
     *
     * @param array $ignored
     * @param string $name
     * @param int|null $chosenGroupId
     * @param array $attributes
     */
    public function __construct(array $ignored = [], string $name = 'group_id', ?int $chosenGroupId = null, array $attributes = [])
    {
        $this->ignored = $ignored;
        $this->name = $name;
        $this->chosenGroupId = $chosenGroupId;
        $this->attributes = $attributes;
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        $options = [];
        if ($this->chosenGroupId) {
            $group = ProductGroup::find($this->chosenGroupId);
            if ($group && $group->exists) {
                $options[$group->id] = view('products::admin.groups.widgets.live-search-select-markup', [
                    'group' => $group,
                ])->render();
            }
        }
        return Form::select($this->name, $options, $this->chosenGroupId, $this->attributes + [
            'class' => ['form-control', 'js-data-ajax'],
            'data-href' => route('admin.groups.live-search'),
            'data-ignored' => json_encode($this->ignored),
        ]);
    }
    
}
