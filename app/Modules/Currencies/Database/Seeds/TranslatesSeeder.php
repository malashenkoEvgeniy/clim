<?php

namespace App\Modules\Currencies\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'currencies';

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
                    'name' => 'general.course',
                    'ru' => 'По текущему курсу НБУ: 1 :from = :amount :to',
                ],
                [
                    'name' => 'general.menu',
                    'ru' => 'Валюты',
                ],
                [
                    'name' => 'general.permission-name',
                    'ru' => 'Валюты',
                ],
                [
                    'name' => 'general.attributes.default_on_site',
                    'ru' => 'Валюта на сайте',
                ],
                [
                    'name' => 'general.attributes.default_in_admin_panel',
                    'ru' => 'Валюта наполнения',
                ],
                [
                    'name' => 'general.attributes.sign',
                    'ru' => 'Знак',
                ],
                [
                    'name' => 'general.attributes.multiplier',
                    'ru' => 'Курс',
                ],
                [
                    'name' => 'menu.currencies',
                    'ru' => 'Валюты',
                ],
                [
                    'name' => 'seo.index',
                    'ru' => 'Список валют',
                ],
                [
                    'name' => 'seo.create',
                    'ru' => 'Создать новую валюту',
                ],
                [
                    'name' => 'seo.edit',
                    'ru' => 'Редактирование валюты',
                ],
                [
                    'name' => 'settings.group-name',
                    'ru' => 'Форматирование цены',
                ],
                [
                    'name' => 'settings.locations-left',
                    'ru' => 'Слева',
                ],
                [
                    'name' => 'settings.locations-right',
                    'ru' => 'Справа',
                ],
                [
                    'name' => 'settings.locations',
                    'ru' => 'Расположения знака валюты',
                ],
                [
                    'name' => 'settings.number-symbols-none',
                    'ru' => 'Нет',
                ],
                [
                    'name' => 'settings.number-symbols-tenths',
                    'ru' => 'Округлить до десятых',
                ],
                [
                    'name' => 'settings.number-symbols-hundredths',
                    'ru' => 'Округлить до сотых',
                ],
                [
                    'name' => 'settings.number-symbols',
                    'ru' => 'Количество знаков после запятой',
                ],
                [
                    'name' => 'settings.types-first',
                    'ru' => '1,235 - английский формат (по умолчанию)',
                ],
                [
                    'name' => 'settings.types-second',
                    'ru' => '1 234,56 - французский формат',
                ],
                [
                    'name' => 'settings.types-third',
                    'ru' => '1234.57 - английский формат без разделителей групп',
                ],
                [
                    'name' => 'settings.types',
                    'ru' => 'Формат цены',
                ],
                [
                    'name' => 'general.course',
                    'ru' => '1 :from = :amount :to по курсу НБУ',
                ],
            ],
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
