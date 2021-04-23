<?php

namespace App\Modules\Comments\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'comments';

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
                    'ru' => 'Комментарии',
                ],
                [
                    'name' => 'general.block',
                    'ru' => 'Комментарии',
                ],
                [
                    'name' => 'general.permission-name',
                    'ru' => 'Комментарии',
                ],
                [
                    'name' => 'general.settings-name',
                    'ru' => 'Комментарии',
                ],
                [
                    'name' => 'general.no-user',
                    'ru' => 'Не выбран',
                ],
                [
                    'name' => 'general.block',
                    'ru' => 'Комментарии',
                ],
                [
                    'name' => 'general.news',
                    'ru' => 'К новостям',
                ],
                [
                    'name' => 'general.articles',
                    'ru' => 'К статьям',
                ],
                [
                    'name' => 'menu.block',
                    'ru' => 'Комментарии',
                ],
                [
                    'name' => 'menu.products',
                    'ru' => 'К товарам',
                ],
                [
                    'name' => 'menu.groups',
                    'ru' => 'К товарам',
                ],
                [
                    'name' => 'seo.news.index',
                    'ru' => 'Список комментариев к новостям',
                ],
                [
                    'name' => 'seo.news.create',
                    'ru' => 'Создать комментарий к новости',
                ],
                [
                    'name' => 'seo.groups.index',
                    'ru' => 'Комментарии к товарам',
                ],
                [
                    'name' => 'seo.groups.edit',
                    'ru' => 'Редактирвоание комментария',
                ],
                [
                    'name' => 'seo.groups.create',
                    'ru' => 'Создание нового комментария',
                ],
                [
                    'name' => 'seo.news.update',
                    'ru' => 'Редактирование комментария к новости',
                ],
                [
                    'name' => 'seo.articles.index',
                    'ru' => 'Список комментариев к статьям',
                ],
                [
                    'name' => 'seo.articles.create',
                    'ru' => 'Создать комментарий к статье',
                ],
                [
                    'name' => 'seo.articles.update',
                    'ru' => 'Редактирование комментария к статье',
                ],
                [
                    'name' => 'seo.products.index',
                    'ru' => 'Список отзывов к товарам',
                ],
                [
                    'name' => 'seo.products.create',
                    'ru' => 'Создать отзыв к товару',
                ],
                [
                    'name' => 'seo.products.update',
                    'ru' => 'Редактирование отзыва к товару',
                ],
                [
                    'name' => 'settings.group-name',
                    'ru' => 'Комментарии',
                ],
                [
                    'name' => 'settings.products.per-page-site',
                    'ru' => 'Количество комментариев к продуктам на странице на сайте',
                ],
                [
                    'name' => 'settings.products.per-page',
                    'ru' => 'Количество комментариев к продуктам на странице в админ панели',
                ],
                [
                    'name' => 'settings.news.per-page',
                    'ru' => 'Количество комментариев к новостям на странице в админ панели',
                ],
                [
                    'name' => 'settings.articles.per-page',
                    'ru' => 'Количество комментариев к статьям на странице в админ панели',
                ],
                [
                    'name' => 'general.commentable_id',
                    'ru' => 'Объект',
                ],
            ],
            Translate::PLACE_SITE => [
                [
                    'name' => 'message.title',
                    'ru' => 'Спасибо за Ваш отзыв!',
                ],
                [
                    'name' => 'message.content',
                    'ru' => 'Он будет опубликован сразу же после одобрения администратором',
                ],
            ],
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
