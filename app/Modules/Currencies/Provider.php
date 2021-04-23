<?php

namespace App\Modules\Currencies;

use App\Core\BaseProvider;
use App\Core\Modules\Administrators\Models\RoleRule;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Currencies\Models\Currency;
use CustomForm\Input;
use CustomForm\Select;
use CustomRoles, CustomMenu, Config, Schema, Catalog, CustomSettings;
use Illuminate\Validation\Rule;

/**
 * Class Provider
 * Module configuration class
 *
 * @package App\Modules\Catalog
 */
class Provider extends BaseProvider
{

    /**
     * Set custom presets
     */
    protected function presets()
    {
        Catalog::loadCurrencies(new \App\Modules\Currencies\Components\Currency());
    }

    /**
     * Register widgets and menu for admin panel
     *
     * @throws \App\Exceptions\WrongParametersException
     */
    protected function afterBootForAdminPanel()
    {
        // Register module configurable settings
        $settings = CustomSettings::createAndGet('currencies', 'currencies::settings.group-name');
        $settings->add(
            Select::create('locations')
                ->add([
                    'right' => 'currencies::settings.locations-right',
                    'left' => 'currencies::settings.locations-left',
                ])
                ->setDefaultValue('right')
                ->setLabel('currencies::settings.locations')
                ->required(), ['required', Rule::in(['left', 'right'])]
        );
        $settings->add(
            Select::create('number-symbols')
                ->add([
                    'currencies::settings.number-symbols-none',
                    'currencies::settings.number-symbols-tenths',
                    'currencies::settings.number-symbols-hundredths',
                ])
                ->setDefaultValue(2)
                ->setLabel('currencies::settings.number-symbols')
                ->required(), ['required', 'integer', 'min:0', 'max:2']
        );
        $settings->add(
            Select::create('types')
                ->add([
                   'currencies::settings.types-first',
                   'currencies::settings.types-second',
                   'currencies::settings.types-third',
                ])
                ->setDefaultValue(2)
                ->setLabel('currencies::settings.types')
                ->required(), ['required', Rule::in([0, 1, 2])]
        );
        $group = CustomMenu::get()->group();
        $group
            ->block('catalog')
            ->link('currencies::menu.currencies', RouteObjectValue::make('admin.currencies.index'))
            ->additionalRoutesForActiveDetect(
                RouteObjectValue::make('admin.currencies.edit')
            );
        CustomRoles::add('currencies', 'currencies::general.permission-name')
            ->except(RoleRule::VIEW)
            ->addCustomPolicy('defaultInAdminPanel', RoleRule::UPDATE)
            ->addCustomPolicy('defaultOnSite', RoleRule::UPDATE);
        $this->defaultCurrencies();
    }

    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot()
    {
        $this->defaultCurrencies();
    }

    /**
     * Save default currencies to config
     */
    private function defaultCurrencies()
    {
        if (Schema::hasTable((new Currency)->getTable())) {
            $adminCurrency = Currency::getDefaultInAdminPanel();
            Config::set('currency.admin', $adminCurrency);
            if ($adminCurrency && $adminCurrency->default_on_site === true) {
                Config::set('currency.site', $adminCurrency);
            } else {
                Config::set('currency.site', Currency::getDefaultOnSite());
            }
        }
    }

}
