<?php

namespace App\Modules\Wishlist\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'wishlist';

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
                    'ru' => 'Желания',
                ],
                [
                    'name' => 'general.settings-name',
                    'ru' => 'Желания',
                ],
                [
                    'name' => 'settings.group-name',
                    'ru' => 'Желания',
                ],
                [
                    'name' => 'settings.attributes.per-page',
                    'ru' => 'Количество товаров на странице',
                ],
                [
                    'name' => 'settings.attributes.only-cookies',
                    'ru' => 'Использовать только cookies',
                ],
            ],
            Translate::PLACE_SITE => [
                [
                    'name' => 'site.action-bar-button',
                    'ru' => 'Желания',
                ],
                [
                    'name' => 'site.account-menu-link',
                    'ru' => 'Список желаний',
                ],
                [
                    'name' => 'site.my-wishlist',
                    'ru' => 'Мой список желаний',
                ],
                [
                    'name' => 'site.my-wishlist-is-empty-part-1',
                    'ru' => 'Ваш список желаний пока пуст.',
                ],
                [
                    'name' => 'site.my-wishlist-is-empty-part-2',
                    'ru' => 'Добавив в него товары, вы можете вернуться к списку покупок в любое удобное время.',
                ],
                [
                    'name' => 'site.start-shopping',
                    'ru' => 'Начать покупки',
                ],
                [
                    'name' => 'site.buy',
                    'ru' => 'Купить',
                ],
                [
                    'name' => 'site.delete',
                    'ru' => 'Удалить',
                ],
                [
                    'name' => 'site.compare',
                    'ru' => 'Сравнить',
                ],
                [
                    'name' => 'site.products-in-money',
                    'help' => [
                        ':total' => 'labels::variables.total'
                    ],
                    'ru' => '[1]:count товар на сумму|[2,4]:count товара на сумму|[5,9]:count товаров на сумму',
                ],
                [
                    'name' => 'site.move-to-wishlist',
                    'ru' => 'Переместить в список желаний',
                ],
                [
                    'name' => 'site.in-compare',
                    'ru' => 'В сравнениях',
                ],
            ]
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
