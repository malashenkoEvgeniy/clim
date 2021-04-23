<?php

namespace App\Core\Modules\Settings\Controllers\Admin;

use App\Components\Settings\Models\Setting;
use App\Core\AdminController;
use App\Core\Modules\Settings\Forms\WatermarkForm;
use App\Core\Modules\Settings\Requests\WatermarkRequest;
use App\Core\ObjectValues\RouteObjectValue;
use CustomSettings, Seo;

/**
 * Class IndexController
 *
 * @package App\Core\Modules\Settings\Controllers
 */
class WatermarkController extends AdminController
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
        $groupExemplar = CustomSettings::get('watermark');
        // No group - no page
        abort_if(!$groupExemplar, 404);
        // H1
        Seo::meta()->setH1($groupExemplar->getName());
        // Breadcrumbs
        Seo::breadcrumbs()->add($groupExemplar->getName());
        // Validation
        $this->jsValidation(new WatermarkRequest);
        // Render page
        return view('settings::group', [
            'group' => $groupExemplar,
            'form' => WatermarkForm::make(),
        ]);
    }
    
    /**
     * @param WatermarkRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(WatermarkRequest $request)
    {
        // Get group by its alias
        $groupExemplar = CustomSettings::get('watermark');
        // No group - no page
        abort_if(!$groupExemplar, 404);
        // Update|create data
        foreach ($request->only('position', 'width-percent', 'opacity', 'overlay') as $key => $value) {
            $setting = Setting::whereGroup('watermark')->whereAlias($key)->firstOrNew([
                'group' => 'watermark',
                'alias' => $key,
            ]);
            $setting->value = $value;
            $setting->save();
        }
        $watermark = $request->file('watermark');
        if ($watermark && $watermark->isFile() && $watermark->isValid()) {
            $watermark->storeAs('', config('image.watermark.name'));
        }
        // Leave message and redirect
        return $this->afterUpdate();
    }
    
    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function deleteWatermark()
    {
        $pathToFile = 'app/public/' . config('image.watermark.name');
        $pathToFile = preg_replace('/\/{2,}/', '/', $pathToFile);
        $pathToFile = storage_path($pathToFile);
        if (is_file($pathToFile)) {
            @unlink($pathToFile);
        }
        return $this->afterDeletingImage();
    }
    
}
