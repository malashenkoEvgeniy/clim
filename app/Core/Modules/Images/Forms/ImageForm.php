<?php

namespace App\Core\Modules\Images\Forms;

use App\Core\Interfaces\FormInterface;
use App\Exceptions\WrongParametersException;
use App\Traits\Imageable;
use CustomForm\Builder\FieldSet;
use CustomForm\Builder\FieldSetLang;
use CustomForm\Builder\Form;
use CustomForm\Element;
use CustomForm\Input;
use CustomForm\Text;
use Illuminate\Database\Eloquent\Model;
use App\Core\Modules\Images\Models\Image as ImageModel;
use Html;

/**
 * Class GalleryImageForm
 *
 * @package App\Modules\Gallery\Forms
 */
class ImageForm implements FormInterface
{
    
    /**
     * @param Model|ImageModel|null $image
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $image = null): Form
    {
        $image = $image ?? new ImageModel();
        $form = Form::create();
        // Simple field set
        $form->fieldSet(12, FieldSet::COLOR_SUCCESS)->add(
            Text::create('image')
                ->setValue(Html::image($image->link('small') ?? $image->link('original'), null, [
                    'style' => 'max-width: 400px; max-height: 300px;',
                ]))
        );
        // Field set with languages tabs
        $form->fieldSetForLang()->add(
            Input::create('alt', $image),
            Input::create('title', $image)
        );
        
        /** @var Imageable|Model $model */
        $model = (new $image->imageable_class)->findOrFail($image->imageable_id);
        $imageInstance = $model->imageInstance($image->imageable_type);
        $fieldSet = new FieldSet();
        foreach ($imageInstance->additionalFormFields() as $formElement) {
            if ($formElement instanceof FieldSet) {
                $formElement->getFields()->each(function (Element $element) use ($image) {
                    $element->setValue(array_get($image->information, $element->getName()));
                });
                $form->addFieldSet($formElement);
            } elseif($formElement instanceof FieldSetLang) {
                $formElement->getFields()->each(function (Element $element) use ($image) {
                    $element->setValue(array_get($image->information, $element->getName()));
                });
                $form->addFieldSetForLang($formElement);
            } elseif($formElement instanceof Element) {
                $formElement->setValue(array_get($image->information, $formElement->getName()));
                $fieldSet->add($formElement);
            } else {
                throw new WrongParametersException('Wrong form element type!');
            }
        }
        if ($fieldSet->getFields()->isNotEmpty()) {
            $fieldSet->getFields()->each(function (Element $element) use ($image) {
                $element->setValue(array_get($image->information, $element->getName()));
            });
            $form->addFieldSet($fieldSet);
        }
        
        $form->buttons->forceShowCloseButton()->doNotShowSaveAndAddButton()->doNotShowSaveAndCloseButton();
        return $form;
    }
    
}
