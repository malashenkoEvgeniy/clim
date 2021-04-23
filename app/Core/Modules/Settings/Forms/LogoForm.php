<?php

namespace App\Core\Modules\Settings\Forms;

use App\Core\Interfaces\FormInterface;
use CustomForm\Builder\FieldSet;
use CustomForm\Builder\Form;
use CustomForm\Image;
use CustomForm\Input;
use CustomForm\Macro\Toggle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class LogoForm
 *
 * @package App\Core\Modules\Settings\Forms
 */
class LogoForm implements FormInterface
{
    
    /**
     * @param Model|null $model
     * @return Form
     * @throws \App\Exceptions\WrongParametersException|\Exception
     */
    public static function make(?Model $model = null): Form
    {
        // Main logo
        $logo = Image::create('logo')->setLabel('settings::logo.image');
        $pathToFile = 'app/public/' . config('app.logo.path') . '/' . config('app.logo.filename');
        $pathToFile = preg_replace('/\/{2,}/', '/', $pathToFile);
        if (is_file(storage_path($pathToFile))) {
            $url = url(config('app.logo.urlPath') . '/' . config('app.logo.filename'));
            $logo
                ->setImage($url)
                ->setPreview($url)
                ->setDeleteUrl(route('admin.settings.delete-logo'));
        }
        // Mobile logo
        $mobileLogo = Image::create('logo_mobile')->setLabel('settings::logo.image');
        $pathToFile = 'app/public/' . config('app.logo-mobile.path') . '/' . config('app.logo-mobile.filename');
        $pathToFile = preg_replace('/\/{2,}/', '/', $pathToFile);
        if (is_file(storage_path($pathToFile))) {
            $url = url(config('app.logo-mobile.urlPath') . '/' . config('app.logo-mobile.filename'));
            $mobileLogo
                ->setImage($url)
                ->setPreview($url)
                ->setDeleteUrl(route('admin.settings.delete-logo-mobile'));
        }
        // Form
        $form = Form::create();
        $form->fieldSet(6, FieldSet::COLOR_DANGER, 'settings::logo.main-logo')->add(
            Toggle::create('use_image')
                ->setLabel('settings::logo.use-image')
                ->setValue(config('db.logo.use_image', false))
                ->required(),
            Input::create('name')
                ->setLabel('settings::logo.name')
                ->setValue(config('db.logo.name', env('APP_NAME'))),
            $logo
        );
        $form->fieldSet(6, FieldSet::COLOR_WARNING, 'settings::logo.mobile-logo')->add(
            Toggle::create('use_image_mobile')
                ->setLabel('settings::logo.use-image')
                ->setValue(config('db.logo.use_image_mobile', false))
                ->required(),
            Input::create('name_mobile')
                ->setLabel('settings::logo.name')
                ->setValue(config('db.logo.name_mobile', Str::limit(env('APP_NAME'), 1, ''))),
            $mobileLogo
        );
        $form->buttons->doNotShowSaveAndAddButton();
        return $form;
    }
    
}
