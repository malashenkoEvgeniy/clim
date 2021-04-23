<?php

namespace App\Core\Modules\Administrators\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;
use App\Core\Modules\Administrators\Models\RoleRule;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'admins';

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
                    'ru' => 'Администраторы',
                ],
                [
                    'name' => 'seo.admins.index',
                    'ru' => 'Администраторы',
                ],
                [
                    'name' => 'seo.admins.edit',
                    'ru' => 'Редактирование администратора',
                ],
                [
                    'name' => 'seo.admins.create',
                    'ru' => 'Добавление нового администратора',
                ],
                [
                    'name' => 'seo.roles.index',
                    'ru' => 'Роли администраторов',
                ],
                [
                    'name' => 'seo.roles.edit',
                    'ru' => 'Редактирование роли',
                ],
                [
                    'name' => 'seo.roles.create',
                    'ru' => 'Добавление новой роли',
                ],
                [
                    'name' => 'settings.group-name',
                    'ru' => 'Администраторы',
                ],
                [
                    'name' => 'settings.attributes.per-page',
                    'ru' => 'Количество администраторов на странице в админ панели',
                ],
                [
                    'name' => 'settings.attributes.roles-per-page',
                    'ru' => 'Количество ролей на странице в админ панели',
                ],
                [
                    'name' => 'attributes.created_at',
                    'ru' => 'Количество ролей на странице в админ панели',
                ],
                [
                    'name' => 'attributes.roles',
                    'ru' => 'Список ролей',
                ],
                [
                    'name' => 'buttons.upload',
                    'ru' => 'Загрузить аватар',
                ],
                [
                    'name' => 'menu.block',
                    'ru' => 'Администрация',
                ],
                [
                    'name' => 'menu.admins',
                    'ru' => 'Администраторы',
                ],
                [
                    'name' => 'menu.roles',
                    'ru' => 'Роли администраторов',
                ],
                [
                    'name' => 'user-menu.personal-data',
                    'ru' => 'Личные данные',
                ],
                [
                    'name' => 'user-menu.change-password',
                    'ru' => 'Сменить пароль',
                ],
                [
                    'name' => 'user-menu.change-avatar',
                    'ru' => 'Сменить аватар',
                ],
                [
                    'name' => 'roles.no-role',
                    'ru' => 'Не указана',
                ],
                [
                    'name' => 'roles.rules.'.RoleRule::INDEX,
                    'ru' => 'Список',
                ],
                [
                    'name' => 'roles.rules.'.RoleRule::VIEW,
                    'ru' => 'Просмотр',
                ],
                [
                    'name' => 'roles.rules.'.RoleRule::STORE,
                    'ru' => 'Создание',
                ],
                [
                    'name' => 'roles.rules.'.RoleRule::UPDATE,
                    'ru' => 'Редактирование',
                ],
                [
                    'name' => 'roles.rules.'.RoleRule::DELETE,
                    'ru' => 'Удаление',
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
                        ':count' => 'admins::variables.count-items'
                    ],
                    'ru' => '[1]:count товар на сумму|[2,4]:count товара на сумму|[5,9]:count товаров на сумму',
                ],
                [
                    'name' => 'site.move-to-wishlist',
                    'ru' => 'Переместить в список желаний',
                ],
            ]
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
