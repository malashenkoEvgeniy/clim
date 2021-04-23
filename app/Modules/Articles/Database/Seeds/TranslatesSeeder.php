<?php

namespace App\Modules\Articles\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'articles';

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
                    'ru' => 'Статьи',
                ],
                [
                    'name' => 'general.labels.show-short-content',
                    'ru' => 'Выводить краткое описание на внутренней странице?',
                ],
                [
                    'name' => 'general.labels.show-image',
                    'ru' => 'Выводить изображение на внутренней странице?',
                ],
                [
                    'name' => 'seo.index',
                    'ru' => 'Список статей',
                ],
                [
                    'name' => 'seo.edit',
                    'ru' => 'Редактирование статьи',
                ],
                [
                    'name' => 'seo.create',
                    'ru' => 'Добавление новой статьи',
                ],
                [
                    'name' => 'seo.template-variables.name',
                    'ru' => 'Название статьи',
                ],
                [
                    'name' => 'seo.template-variables.name',
                    'ru' => 'Название статьи',
                ],
                [
                    'name' => 'settings.group-name',
                    'ru' => 'Статьи',
                ],
                [
                    'name' => 'settings.attributes.per-page',
                    'ru' => 'Количество статей на странице в админ панели',
                ],
                [
                    'name' => 'settings.attributes.per-page-client-side',
                    'ru' => 'Количество статей на странице на сайте',
                ],
            ],
            Translate::PLACE_SITE => [
                [
                    'name' => 'site.last',
                    'ru' => 'Статьи',
                ],
                [
                    'name' => 'site.all-articles',
                    'ru' => 'Все статьи',
                ],
                [
                    'name' => 'site.sitemap-articles',
                    'ru' => 'Статьи',
                ],
            ]
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
