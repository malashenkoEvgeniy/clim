<?php

use Illuminate\Database\Seeder;
use App\Core\Modules\Translates\Models\Translate;

class AddNewFieldToSettings extends Seeder
{
    const MODULE = 'features';
    const PModule = 'products';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $translates = [
            Translate::PLACE_ADMIN => [
                [
                    'name' => 'settings.attributes.show-features-productpage',
                    'ru' => 'Вывести основные характеристики на странице товара',
                ],
                [
                    'name' => 'general.create-feature',
                    'ru' => 'Создать характеристику',
                ],
                [
                    'name' => 'general.add-value',
                    'ru' => 'Добавить значение',
                ],
                [
                    'name' => 'general.features.create',
                    'ru' => 'Создание характеристики'
                ],
                [
                    'name' => 'general.values-create',
                    'ru' => 'Создание значений'
                ],
                [
                    'name' => 'general.values-textarea',
                    'ru' => 'Введите значения для характеристики'
                ],
                [
                    'name' => 'general.values-textareahelp',
                    'ru' => 'Для разделения значений используйте ENTER'
                ],
                [
                    'name' => 'general.attributes.features-slug',
                    'ru' => 'Алиас',
                ],
                [
                    'name' => 'general.attributes.features-name',
                    'ru' => 'Название',
                ],
                [
                    'name' => 'general.attributes.features-type',
                    'ru' => 'Тип',
                ],
                [
                    'name' => 'general.attributes.in_desc',
                    'ru' => 'Показывать в описании товара',
                ],
            ],
        ];

        $pTranslates = [
            Translate::PLACE_ADMIN => [
                [
                    'name' => 'site.price-request',
                    'ru' => 'Цена по запросу',
                ],
            ],
        ];

        Translate::setTranslates($translates, static::MODULE);
        Translate::setTranslates($pTranslates, static::PModule);
    }
}
