<?php

namespace App\Modules\SeoFiles\Forms;

use App\Core\Interfaces\FormInterface;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Select;
use CustomForm\TextArea;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminSeoFilesForm
 *
 * @package App\Core\Modules\SeoFiles\Forms
 */
class AdminSeoFilesForm implements FormInterface
{

    /**
     * @param  Model|null $model
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $model = null): Form
    {
        $form = Form::create();
        $form->fieldSet()->add(
            Select::create('type')
                ->add(config('seo_files.types', []))
                ->required(),
            Input::create('name', $model)->required(),
            TextArea::create('content', $model)
                ->setOptions(['rows' => 15])
        );
        return $form;
    }

}
