<?php

namespace App\Core\Modules\Settings\Controllers\Admin;

use App\Components\Settings\Models\Setting;
use App\Core\AdminController;
use App\Core\Modules\Settings\Forms\LogoForm;
use App\Core\Modules\Settings\Requests\LogoRequest;
use App\Core\ObjectValues\RouteObjectValue;
use CustomSettings, Seo;

/**
 * Class IndexController
 *
 * @package App\Core\Modules\Settings\Controllers
 */
class LogoController extends AdminController
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
        $groupExemplar = CustomSettings::get('logo');
        // No group - no page
        abort_if(!$groupExemplar, 404);
        // H1
        Seo::meta()->setH1($groupExemplar->getName());
        // Breadcrumbs
        Seo::breadcrumbs()->add($groupExemplar->getName());
        // Validation
        $this->jsValidation(new LogoRequest);
        // Render page
        return view('settings::group', [
            'group' => $groupExemplar,
            'form' => LogoForm::make(),
        ]);
    }
    
    /**
     * @param LogoRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(LogoRequest $request)
    {
        // Get group by its alias
        $groupExemplar = CustomSettings::get('logo');
        // No group - no page
        abort_if(!$groupExemplar, 404);
        // Update|create data
        foreach ($request->only('use_image', 'name', 'use_image_mobile', 'name_mobile') as $key => $value) {
            $setting = Setting::whereGroup('logo')->whereAlias($key)->firstOrNew([
                'group' => 'logo',
                'alias' => $key,
            ]);
            $setting->value = $value;
            $setting->save();
        }
        $logo = $request->file('logo');
        if ($logo && $logo->isFile() && $logo->isValid()) {
            $logo->storeAs(config('app.logo.path'), config('app.logo.filename'));
        }
        $logo = $request->file('logo_mobile');
        if ($logo && $logo->isFile() && $logo->isValid()) {
            $logo->storeAs(config('app.logo-mobile.path'), config('app.logo-mobile.filename'));
        }
        // Leave message and redirect
        return $this->afterUpdate();
    }
    
    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function deleteLogo()
    {
        $pathToFile = 'app/public/' . config('app.logo.path') . '/' . config('app.logo.filename');
        $pathToFile = preg_replace('/\/{2,}/', '/', $pathToFile);
        $pathToFile = storage_path($pathToFile);
        if (is_file($pathToFile)) {
            @unlink($pathToFile);
        }
        Setting::query()->updateOrCreate([
            'group' => 'logo',
            'alias' => 'use_image',
        ], [
            'value' => 0,
        ]);
        return $this->afterDeletingImage();
    }
    
    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function deleteLogoMobile()
    {
        $pathToFile = 'app/public/' . config('app.logo-mobile.path') . '/' . config('app.logo-mobile.filename');
        $pathToFile = preg_replace('/\/{2,}/', '/', $pathToFile);
        $pathToFile = storage_path($pathToFile);
        if (is_file($pathToFile)) {
            @unlink($pathToFile);
        }
        Setting::query()->updateOrCreate([
            'group' => 'logo',
            'alias' => 'use_image_mobile',
        ], [
            'value' => 0,
        ]);
        return $this->afterDeletingImage();
    }
    
}
