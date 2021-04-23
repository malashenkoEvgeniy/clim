<?php

namespace App\Widgets\Admin;

use App\Components\Widget\AbstractWidget;
use CustomRoles;

/**
 * Class Aside
 * Left menu for admin panel
 *
 * @package App\Widgets\Admin
 */
class StatCard implements AbstractWidget
{
    // Icons here: /admin/bower_components/Ionicons/cheatsheet.html
    
    // Colors list
    const COLOR_LIGHT_BLUE = 'bg-light-blue';
    const COLOR_AQUA = 'bg-aqua';
    const COLOR_GREEN = 'bg-green';
    const COLOR_YELLOW = 'bg-yellow';
    const COLOR_RED = 'bg-red';
    const COLOR_GRAY = 'bg-gray';
    const COLOR_NAVY = 'bg-navy';
    const COLOR_TEAL = 'bg-teal';
    const COLOR_PURPLE = 'bg-purple';
    const COLOR_ORANGE = 'bg-orange';
    const COLOR_MAROON = 'bg-maroon';
    const COLOR_BLACK = 'bg-lack';
    
    /**
     * Class full namespace
     *
     * @var string
     */
    protected $model;
    
    /**
     * Title
     *
     * @var string
     */
    protected $text;
    
    /**
     * Link to the page
     *
     * @var string
     */
    protected $url;
    
    /**
     * Icon class on the right
     *
     * @var null|string
     */
    protected $icon;
    
    /**
     * Color of the block
     *
     * @var string
     */
    protected $color;
    
    /**
     * Permission scope (module.action)
     *
     * @var string
     */
    protected $permission;
    
    /**
     * StatCard constructor.
     *
     * @param string $model
     * @param string $text
     * @param string $url
     * @param string $permission
     * @param null|string $color
     * @param null|string $icon
     */
    public function __construct(string $model, string $text, string $url, string $permission, $color = null, $icon = null)
    {
        $this->model = $model;
        $this->text = $text;
        $this->url = $url;
        $this->icon = $icon;
        $this->color = $color;
        $this->permission = $permission;
    }
    
    /**
     * Render widget template
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    final public function render()
    {
        if (CustomRoles::can($this->permission) === false) {
            return '';
        }
        return view(
            'admin.widgets.stat-card', [
                'count' => $this->model::count(),
                'text' => __($this->text),
                'url' => $this->url,
                'icon' => $this->icon,
                'color' => $this->color,
            ]
        );
    }
    
}
