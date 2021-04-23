<?php

namespace App\Modules\Pages\Forms;

use App\Core\Interfaces\FormInterface;
use App\Modules\Pages\Models\Page;
use CustomForm\Builder\FieldSet;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Macro\InputForSlug;
use CustomForm\Macro\Slug;
use CustomForm\Macro\Toggle;
use CustomForm\Select;
use CustomForm\TextArea;
use CustomForm\TinyMce;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PagesForm
 *
 * @package App\Core\Modules\Administrators\Forms
 */
class PagesForm implements FormInterface
{
    
    /**
     * @param  Model|Page|null $page
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $page = null): Form
    {
        $page = $page ?? new Page;
        $parametersForSelect = config('pages.menu_group');
        $form = Form::create();
        // Simple field set
        $form->fieldSet(12, FieldSet::COLOR_SUCCESS)->add(
            Toggle::create('active', $page)->required()
            /*Select::create('parent_id', $page)
                ->setPlaceholder('&mdash;')
                ->add($page->generateDropDownArray()),*/
            /*Select::create('menu', $page)
                ->add($parametersForSelect)
                ->setPlaceholder('&mdash;')->setLabel(__('pages::general.menu-type-field'))*/
        );
        // Field set with languages tabs
        $form->fieldSetForLang(12)->add(
            InputForSlug::create('name', $page)->required(),
            Slug::create('slug', $page)->required(),
            TinyMce::create('content', $page),
            Input::create('h1', $page),
            Input::create('title', $page),
            TextArea::create('keywords', $page),
            TextArea::create('description', $page)
        );
        return $form;
    }
    
}
