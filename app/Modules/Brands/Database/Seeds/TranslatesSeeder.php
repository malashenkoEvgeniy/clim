<?php

namespace App\Modules\Brands\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'brands';

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
                    'ru' => 'Производители',
                ],
                [
                    'name' => 'general.permission-name',
                    'ru' => 'Производители',
                ],
                [
                    'name' => 'general.settings-name',
                    'ru' => 'Производители',
                ],
                [
                    'name' => 'general.validation',
                    'ru' => 'Выберите производителя из списка',
                ],
                [
                    'name' => 'general.brand_id',
                    'ru' => 'Производитель',
                ],
                [
                    'name' => 'seo.index',
                    'ru' => 'Список производителей',
                ],
                [
                    'name' => 'seo.edit',
                    'ru' => 'Редактирование производителя',
                ],
                [
                    'name' => 'seo.create',
                    'ru' => 'Добавление нового производителя',
                ],
                [
                    'name' => 'settings.attributes.per-page',
                    'ru' => 'Количество производителей на странице в админ панели',
                ],
                [
                    'name' => 'settings.attributes.show-our-brands-widget',
                    'ru' => 'Показывать виджет "Наши бренды"?',
                ],
            ],
            Translate::PLACE_SITE => [
                [
                    'name' => 'site.our-brands',
                    'ru' => 'Наши бренды',
                ],
                [
                    'name' => 'site.brand',
                    'ru' => 'Бренд',
                ],
            ]
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
