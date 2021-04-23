<?php

namespace App\Modules\Brands\Forms;

use App\Core\Interfaces\FormInterface;
use App\Modules\Brands\Images\BrandImage;
use App\Modules\Brands\Models\Brand;
use CustomForm\Builder\FieldSet;
use CustomForm\Builder\Form;
use CustomForm\Image;
use CustomForm\Input;
use CustomForm\Macro\InputForSlug;
use CustomForm\Macro\Slug;
use CustomForm\Macro\Toggle;
use CustomForm\TextArea;
use CustomForm\TinyMce;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BrandForm
 *
 * @package App\Core\Modules\Brands\Forms
 */
class BrandForm implements FormInterface
{
    
    /**
     * @param Model|Brand|null $brand
     * @return Form
     * @throws \App\Exceptions\WrongParametersException|\Exception
     */
    public static function make(?Model $brand = null): Form
    {
        $brand = $brand ?? new Brand;
        $form = Form::create();
        $tabs = $form->tabs();
        $mainInformationTab = $tabs->createTab('admin.tabs.general-information');
        $mainInformationTab->fieldSet(12, FieldSet::COLOR_SUCCESS)->add(
            Toggle::create('active', $brand)->required(),
            Image::create(BrandImage::getField(), $brand->image)
        );
        $mainInformationTab->fieldSetForLang(12)->add(
            InputForSlug::create('name', $brand)->required(),
            Slug::create('slug', $brand)->required(),
            TinyMce::create('content', $brand)
        );
        $tabs->createTab('admin.tabs.seo')->fieldSetForLang()->add(
            Input::create('h1', $brand),
            Input::create('title', $brand),
            TextArea::create('keywords', $brand),
            TextArea::create('description', $brand)
        );
        return $form;
    }
    
}
