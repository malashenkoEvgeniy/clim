<?php

namespace App\Modules\SeoFiles\Forms;

use App\Core\Interfaces\FormInterface;
use App\Modules\SeoFiles\Models\SeoFile;
use CustomForm\Builder\Form;
use CustomForm\Text;
use CustomForm\TextArea;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminUpdateSeoFileForm
 *
 * @package App\Core\Modules\SeoFiles\Forms
 */
class AdminUpdateSeoFileForm implements FormInterface
{

    /**
     * @param  Model|SeoFile|null $seoFile
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $seoFile = null): Form
    {
        $seoFile = $seoFile ?? new SeoFile();
        $form = Form::create();
        $form->fieldSet()->add(
            Text::create('name')->setDefaultValue(\Html::link($seoFile->url, $seoFile->name, ['target' => '_blank'], false)),
            Text::create('mime', $seoFile)->setLabel('seo_files::general.mime'),
            Text::create('size')
                ->setValue($seoFile->size . ' ' . __('seo_files::general.byte'))
                ->setLabel('seo_files::general.size'),
            TextArea::create('content')
                ->setValue($seoFile->content)
                ->setLabel('seo_files::general.content')
                ->setOptions(['rows' => 15])
        );
        return $form;
    }

}
