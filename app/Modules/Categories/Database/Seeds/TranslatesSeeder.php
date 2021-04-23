<?php

namespace App\Modules\Categories\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'categories';

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
                    'ru' => 'Категории',
                ],
                [
                    'name' => 'general.permission-name',
                    'ru' => 'Категории',
                ],
                [
                    'name' => 'general.validation',
                    'ru' => 'Выберите категорию из списка!',
                ],
                [
                    'name' => 'general.attributes.categories',
                    'ru' => 'Категории',
                ],
                [
                    'name' => 'general.attributes.main-category',
                    'ru' => 'Основная категория',
                ],
                [
                    'name' => 'general.messages.no-icon',
                    'ru' => 'Нет иконки',
                ],
                [
                    'name' => 'general.buy-something',
                    'ru' => 'Продолжить покупки',
                ],
                [
                    'name' => 'general.category-does-not-exist',
                    'ru' => 'Категории не существует',
                ],
                [
                    'name' => 'menu.categories',
                    'ru' => 'Категории товаров',
                ],
                [
                    'name' => 'seo.index',
                    'ru' => 'Категории товаров',
                ],
                [
                    'name' => 'seo.edit',
                    'ru' => 'Редактирование категории',
                ],
                [
                    'name' => 'seo.edit',
                    'ru' => 'Создать новую категорию товаров',
                ],
                [
                    'name' => 'seo.template-variables.category-name',
                    'ru' => 'Название категории',
                ],
                [
                    'name' => 'seo.template-variables.category-content',
                    'ru' => 'Полностью все описание категории',
                ],
                [
                    'name' => 'seo.template-variables.category-content-n',
                    'ru' => 'Часть описания категории (N символов)',
                ],
                [
                    'name' => 'settings.group-name',
                    'ru' => 'Каталог',
                ],
                [
                    'name' => 'settings.attributes.categories-per-page',
                    'ru' => 'Количество категорий на странице в админ панели',
                ],
                [
                    'name' => 'settings.attributes.products-per-page',
                    'ru' => 'Количество товаров на странице в админ панели',
                ],
                [
                    'name' => 'general.attributes.other-categories',
                    'ru' => 'Дополнимтельные категории, в которых будет отображаться товар',
                ],
            ],
            Translate::PLACE_SITE => [
                [
                    'name' => 'site.all-categories',
                    'ru' => 'Все категории',
                ],
                [
                    'name' => 'site.catalog',
                    'ru' => 'Каталог',
                ],
                [
                    'name' => 'site.show-all',
                    'ru' => 'Показать все',
                ],
            ]
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
