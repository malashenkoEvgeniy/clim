<?php

namespace App\Modules\CompareProducts\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'compare';

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
                    'ru' => 'Сравнения',
                ],
            ],
            Translate::PLACE_SITE => [
                [
                    'name' => 'general.compare',
                    'ru' => 'Сравнить',
                ],
                [
                    'name' => 'site.compare',
                    'ru' => 'Сравнить',
                ],
                [
                    'name' => 'site.compare-products',
                    'ru' => 'Товары в сравнении',
                ],
                [
                    'name' => 'site.compare-products-empty',
                    'ru' => 'Нет товаров в сравнении',
                ],
                [
                    'name' => 'site.add-products-to-compare',
                    'ru' => 'Добавляйте товары к сравнению характеристик и выбирайте самый подходящий Вам товар.',
                ],
            ]
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
