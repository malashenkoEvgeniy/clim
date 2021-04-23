<?php

namespace App\Core\Modules\Settings\Forms;

use App\Components\Image\Watermark;
use App\Core\Interfaces\FormInterface;
use CustomForm\Builder\FieldSet;
use CustomForm\Builder\Form;
use CustomForm\Image;
use CustomForm\Input;
use CustomForm\Macro\Toggle;
use CustomForm\Select;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WatermarkForm
 *
 * @package App\Core\Modules\Settings\Forms
 */
class WatermarkForm implements FormInterface
{
    
    /**
     * @param Model|null $model
     * @return Form
     * @throws \App\Exceptions\WrongParametersException|\Exception
     */
    public static function make(?Model $model = null): Form
    {
        // Main watermark
        $watermark = Image::create('watermark')
            ->setOptions(['accept' => 'png'])
            ->setLabel('settings::watermark.image');
        $pathToFile = 'app/public/' . config('image.watermark.name');
        if (is_file(storage_path($pathToFile))) {
            $url = url('storage/' . config('image.watermark.name'));
            $watermark
                ->setImage($url)
                ->setPreview($url)
                ->setDeleteUrl(route('admin.settings.delete-watermark'));
        }
        // Form
        $form = Form::create();
        $form->fieldSet(6, FieldSet::COLOR_DANGER)->add(
            Toggle::create('overlay')
                ->setLabel('settings::watermark.overlay')
                ->setValue(config('db.watermark.overlay', false)),
            Select::create('position')
                ->setLabel('settings::watermark.positions')
                ->add(config('settings.watermark-positions'))
                ->setValue(config('db.watermark.position', Watermark::POSITION_BOTTOM)),
            Input::create('width-percent')
                ->setType('number')
                ->setLabel('settings::watermark.width')
                ->setValue(config('db.watermark.width-percent', 50))
                ->setOptions(['min' => 1, 'max' => 100])
                ->required(),
            Input::create('opacity')
                ->setType('number')
                ->setLabel('settings::watermark.opacity')
                ->setValue(config('db.watermark.opacity', 100))
                ->setOptions(['min' => 1, 'max' => 100])
                ->required()
        );
        $form->fieldSet(6, FieldSet::COLOR_WARNING)->add(
            $watermark
        );
        $form->buttons->doNotShowSaveAndAddButton();
        return $form;
    }
    
}
