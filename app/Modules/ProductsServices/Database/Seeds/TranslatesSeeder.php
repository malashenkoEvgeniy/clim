<?php

namespace App\Modules\ProductsServices\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'products_services';

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
                    'name' => 'menu.group',
                    'ru' => 'Условия покупки',
                ],
                [
                    'name' => 'general.permission-name',
                    'ru' => 'Условия покупки',
                ],
                [
                    'name' => 'seo.index',
                    'ru' => 'Условия покупки',
                ],
                [
                    'name' => 'seo.create',
                    'ru' => 'Создать условие покупки',
                ],
                [
                    'name' => 'seo.edit',
                    'ru' => 'Редактировать условие покупки',
                ],
                [
                    'name' => 'attributes.description',
                    'ru' => 'Краткое описание',
                ],
                [
                    'name' => 'attributes.show_icon',
                    'ru' => 'Показывать стандарртную иконку рядом с заголовком блока?',
                ],
            ],
            Translate::PLACE_SITE => [
            
            ],
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
