<?php

namespace App\Modules\ProductsAvailability\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'products-availability';

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
                    'ru' => 'Сообщить о наличии',
                ],
                [
                    'name' => 'general.settings-name',
                    'ru' => 'Сообщить о наличии',
                ],
                [
                    'name' => 'general.menu',
                    'ru' => 'Сообщить о наличии',
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
                    'ru' => 'Ваша форма успешно отправлена! Вам придет сообщение, когда товар появится в наличии',
                ],
                [
                    'name' => 'general.message-false',
                    'ru' => 'Не удалось отправить форму, перезагрузите страницу и повторите попытку',
                ],
                [
                    'name' => 'general.form-email',
                    'ru' => 'Email',
                ],
                [
                    'name' => 'general.form-submit-button',
                    'ru' => 'Отправить',
                ],
                [
                    'name' => 'general.notification',
                    'ru' => 'Новая просьба сообщить о наличии',
                ],
                [
                    'name' => 'general.mail-templates.names.products-availability',
                    'ru' => 'Поступил новый запрос',
                ],
                [
                    'name' => 'general.mail-templates.names.products-availability-for-user',
                    'ru' => 'Товар появился в наличии',
                ],
                [
                    'name' => 'general.attributes.email',
                    'ru' => 'Email заказчика',
                ],
                [
                    'name' => 'general.block',
                    'ru' => 'Заявки',
                ],
                [
                    'name' => 'seo.index',
                    'ru' => 'Заявки',
                ],
                [
                    'name' => 'seo.edit',
                    'ru' => 'Редактирование заявки',
                ],
                [
                    'name' => 'settings.group-name',
                    'ru' => 'Сообщить о наличии',
                ],
                [
                    'name' => 'settings.attributes.per-page',
                    'ru' => 'Количество заказов на странице в админ панели',
                ],
            ],
            Translate::PLACE_SITE => [
                [
                    'name' => 'site.popup.send-order-availability',
                    'ru' => 'Сообщить о наличии',
                ],
                [
                    'name' => 'site.button',
                    'ru' => 'Сообщить о наличии',
                ],
                [
                    'name' => 'site.popup.enter-the-email',
                    'ru' => 'Введите свой адрес эл.почты и мы вам сообщим, когда товар будет в наличии',
                ],
            ]
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
