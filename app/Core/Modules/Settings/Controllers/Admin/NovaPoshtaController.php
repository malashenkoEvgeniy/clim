<?php

namespace App\Core\Modules\Settings\Controllers\Admin;

use App\Components\Settings\Models\Setting;
use App\Core\AdminController;
use App\Core\Modules\Settings\Forms\NovaPoshtaForm;
use App\Core\Modules\Settings\Requests\NovaPoshtaRequest;
use App\Core\ObjectValues\RouteObjectValue;
use CustomSettings, Seo;

/**
 * Class NovaPoshtaController
 *
 * @package App\Core\Modules\Settings\Controllers
 */
class NovaPoshtaController extends AdminController
{
    
    public function __construct()
    {
        Seo::breadcrumbs()->add('settings::seo.breadcrumb', RouteObjectValue::make('admin.settings.index'));
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function index()
    {
        // Get group by its alias
        $groupExemplar = CustomSettings::get('nova-poshta');
        // No group - no page
        abort_if(!$groupExemplar, 404);
        // H1
        Seo::meta()->setH1($groupExemplar->getName());
        // Breadcrumbs
        Seo::breadcrumbs()->add($groupExemplar->getName());
        // Validation
        $this->jsValidation(new NovaPoshtaRequest);
        // Render page
        return view('settings::group', [
            'group' => $groupExemplar,
            'form' => NovaPoshtaForm::make(),
        ]);
    }
    
    /**
     * @param NovaPoshtaRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(NovaPoshtaRequest $request)
    {
        // Get group by its alias
        $groupExemplar = CustomSettings::get('nova-poshta');
        // No group - no page
        abort_if(!$groupExemplar, 404);
        // Update|create data
        foreach ($request->only(
            'key',
            'sender-last-name',
            'sender-first-name',
            'sender-middle-name',
            'sender-phone',
            'sender-city',
            'sender-warehouse'
        ) as $key => $value) {
            $setting = Setting::whereGroup('nova-poshta')->whereAlias($key)->firstOrNew([
                'group' => 'nova-poshta',
                'alias' => $key,
            ]);
            $setting->value = $value;
            $setting->save();
        }
        // Leave message and redirect
        return $this->afterUpdate();
    }
    
}
