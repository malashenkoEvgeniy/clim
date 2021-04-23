<?php

namespace App\Components;

use Html;

/**
 * Class Buttons
 * Helper to work with buttons in lists or wherever
 * This buttons based on the tag `a`
 *
 * @package App\Helpers
 */
class Buttons
{
    
    /**
     * Check if button could be shown
     *
     * @var bool
     */
    private $couldBeShown;
    
    /**
     * Url
     *
     * @var string
     */
    private $url;
    
    /**
     * Default classes on all buttons
     *
     * @var array
     */
    private $defaultClasses = ['btn', 'btn-xs', 'btn-flat'];
    
    /**
     * Buttons constructor.
     *
     * @param string $routeName
     * @param null $routeParametersOrId
     * @param bool $couldBeShown
     */
    public function __construct(string $routeName, $routeParametersOrId = null, bool $couldBeShown = null)
    {
        // Parse route parameters
        $routeParameters = [];
        if (is_integer($routeParametersOrId)) {
            $routeParameters = ['id' => $routeParametersOrId];
        } elseif (is_array($routeParametersOrId)) {
            $routeParameters = $routeParametersOrId;
        }
        // Generate URL
        $this->url = route($routeName, $routeParameters);
        // Set couldBeShown property
        if ($couldBeShown !== null) {
            $this->couldBeShown = $couldBeShown;
        } else {
            list(, $module, $action) = explode('.', $routeName);
            $this->couldBeShown = \CustomRoles::can($module, $action);
        }
    }
    
    /**
     * Set new default classes to current element
     *
     * @param  $classes
     * @return $this
     */
    public function setDefaultClasses($classes)
    {
        $this->defaultClasses = is_array($classes) ? $classes : [(string)$classes];
        
        return $this;
    }
    
    /**
     * Create button html
     *
     * @param  string $content
     * @param  null $class
     * @param  array $attributes
     * @return \Illuminate\Support\HtmlString|string
     */
    public function make(string $content, $class = null, array $attributes = [])
    {
        if ($this->couldBeShown === false) {
            return '';
        }
        // Merge classes
        $class = is_array($class) ? $class : [(string)$class];
        // Make button
        return Html::link(
            $this->url,
            $content,
            ['class' => array_merge($this->defaultClasses, $class)] + $attributes,
            null,
            false
        );
    }
    
    /**
     * @param string $text
     * @param string $routeName
     * @param null $routeParametersOrId
     * @param bool|null $couldBeShown
     * @param null $class
     * @return \Illuminate\Support\HtmlString|string
     */
    static function custom(string $text, string $routeName, $routeParametersOrId = null, bool $couldBeShown = null, $class = null)
    {
        // Button exemplar
        $button = new Buttons($routeName, $routeParametersOrId, $couldBeShown);
        // Make button html
        return $button->make(
            $text,
            $class ?? 'btn-default'
        );
    }
    
    /**
     * View button preset
     *
     * @param  string $routeName
     * @param  null $routeParametersOrId
     * @param  bool $couldBeShown
     * @return \Illuminate\Support\HtmlString
     */
    static function view(string $routeName, $routeParametersOrId = null, bool $couldBeShown = null)
    {
        // Button exemplar
        $button = new Buttons($routeName, $routeParametersOrId, $couldBeShown);
        // Make button html
        return $button->make(
            Html::tag('i', '', ['class' => ['fa', 'fa-eye']]),
            'btn-default'
        );
    }
    
    /**
     * Edit button preset
     *
     * @param  string $routeName
     * @param  null $routeParametersOrId
     * @param  bool $couldBeShown
     * @return \Illuminate\Support\HtmlString
     */
    static function edit(string $routeName, $routeParametersOrId = null, bool $couldBeShown = null)
    {
        // Button exemplar
        $button = new Buttons($routeName, $routeParametersOrId, $couldBeShown);
        // Make button html
        return $button->make(
            Html::tag('i', '', ['class' => ['fa', 'fa-pencil']]),
            'btn-primary'
        );
    }
    
    /**
     * Delete button preset
     *
     * @param  string $routeName
     * @param  null $routeParametersOrId
     * @param  bool $couldBeShown
     * @return \Illuminate\Support\HtmlString
     */
    static function delete(string $routeName, $routeParametersOrId = null, bool $couldBeShown = null)
    {
        // Button exemplar
        $button = new Buttons($routeName, $routeParametersOrId, $couldBeShown);
        // Make button html
        return $button->make(
            Html::tag('i', '', ['class' => ['fa', 'fa-trash']]),
            ['btn-danger'],
            [
                'data-toggle' => 'confirmation',
                'data-message' => trans('admin.messages.delete'),
            ]
        );
    }
    
    /**
     * Restore button preset
     *
     * @param  string $routeName
     * @param  null $routeParametersOrId
     * @param  bool $couldBeShown
     * @return \Illuminate\Support\HtmlString
     */
    static function restore(string $routeName, $routeParametersOrId = null, bool $couldBeShown = null)
    {
        // Button exemplar
        $button = new Buttons($routeName, $routeParametersOrId, $couldBeShown);
        // Make button html
        return $button->make(
            Html::tag('i', '', ['class' => ['fa', 'fa-hand-peace-o']]),
            ['btn-success'],
            [
                'data-toggle' => 'confirmation',
                'data-message' => trans('admin.messages.restore'),
            ]
        );
    }
    
}
