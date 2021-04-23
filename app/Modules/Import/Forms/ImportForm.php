<?php

namespace App\Modules\Import\Forms;

use App\Components\Parsers\Entry;
use App\Core\Interfaces\FormInterface;
use CustomForm\Builder\Form;
use CustomForm\Group\Group;
use CustomForm\Group\Radio;
use CustomForm\Input;
use CustomForm\Select;
use CustomForm\Text;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ImportForm
 *
 * @package App\Core\Modules\Import\Forms
 */
class ImportForm implements FormInterface
{
    
    /**
     * @param  Model|null $model
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $model = null): Form
    {
        $form = Form::create();
        // Field set with languages tabs
        $form->fieldSet()->add(
            Group::create('type')
                ->add(
                    Radio::create('type')->setLabel(Entry::TYPE_PROM_UA)->setValue(Entry::TYPE_PROM_UA),
                    Radio::create('type')->setLabel(Entry::TYPE_YANDEX_MARKET)->setValue(Entry::TYPE_YANDEX_MARKET)
                )
                ->setDefaultValue(Entry::TYPE_PROM_UA)
                ->required(),
            Input::create('import')
                ->setLabel('Файл импорта .xlsx, .xls')
                ->setType('file')
                ->setOptions(['accept' => '.xlsx, .xls'])
                ->setHelp('При выгрузке файла с сайта prom.ua может возникнуть ошибка "Файл не является корректной выгрузкой с prom.ua". В этом случае просто откройте файл и вручную пересохраните его. Ошибка возникает потому, что выгрузка с prom.ua не всегда создает корректный файл.'),
            Input::create('url')
                ->setLabel('Укажите ссылку на .xml в формате YandexMarket'),
            Select::create('categories')
                ->add([
                    'none' => 'Ничего не делать',
                    'just-update' => 'Обновить/добавить новые',
                    'update-and-disable-old' => 'Обновить/добавить новые и снять с публикации те, которых нет в прайс-листе',
                ])
                ->setLabel('Категории')
                ->setDefaultValue('just-update')
                ->required(),
            Select::create('products')
                ->add([
                    'none' => 'Ничего не делать',
                    'just-update' => 'Обновить/добавить новые',
                    'update-and-disable-old' => 'Обновить/добавить новые и снять с публикации те, которых нет в прайс-листе',
                ])
                ->setLabel('Товары')
                ->setDefaultValue('just-update')
                ->required(),
            Select::create('images')
                ->add([
                    'none' => 'Ничего не делать',
                    'rewrite' => 'Удалить старые и загрузить новые',
                    'add' => 'Не удалять старые и догрузить новые',
                ])
                ->setHelp('Примечание: Загрузка изображений сильно увеличивает время обработки прайса. Будьте внимательны')
                ->setLabel('Изображения')
                ->setDefaultValue('none')
                ->required(),
            Text::create()->setDefaultValue(\Widget::show('import::courses'))
        );
        $form->buttons->doNotShowSaveAndAddButton();
        $form->buttons->doNotShowSaveAndCloseButton();
        $form->doNotShowTopButtons();
        return $form;
    }
    
}
