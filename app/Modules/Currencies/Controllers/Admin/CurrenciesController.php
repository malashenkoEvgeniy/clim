<?php

namespace App\Modules\Currencies\Controllers\Admin;

use App\Core\AdminController;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Currencies\Forms\CurrencyForm;
use App\Modules\Currencies\Models\Currency;
use App\Modules\Currencies\Requests\CurrencyRequest;
use Seo;

/**
 * Class CurrenciesController
 *
 * @package App\Modules\Currencies\Controllers\Admin
 */
class CurrenciesController extends AdminController
{
    /**
     * CurrenciesController constructor.
     */
    public function __construct()
    {
        Seo::breadcrumbs()->add(
            'currencies::seo.index',
            RouteObjectValue::make('admin.currencies.index')
        );
    }
    
    /**
     * Currencies list page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        Seo::meta()->setH1('currencies::seo.index');
        return view('currencies::admin.index', [
            'currencies' => Currency::getList(),
        ]);
    }
    
    /**
     * Update currency page
     *
     * @param Currency $currency
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(Currency $currency)
    {
        Seo::breadcrumbs()->add($currency->name ?? 'currencies::seo.edit');
        Seo::meta()->setH1('currencies::seo.edit');
        $this->initValidation((new CurrencyRequest())->rules());
        return view('currencies::admin.update', [
            'form' => CurrencyForm::make($currency),
        ]);
    }
    
    /**
     * Update information for current currency
     *
     * @param CurrencyRequest $request
     * @param Currency $currency
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(CurrencyRequest $request, Currency $currency)
    {
        $currency->updateOrCreateNew($request);
        return $this->afterUpdate();
    }
    
    /**
     * Update default on the site currency
     *
     * @param  Currency $currency
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \App\Exceptions\WrongParametersException
     */
    public function defaultOnSite(Currency $currency)
    {
        // Set new default language
        $currency->setAsDefaultOnSite();
        // Leave message and redirect back
        return $this->afterUpdate();
    }
    
    /**
     * Update default in admin panel currency
     *
     * @param  Currency $currency
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \App\Exceptions\WrongParametersException
     */
    public function defaultInAdminPanel(Currency $currency)
    {
        // Set new default language
        $currency->setAsDefaultInAdminPanel();
        // Leave message and redirect back
        return $this->afterUpdate();
    }
}
