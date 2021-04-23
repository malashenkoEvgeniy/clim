<?php

namespace App\Modules\ProductsViewed\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'viewed';

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
                    'name' => 'general.menu',
                    'ru' => 'Просмотренные товары',
                ],
                [
                    'name' => 'general.settings-name',
                    'ru' => 'Просмотренные товары',
                ],
                [
                    'name' => 'general.widget-name',
                    'ru' => 'Просмотренные товары',
                ],
                [
                    'name' => 'general.see-all',
                    'ru' => 'Смотреть все',
                ],
                [
                    'name' => 'settings.group-name',
                    'ru' => 'Просмотренные товары',
                ],
                [
                    'name' => 'settings.attributes.per-page',
                    'ru' => 'Количество товаров на странице',
                ],
                [
                    'name' => 'settings.attributes.per-widget',
                    'ru' => 'Количество товаров в виджете',
                ],
            ],
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
