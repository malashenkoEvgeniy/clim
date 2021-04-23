<?php

namespace App\Modules\SeoScripts\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'seo_scripts';

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
                    'ru' => 'Метрика и счетчики',
                ],
                [
                    'name' => 'general.settings-name',
                    'ru' => 'Метрика и счетчики',
                ],
                [
                    'name' => 'general.menu',
                    'ru' => 'Метрика и счетчики',
                ],
                [
                    'name' => 'general.main-menu-block',
                    'ru' => 'SEO',
                ],
                [
                    'name' => 'general.place',
                    'ru' => 'Место расположения',
                ],
                [
                    'name' => 'general.script',
                    'ru' => 'Код',
                ],
                [
                    'name' => 'general.head',
                    'ru' => 'Вставить перед </head>',
                ],
                [
                    'name' => 'general.body',
                    'ru' => 'Вставить после <body>',
                ],
                [
                    'name' => 'general.counter',
                    'ru' => 'Счетчик (в подвале сайта)',
                ],
                [
                    'name' => 'seo.index',
                    'ru' => 'Метрика и счетчики',
                ],
                [
                    'name' => 'seo.edit',
                    'ru' => 'Редактирование метрик и счетчиков',
                ],
                [
                    'name' => 'seo.create',
                    'ru' => 'Создание метрик и счетчиков',
                ],
            ]
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
