<?php

namespace App\Core\Modules\Settings\Controllers\Admin;

use App\Components\Settings\Models\Setting;
use App\Core\AdminController;
use App\Core\ObjectValues\RouteObjectValue;
use Illuminate\Http\Request;
use CustomSettings, Seo;
use CustomForm\Builder\Form;

/**
 * Class IndexController
 *
 * @package App\Core\Modules\Settings\Controllers
 */
class IndexController extends AdminController
{
    
    public function __construct()
    {
        Seo::breadcrumbs()->add('settings::seo.breadcrumb', RouteObjectValue::make('admin.settings.index'));
    }
    
    /**
     * Page with settings groups
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // H1
        Seo::meta()->setH1('settings::seo.h1');
        // Render page
        return view('settings::index', [
            'groups' => CustomSettings::groups(),
        ]);
    }
    
    /**
     * Group page with ability to update data
     *
     * @param  string $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function group(string $group)
    {
        // Get group by its alias
        $groupExemplar = CustomSettings::get($group);
        // No group - no page
        abort_if(!$groupExemplar, 404);
        // H1
        Seo::meta()->setH1($groupExemplar->getName());
        // Breadcrumbs
        Seo::breadcrumbs()->add($groupExemplar->getName());
        // Generate form & validation rules
        $form = Form::create();
        $fieldSet = $form->fieldSet();
        foreach ($groupExemplar->getAll() as $element) {
            $formElement = $element->getFormElement();
            $formElement->setLabel(__($formElement->getLabel()));
            $fieldSet->add($element->getFormElement());
        }
        $form->buttons->doNotShowSaveAndAddButton();
        // Validation
        $this->initValidation($groupExemplar->getRules());
        // Render page
        return view(
            'settings::group', [
                'group' => $groupExemplar,
                'form' => $form,
            ]
        );
    }
    
    /**
     * @param Request $request
     * @param string $group
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \App\Exceptions\WrongParametersException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, string $group)
    {
        // Get group by its alias
        $groupExemplar = CustomSettings::get($group);
        // No group - no page
        abort_if(!$groupExemplar, 404);
        // Validation
        $this->validate($request, $groupExemplar->getRules());
        // Update|create data
        foreach ($groupExemplar->getAll() as $element) {
            $setting = Setting::whereGroup($group)->whereAlias($element->getAlias())->firstOrNew([
                'group' => $group,
                'alias' => $element->getAlias(),
            ]);
            $setting->value = $request->input($element->getAlias());
            $setting->save();
        }
        // Leave message and redirect
        return $this->afterUpdate();
    }
    
    /**
     * Settings list preview for chosen group
     *
     * @param  string $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $group)
    {
        // Get group by its alias
        $groupExemplar = CustomSettings::get($group);
        // No group - no page
        abort_if(!$groupExemplar, 404);
        // H1
        Seo::meta()->setH1($groupExemplar->getName());
        // Breadcrumbs
        Seo::breadcrumbs()->add($groupExemplar->getName());
        // Render page
        return view(
            'settings::show', [
                'group' => $groupExemplar,
            ]
        );
    }
    
    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function clearCache()
    {
        \Artisan::call('locotrade:clear');
        return $this->customRedirect(
            'admin.settings.index',
            [],
            trans('admin.messages.cache-cleared')
        );
    }
    
}
