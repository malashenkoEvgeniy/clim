<?php

namespace App\Modules\Categories\Forms;

use App\Components\Form\ObjectValues\ModelForSelect;
use App\Core\Interfaces\FormInterface;
use App\Modules\Categories\Images\CategoryImage;
use CustomForm\Builder\FieldSet;
use CustomForm\Builder\Form;
use App\Modules\Categories\Models\Category;
use CustomForm\Image;
use CustomForm\Input;
use CustomForm\Macro\InputForSlug;
use CustomForm\Macro\Slug;
use CustomForm\Macro\Toggle;
use CustomForm\Select;
use CustomForm\TextArea;
use CustomForm\TinyMce;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CategoryForm
 *
 * @package App\Modules\Category\Forms
 */
class CategoryForm implements FormInterface
{
    
    /**
     * Make form
     *
     * @param Model|null $category
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     * @throws \Throwable
     */
    public static function make(?Model $category = null): Form
    {
        $parametersForSelect = ModelForSelect::make(Category::all())
            ->setParentIdKeyFieldName('parent_id')
            ->setValueFieldName('current.name');
        $category = $category ?? new Category();
        $form = Form::create();
        $tabs = $form->tabs();
        $mainInformationTab = $tabs->createTab('admin.tabs.general-information');
        $mainInformationTab->fieldSet(6, FieldSet::COLOR_SUCCESS)->add(
            Toggle::create('active', $category)->required(),
            Select::create('parent_id', $category)
                ->model($parametersForSelect)
                ->setCanChooseGroupElement(true)
                ->setDoNotShowElement($category->id ?? null)
                ->setPlaceholder('&mdash;'),
            Image::create(CategoryImage::getField(), $category->image)
        );
        $mainInformationTab->fieldSetForLang(6)->add(
            InputForSlug::create('name', $category)->required(),
            Slug::create('slug', $category)->required()
        );
        $tabs->createTab('admin.tabs.seo')->fieldSetForLang()->add(
            Input::create('h1', $category),
            Input::create('title', $category),
            TextArea::create('keywords', $category),
            TextArea::create('description', $category),
            TinyMce::create('seo_text', $category)
        );
        return $form;
    }
    
}
