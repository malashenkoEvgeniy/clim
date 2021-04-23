<?php

namespace App\Modules\FastOrders\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'fast_orders';

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
                    'ru' => 'Заказ в один клик',
                ],
                [
                    'name' => 'general.settings-name',
                    'ru' => 'Заказ в один клик',
                ],
                [
                    'name' => 'general.menu',
                    'ru' => 'В один клик',
                ],
                [
                    'name' => 'general.status',
                    'ru' => 'Обработан',
                ],
                [
                    'name' => 'general.product',
                    'ru' => 'Товар',
                ],
                [
                    'name' => 'general.message-success',
                    'ru' => 'Ваша форма успешно отправлена! Менеджер с Вами свяжется в кратчайший срок',
                ],
                [
                    'name' => 'general.message-false',
                    'ru' => 'Не удалось отправить форму, перезагрузите страницу и повторите попытку',
                ],
                [
                    'name' => 'general.form-phone',
                    'ru' => 'Номер телефона',
                ],
                [
                    'name' => 'general.form-submit-button',
                    'ru' => 'Отправить',
                ],
                [
                    'name' => 'general.notification',
                    'ru' => 'Новый быстрый заказ',
                ],
                [
                    'name' => 'general.mail-templates.names.fast-orders',
                    'ru' => 'Поступил новый заказ',
                ],
                [
                    'name' => 'general.attributes.phone',
                    'ru' => 'Телефон заказчика',
                ],
                [
                    'name' => 'general.block',
                    'ru' => 'Заказы',
                ],
                [
                    'name' => 'seo.index',
                    'ru' => 'Заказы в один клик',
                ],
                [
                    'name' => 'seo.edit',
                    'ru' => 'Редактирование заказа',
                ],
                [
                    'name' => 'settings.group-name',
                    'ru' => 'Заказ в один клик',
                ],
                [
                    'name' => 'settings.attributes.per-page',
                    'ru' => 'Количество заказов на странице в админ панели',
                ],
                [
                    'name' => 'general.mail-templates.attributes.phone',
                    'ru' => 'Телефон клиента',
                ],
                [
                    'name' => 'general.mail-templates.attributes.admin_href',
                    'ru' => 'Ссылка на админ панель',
                ],
            ],
            Translate::PLACE_SITE => [
                [
                    'name' => 'site.popup.buy-by-one-click',
                    'ru' => 'Купить в 1 клик',
                ],
                [
                    'name' => 'site.popup.enter-the-phone-number',
                    'ru' => 'Введите номер телефона и мы Вам перезвоним для оформления заказа,',
                ],
            ]
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
