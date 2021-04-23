<?php

namespace App\Modules\SeoRedirects\Forms;

use App\Core\Interfaces\FormInterface;
use App\Modules\SeoRedirects\Models\SeoRedirect;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Macro\Toggle;
use CustomForm\Select;
use Illuminate\Database\Eloquent\Model;

/**
* Class AdminSeoRedirectsForm
*
* @package App\Core\Modules\SeoRedirects\Forms
*/
class AdminSeoRedirectsForm implements FormInterface
{

    /**
     * @param  Model|SeoRedirect|null $model
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $model = null): Form
    {
        $model = $model ?? new SeoRedirect();
        $form = Form::create();
        $form->fieldSet()->add(
            Toggle::create('active', $model)->setDefaultValue(true)->required(),
            Input::create('link_from', $model)->setLabel(__('seo_redirects::general.link_from'))->required(),
            Input::create('link_to', $model)->setLabel(__('seo_redirects::general.link_to'))->required(),
            Select::create('type', $model)
                ->setDefaultValue(302)
                ->add(config('seo_redirects.types', []))
                ->required()
        );
        return $form;
    }
}
