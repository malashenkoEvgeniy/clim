<?php

namespace CustomForm\Builder;

use CustomRoles, Route;
use App\Core\Modules\Administrators\Models\RoleRule;
use Illuminate\Support\Collection;

/**
 * Class Buttons
 * Close, save buttons...
 *
 * @package CustomForm\Builder
 */
class Buttons
{
    
    protected $template = 'admin.form.components.buttons';
    
    /**
     * Do we need show 'save' button?
     *
     * @var bool
     */
    protected $showSaveButton = true;
    
    protected $forceShowSaveButton = false;
    
    /**
     * Do we need show 'save and close' button?
     *
     * @var bool
     */
    protected $showSaveAndCloseButton = true;
    
    /**
     * Do we need show 'save and add' button?
     *
     * @var bool
     */
    protected $showSaveAndAddButton = true;
    
    /**
     * Do we need show 'close' button?
     *
     * @var bool
     */
    protected $showCloseButton = false;
    
    protected $forceShowCloseButton = false;
    
    /**
     * @var Collection
     */
    protected $customButtons;
    
    /**
     * Close button URL
     *
     * @var string
     */
    protected $closeUrl;
    
    /**
     * Current/set route name
     *
     * @var string
     */
    protected $route;
    
    /**
     * Buttons constructor.
     */
    public function __construct()
    {
        $this->route = Route::currentRouteName();
        $this->customButtons = new Collection();
    }
    
    /**
     * @param string $name
     * @param array $attributes
     * @return Buttons
     */
    public function addCustomButton(string $name, array $attributes = []): self
    {
        if (array_get($attributes, 'type') === 'href' && isset($attributes['href'])) {
            $href = $attributes['href'];
            unset($attributes['type'], $attributes['href']);
            $this->customButtons->push(\Html::link($href, trans($name), $attributes));
        } else {
            $this->customButtons->push(\Form::button(trans($name), $attributes));
        }
        
        return $this;
    }
    
    /**
     * @return Collection
     */
    public function getCustomButtons(): Collection
    {
        return $this->customButtons;
    }
    
    /**
     * Do not show 'save' button
     *
     * @return $this
     */
    public function doNotShowSaveButton()
    {
        $this->showSaveButton = false;
        
        return $this;
    }
    
    /**
     * @return $this
     */
    public function forceShowSaveButton()
    {
        $this->forceShowSaveButton = true;
        
        return $this;
    }
    
    /**
     * @return $this
     */
    public function forceShowCloseButton()
    {
        $this->forceShowCloseButton = true;
        
        return $this;
    }
    
    /**
     * Do not show 'save and close' button
     *
     * @return $this
     */
    public function doNotShowSaveAndCloseButton()
    {
        $this->showSaveAndCloseButton = false;
        
        return $this;
    }
    
    /**
     * Do not show 'save and add' button
     *
     * @return $this
     */
    public function doNotShowSaveAndAddButton()
    {
        $this->showSaveAndAddButton = false;
        
        return $this;
    }
    
    /**
     * Do not show 'close' button
     *
     * @return $this
     */
    public function doNotShowCloseButton()
    {
        $this->showCloseButton = false;
        
        return $this;
    }
    
    /**
     * Show 'close' button
     *
     * @param  string $url
     * @return $this
     */
    public function showCloseButton(string $url)
    {
        $this->closeUrl = $url;
        $this->showCloseButton = true;
        
        return $this;
    }
    
    /**
     * Check if we need to show 'close' button
     *
     * @return bool
     */
    public function needCloseButton()
    {
        if ($this->forceShowCloseButton) {
            return true;
        }
        if ($this->showCloseButton) {
            list(, $module) = array_pad(explode('.', $this->route), 2, 'dashboard');
            return CustomRoles::can($module, RoleRule::INDEX);
        }
        return false;
    }
    
    /**
     * Check if we need to show 'save and add' button
     *
     * @return bool
     */
    public function needSaveAndAddButton()
    {
        if ($this->showSaveAndAddButton) {
            list(, $module) = array_pad(explode('.', $this->route), 2, 'dashboard');
            return CustomRoles::can($module, RoleRule::STORE);
        }
        return false;
    }
    
    /**
     * Check if we need to show 'save and close' button
     *
     * @return bool
     */
    public function needSaveAndCloseButton()
    {
        if ($this->showSaveAndCloseButton) {
            list(, $module) = array_pad(explode('.', $this->route), 2, 'dashboard');
            return CustomRoles::can($module, RoleRule::INDEX);
        }
        return false;
    }
    
    /**
     * Check if we need to show 'save' button
     *
     * @return bool
     */
    public function needSaveButton()
    {
        if ($this->forceShowSaveButton) {
            return true;
        }
        if ($this->showSaveButton) {
            list(, $module) = array_pad(explode('.', $this->route), 2, 'dashboard');
            return CustomRoles::can($module, RoleRule::UPDATE);
        }
        return false;
    }
    
    /**
     * Do not show any button
     */
    public function doNotShowAnyButton()
    {
        $this->doNotShowCloseButton();
        $this->doNotShowSaveAndAddButton();
        $this->doNotShowSaveAndCloseButton();
        $this->doNotShowSaveButton();
    }
    
    /**
     * Check if we need to show at least one button
     *
     * @return bool
     */
    public function need()
    {
        return
            $this->needCloseButton() ||
            $this->needSaveAndAddButton() ||
            $this->needSaveAndCloseButton() ||
            $this->needSaveButton();
    }
    
    /**
     * Show buttons
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|null
     */
    public function render()
    {
        if ($this->need() === false) {
            return null;
        }
        return view($this->template, ['buttons' => $this]);
    }
    
    /**
     * Get close URL
     *
     * @return string
     */
    public function getCloseUrl()
    {
        return $this->closeUrl;
    }
    
}
