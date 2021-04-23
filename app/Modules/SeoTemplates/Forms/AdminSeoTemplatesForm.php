<?php

namespace App\Modules\SeoTemplates\Forms;

use App\Core\Interfaces\FormInterface;
use App\Modules\SeoTemplates\Models\SeoTemplate;
use CustomForm\Builder\FieldSet;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Text;
use CustomForm\TextArea;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ArticleForm
 *
 * @package App\Core\Modules\Administrators\Forms
 */
class AdminSeoTemplatesForm implements FormInterface
{
    
    /**
     * @param Model|null $seoTemplate
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     * @throws \Throwable
     */
    public static function make(?Model $seoTemplate = null): Form
    {
        $seoTemplate = $seoTemplate ?? new SeoTemplate;
        $hasVariables = count($seoTemplate->variables) > 0;
        $form = Form::create();
        $form->buttons->doNotShowSaveAndAddButton();
        // Field set without languages tabs
        $form->fieldSetForLang(7)->add(
            Input::create('name', $seoTemplate)->required(),
            Input::create('h1', $seoTemplate)->required()->setLabel(__('seo_templates::general.h1')),
            Input::create('title', $seoTemplate)->required()->setLabel(__('seo_templates::general.title')),
            TextArea::create('keywords', $seoTemplate)->setLabel(__('seo_templates::general.keywords')),
            TextArea::create('description', $seoTemplate)->setLabel(__('seo_templates::general.description'))
        );
        if ($hasVariables) {
            $variables = $form->fieldSet(5, FieldSet::COLOR_DANGER, 'seo_templates::general.title-block');
            $variables->add(Text::create('notification')
                ->setLabel(false)
                ->setDefaultValue(view('seo_templates::admin.notification')->render()));
            foreach ($seoTemplate->variables as $variableName => $variableLabel) {
                $variables->add(
                    Input::create("var-$variableName")
                        ->setLabel($variableLabel)
                        ->setOptions(['disabled' => true])
                        ->setValue("{{{$variableName}}}")
                );
            }
        }
        return $form;
    }

}
