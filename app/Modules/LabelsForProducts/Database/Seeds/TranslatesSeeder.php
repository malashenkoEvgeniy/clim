<?php

namespace App\Modules\LabelsForProducts\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'labels';

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
                    'name' => 'general.permission-name',
                    'ru' => 'Метки',
                ],
                [
                    'name' => 'general.settings-name',
                    'ru' => 'Метки',
                ],
                [
                    'name' => 'general.menu',
                    'ru' => 'Метки',
                ],
                [
                    'name' => 'general.attributes.text',
                    'ru' => 'Надпись на метке',
                ],
                [
                    'name' => 'general.per-page',
                    'ru' => 'Количество товаров на странице',
                ],
                [
                    'name' => 'general.limit-in-widget',
                    'ru' => 'Максимальное количетсво товаров в виджете метки',
                ],
                [
                    'name' => 'general.minimum-in-widget',
                    'ru' =>  'Минимальное количество товаров в виджете метки для показа',
                ],
                [
                    'name' => 'seo.index',
                    'ru' => 'Список меток',
                ],
                [
                    'name' => 'seo.edit',
                    'ru' => 'Редактирование метки',
                ],
                [
                    'name' => 'seo.create',
                    'ru' => 'Добавление новой метки',
                ],
            ],
            Translate::PLACE_SITE => [
                [
                    'name' => 'site.all',
                    'help' => [
                        ':name' => 'labels::variables.name'
                    ],
                    'ru' => 'Все :name',
                ],
            ]
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
