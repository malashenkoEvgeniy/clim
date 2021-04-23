<?php

namespace App\Core\Modules\Settings\Forms;

use App\Core\Interfaces\FormInterface;
use App\Modules\Reviews\Models\Review;
use CustomForm\Builder\FieldSet;
use CustomForm\Builder\Form;
use CustomForm\Image;
use CustomForm\Input;
use CustomForm\Macro\Toggle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class ReviewForm
 *
 * @package App\Core\Modules\Settings\Forms
 */
class ReviewForm implements FormInterface
{
    
    /**
     * @param Model|null $model
     * @return Form
     * @throws \App\Exceptions\WrongParametersException|\Exception
     */
    public static function make(?Model $model = null): Form
    {
        // Background
        $bg = Image::create('background')
            ->setHelp(trans('reviews::messages.background-size'))
            ->setLabel('reviews::settings.attributes.background');
        $pathToFile = 'app/public/' . config('db.reviews.background');
        if (is_file(storage_path($pathToFile))) {
            $url = url('storage/' . config('db.reviews.background'));
            $bg
                ->setImage($url)
                ->setPreview($url)
                ->setDeleteUrl(route('admin.settings.delete-reviews'));
        }
        // Form
        $form = Form::create();
        $form->fieldSet()->add(
            Input::create('per-page')
                ->setType('number')
                ->setOptions(['min' => 1, 'max' => 100])
                ->setLabel('reviews::settings.attributes.per-page')
                ->setValue(config('db.reviews.per-page', 10)),
            Input::create('per-page-client-side')
                ->setType('number')
                ->setOptions(['min' => 1, 'max' => 100])
                ->setLabel('reviews::settings.attributes.per-page-client-side')
                ->setValue(config('db.reviews.per-page-client-side', 10)),
            Input::create('count-in-widget')
                ->setType('number')
                ->setOptions(['min' => 1, 'max' => Review::WIDGET_LIMIT])
                ->setLabel('reviews::settings.attributes.count-in-widget')
                ->setValue(config('db.reviews.count-in-widget', Review::WIDGET_LIMIT)),
            $bg
        );
        $form->buttons->doNotShowSaveAndAddButton();
        return $form;
    }
    
}
