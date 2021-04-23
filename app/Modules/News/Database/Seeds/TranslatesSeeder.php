<?php

namespace App\Modules\News\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'news';

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
                    'ru' => 'Новости',
                ],
                [
                    'name' => 'general.stat-widget-title',
                    'ru' => 'Новости',
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
                    'ru' => 'Список новостей',
                ],
                [
                    'name' => 'seo.edit',
                    'ru' => 'Редактирование новости',
                ],
                [
                    'name' => 'seo.create',
                    'ru' => 'Добавление новости',
                ],
                [
                    'name' => 'seo.template-variables.name',
                    'ru' => 'Название новости',
                ],
                [
                    'name' => 'seo.template-variables.published_at',
                    'ru' => 'Дата публикации',
                ],
                [
                    'name' => 'settings.group-name',
                    'ru' => 'Новости',
                ],
                [
                    'name' => 'settings.attributes.per-page',
                    'ru' => 'Количество новостей на странице в админ панели',
                ],
                [
                    'name' => 'settings.attributes.per-page-client-side',
                    'ru' => 'Количество новостей на странице на сайт',
                ],
                [
                    'name' => 'settings.attributes.addthis-key',
                    'ru' => 'Ключ для виджета "Поделится в соц. сетях" <a href="http://www.addthis.com/" target="_blank">www.addthis.com</a>',
                ],
            ],
            Translate::PLACE_SITE => [
                [
                    'name' => 'site.news',
                    'ru' => 'Новости',
                ],
                [
                    'name' => 'site.sitemap-news',
                    'ru' => 'Новости',
                ],
                [
                    'name' => 'site.all-news',
                    'ru' => 'Все новости',
                ],
                [
                    'name' => 'site.same-news',
                    'ru' => 'Последние публикации',
                ],
                [
                    'name' => 'site.no-news',
                    'ru' => 'Обубликованных новостей нету',
                ],
            ]
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
