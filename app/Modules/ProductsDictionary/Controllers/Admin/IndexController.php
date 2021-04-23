<?php

namespace App\Modules\ProductsDictionary\Controllers\Admin;

use App\Components\Settings\Models\Setting;
use App\Core\AdminController;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\ProductsDictionary\Forms\DictionaryForm;
use App\Modules\ProductsDictionary\Requests\DictionaryRequest;
use Illuminate\Http\Request;
use CustomSettings, Seo;
use CustomForm\Builder\Form;

/**
 * Class IndexController
 *
 * @package App\Modules\ProductsDictionary\Controllers\Admin
 */
class IndexController extends AdminController
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
        $groupExemplar = CustomSettings::get('products_dictionary');
        // H1
        Seo::meta()->setH1($groupExemplar->getName());
        // Breadcrumbs
        Seo::breadcrumbs()->add($groupExemplar->getName());
        // Validation
        $this->initValidation((new DictionaryRequest)->rules());
        // Render page
        return view('settings::group', [
            'group' => $groupExemplar,
            'form' => DictionaryForm::make(),
        ]);
    }

    /**
     * @param DictionaryRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(DictionaryRequest $request)
    {

        // Update|create data
        foreach (config('languages', []) AS $language) {

            $current = Setting::whereGroup('products_dictionary')->whereAlias($language->slug . '_title')->firstOrNew([
                'group' => 'products_dictionary',
                'alias' => $language->slug . '_title',
            ]);
            $current->value = $request->input($language->slug)['products_dictionary_title'];
            $current->save();
        }
        foreach ($request->only(
            'site_status',
            'select_status'
        ) as $key => $value) {
            $current = Setting::whereGroup('products_dictionary')->whereAlias($key)->firstOrNew([
                'group' => 'products_dictionary',
                'alias' => $key,
            ]);
            $current->value = $value;
            $current->save();
        }

        // Leave message and redirect
        return $this->afterUpdate();
    }

}
