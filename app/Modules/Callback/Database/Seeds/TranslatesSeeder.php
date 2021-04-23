<?php

namespace App\Modules\Callback\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'callback';

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
                    'ru' => 'Обратный звонок',
                ],
                [
                    'name' => 'general.status',
                    'ru' => 'Обработан',
                ],
                [
                    'name' => 'seo.index',
                    'ru' => 'Заказы обратного звонка',
                ],
                [
                    'name' => 'seo.edit',
                    'ru' => 'Редактирование заказа обратного звонка',
                ],
                [
                    'name' => 'settings.group-name',
                    'ru' => 'Обратный звонок',
                ],
                [
                    'name' => 'settings.attributes.per-page',
                    'ru' => 'Количество элементов на странице в админ панели',
                ],
                [
                    'name' => 'general.mail-templates.names.callback-admin',
                    'ru' => 'Заказ обратного звонка (Администратору)',
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
                    'name' => 'general.form-submit-button',
                    'ru' => 'Отправить',
                ],
                [
                    'name' => 'general.notification',
                    'ru' => 'Новый заказ звонка',
                ],
                [
                    'name' => 'site.button',
                    'ru' => 'Заказать звонок',
                ],
                [
                    'name' => 'site.order-callback',
                    'ru' => 'Закажите звонок',
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
                    'name' => 'site.agreement',
                    'ru' => 'Я согласен на обработку моих данных.',
                ],
                [
                    'name' => 'site.required',
                    'ru' => 'Вы должны заполнить все обязательные поля',
                ],
                [
                    'name' => 'site.or',
                    'ru' => 'Или',
                ],
                [
                    'name' => 'site.consult',
                    'ru' => 'Закажите консультацию'
                ],
                [
                    'name' => 'site.ask-question',
                    'ru' => 'Если у вас остались вопросы о продукции или вы желаете рассчитать стоимость работ - закажите бесплатный звонок и наши специалисты свяжутся с вами.'
                ]
            ],
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
