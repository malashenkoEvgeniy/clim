<?php

namespace App\Widgets\Admin;

use App\Components\Menu\Block;
use App\Components\Menu\Link;
use App\Components\Widget\AbstractWidget;

/**
 * Class Aside
 * Left menu for admin panel
 *
 * @package App\Widgets\Admin
 */
class AsideElement implements AbstractWidget
{
    /**
     * Element of the aside menu
     *
     * @var Link|Block
     */
    protected $element;
    
    /**
     * Template to show
     *
     * @var string
     */
    protected $template;
    
    /**
     * AsideElement constructor.
     *
     * @param Link|Block $element
     */
    public function __construct($element)
    {
        $this->element = $element;
        if ($element instanceof Link) {
            $this->template = 'admin.widgets.aside-link';
        } else {
            $this->template = 'admin.widgets.aside-block';
        }
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    final public function render()
    {
        if ($this->element->canBeShowed() === false) {
            return '';
        }
        $active = $this->element->isActive();
        $hasKids = $this->element instanceof Block ? $this->element->hasKids() : false;
        $classes = [];
        if ($active) {
            array_push($classes, 'active');
        }
        if ($hasKids) {
            array_push($classes, 'treeview');
        }
        if ($active && $hasKids) {
            array_push($classes, 'menu-open');
        }
        return view(
            $this->template, [
                'element' => $this->element,
                'classes' => $classes,
            ]
        );
    }
    
}
