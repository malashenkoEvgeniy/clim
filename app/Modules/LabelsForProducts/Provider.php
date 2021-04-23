<?php

namespace App\Modules\LabelsForProducts;

use App\Core\BaseProvider;
use App\Core\Modules\Administrators\Models\RoleRule;
use App\Core\Modules\Languages\Models\Language;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\LabelsForProducts\Models\LabelTranslates;
use App\Modules\LabelsForProducts\Widgets\Labels;
use CustomForm\Input;
use CustomRoles, CustomMenu, Widget, CustomSettings;
use App\Modules\LabelsForProducts\Models\Label as LabelModel;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Provider
 * Module configuration class
 *
 * @package App\Modules\ProductLabels
 */
class Provider extends BaseProvider
{

    /**
    * Set custom presets
    */
    protected function presets()
    {
        $this->setModuleName('labels');
        $this->setTranslationsNamespace('labels');
        $this->setViewNamespace('labels');
        $this->setConfigNamespace('labels');
    }
    
    /**
     * Register widgets and menu for admin panel
     *
     * @throws \App\Exceptions\WrongParametersException
     */
    protected function afterBootForAdminPanel()
    {
        $settings = CustomSettings::createAndGet('labels', 'labels::general.settings-name');
        $settings->add(
            Input::create('per-page')
                ->setType('number')
                ->setLabel('labels::general.per-page')
                ->required(),
            ['required', 'integer', 'min:1']
        );
        
        CustomMenu::get()->group()
            ->block('catalog')
            ->link('labels::general.menu', RouteObjectValue::make('admin.product-labels.index'))
            ->additionalRoutesForActiveDetect(
                RouteObjectValue::make('admin.product-labels.create'),
                RouteObjectValue::make('admin.product-labels.edit')
            );
        // Register role scopes
        CustomRoles::add('labels', 'labels::general.permission-name')
            ->except(RoleRule::VIEW);
    }
    
    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot()
    {
        Widget::register(Labels::class, 'labels::products');
    }
    
    public function initSitemap()
    {
        $items = [];
        LabelModel::with('current')->active()->latest('id')->get()->each(function (LabelModel $label) use (&$items) {
            $items[] = [
                'name' => $label->current->name,
                'url' => route('site.products-by-labels', $label->current->slug),
            ];
        });
        return $items;
    }


    public function initSitemapXml()
    {
        $languages = config('languages', []);
        $default_language = null;
        /** @var Language $language */
        foreach($languages as $language){
            if($language->default){
                $default_language = $language->slug;
            }
        }

        $items = [];
        LabelTranslates::whereHas('row', function (Builder $builder){
            $builder->where('active', true);
        })->get()->each(function (LabelTranslates $page) use (&$items, &$default_language) {
            $prefix = ($default_language === $page->language) ? '' : '/' . $page->language;
            $items[] = [
                'url' => url($prefix . route('site.products-by-labels', ['slug' => $page->slug], false), [], isSecure()),
            ];
        });
        return $items;
    }
    
}
