<?php

namespace App\Core\Modules\Settings\Controllers\Admin;

use App\Components\Settings\Models\Setting;
use App\Core\AdminController;
use App\Core\Modules\Settings\Forms\LogoForm;
use App\Core\Modules\Settings\Forms\ReviewForm;
use App\Core\Modules\Settings\Requests\LogoRequest;
use App\Core\Modules\Settings\Requests\ReviewRequest;
use App\Core\ObjectValues\RouteObjectValue;
use CustomSettings, Seo;

/**
 * Class ReviewController
 *
 * @package App\Core\Modules\Settings\Controllers
 */
class ReviewController extends AdminController
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
        $groupExemplar = CustomSettings::get('reviews');
        abort_if(!$groupExemplar, 404);
        Seo::meta()->setH1($groupExemplar->getName());
        Seo::breadcrumbs()->add($groupExemplar->getName());
        $this->jsValidation(new ReviewRequest);
        return view('settings::group', [
            'group' => $groupExemplar,
            'form' => ReviewForm::make(),
        ]);
    }
    
    /**
     * @param ReviewRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(ReviewRequest $request)
    {
        // Get group by its alias
        $groupExemplar = CustomSettings::get('reviews');
        // No group - no page
        abort_if(!$groupExemplar, 404);
        // Update|create data
        foreach ($request->only('per-page', 'per-page-client-side', 'count-in-widget') as $key => $value) {
            $setting = Setting::whereGroup('reviews')->whereAlias($key)->firstOrNew([
                'group' => 'reviews',
                'alias' => $key,
            ]);
            $setting->value = $value;
            $setting->save();
        }
        $bg = $request->file('background');
        if ($bg && $bg->isFile() && $bg->isValid()) {
            $filename = $bg->hashName();
            $bg->storeAs('', $filename);
            Setting::updateOrCreate([
                'group' => 'reviews',
                'alias' => 'background',
            ], [
                'value' => $filename,
            ]);
        }
        // Leave message and redirect
        return $this->afterUpdate();
    }
    
    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function deleteBackground()
    {
        $pathToFile = 'app/public/' . config('db.reviews.background');
        $pathToFile = storage_path($pathToFile);
        if (is_file($pathToFile)) {
            @unlink($pathToFile);
        }
        Setting::query()->updateOrCreate([
            'group' => 'reviews',
            'alias' => 'background',
        ], [
            'value' => '',
        ]);
        return $this->afterDeletingImage();
    }
    
}
