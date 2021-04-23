<?php

namespace App\Modules\Consultations\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'consultations';

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
                    'name' => 'general.main-menu-block',
                    'ru' => 'Обратная связь',
                ],
                [
                    'name' => 'general.menu',
                    'ru' => 'Консультации',
                ],
                [
                    'name' => 'general.question',
                    'ru' => 'Вопрос',
                ],
                [
                    'name' => 'general.status',
                    'ru' => 'Обработан',
                ],
                [
                    'name' => 'seo.index',
                    'ru' => 'Заказы консультации',
                ],
                [
                    'name' => 'seo.edit',
                    'ru' => 'Редактирование заказа консультации',
                ],
                [
                    'name' => 'settings.group-name',
                    'ru' => 'Консультации',
                ],
                [
                    'name' => 'settings.attributes.per-page',
                    'ru' => 'Количество элементов на странице в админ панели',
                ],
                [
                    'name' => 'general.mail-templates.names.consultation-admin',
                    'ru' => 'Заказ консультации (Администратору)',
                ],
                [
                    'name' => 'general.mail-templates.attributes.name',
                    'ru' => 'Имя клиента',
                ],
                [
                    'name' => 'general.mail-templates.attributes.phone',
                    'ru' => 'Телефон клиента',
                ],
                [
                    'name' => 'general.mail-templates.attributes.question',
                    'ru' => 'Вопрос клиента',
                ],
                [
                    'name' => 'general.mail-templates.attributes.admin_href',
                    'ru' => 'Ссылка на админ панель',
                ],
            ],
            Translate::PLACE_SITE => [
                [
                    'name' => 'general.message-success',
                    'ru' => 'Ваша форма успешно отправлена! Менеджер с Вами свяжется в кратчайший срок',
                ],
                [
                    'name' => 'general.message-false',
                    'ru' => 'Не удалось отправить форму, перезагрузите страницу и повторите попытку',
                ],
                [
                    'name' => 'general.form-name',
                    'ru' => 'Имя',
                ],
                [
                    'name' => 'general.form-phone',
                    'ru' => 'Номер телефона',
                ],
                [
                    'name' => 'general.form-question',
                    'ru' => 'Вопрос',
                ],
                [
                    'name' => 'general.form-submit-button',
                    'ru' => 'Отправить',
                ],
                [
                    'name' => 'general.notification',
                    'ru' => 'Новый заказ консультации',
                ],
                [
                    'name' => 'site.button',
                    'ru' => 'Консультации',
                ],
                [
                    'name' => 'site.order-consultation',
                    'ru' => 'Закажите консультацию',
                ],
                [
                    'name' => 'site.we-will-call-you-back',
                    'ru' => 'мы свяжемся с вами в ближайшее время',
                ],
                [
                    'name' => 'site.order',
                    'ru' => 'Заказать',
                ],
                [
                    'name' => 'site.name',
                    'ru' => 'Ваше ФИО',
                ],
                [
                    'name' => 'site.phone',
                    'ru' => 'Ваш номер телефона',
                ],
                [
                    'name' => 'site.question',
                    'ru' => 'Задайте Ваш вопрос',
                ],
                [
                    'name' => 'site.agreement',
                    'ru' => 'Я согласен на обработку моих данных.',
                ],
                [
                    'name' => 'site.required',
                    'ru' => 'Вы должны заполнить все обязательные поля',
                ],
            ]
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
