<?php

namespace App\Modules\SeoScripts\Forms;

use App\Core\Interfaces\FormInterface;
use App\Modules\SeoScripts\Models\SeoScript;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Macro\Toggle;
use CustomForm\Select;
use CustomForm\TextArea;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminSeoScriptsForm
 *
 * @package App\Core\Modules\SeoScripts\Forms
 */
class AdminSeoScriptsForm implements FormInterface
{

    /**
     * @param  Model|SeoScript|null $model
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $model = null): Form
    {
        $model = $model ?? new SeoScript;
        $form = Form::create();
        $form->fieldSet()->add(
            Toggle::create('active', $model)->required(),
            Select::create('place', $model)
                ->setLabel(__('seo_scripts::general.place'))
                ->add(config('seo_scripts.places', []))
                ->required(),
            Input::create('name', $model)->required(),
            TextArea::create('script', $model)->setLabel(__('seo_scripts::general.script'))->required()
        );
        return $form;
    }
}
