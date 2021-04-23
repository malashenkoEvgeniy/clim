<?php

namespace App\Core\Modules\Mail\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'mail_templates';

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
                    'ru' => 'Шаблоны писем',
                ],
                [
                    'name' => 'general.permission-name',
                    'ru' => 'Шаблоны писем',
                ],
                [
                    'name' => 'seo.index',
                    'ru' => 'Список шаблонов писем',
                ],
                [
                    'name' => 'seo.edit',
                    'help' => [
                        ':template' => 'mail_templates::variables.name-template'
                    ],
                    'ru' => 'Редактирование шаблона письма: ":template"',
                ],
                [
                    'name' => 'settings.name',
                    'ru' => 'Шаблоны писем',
                ],
                [
                    'name' => 'settings.attributes.per-page',
                    'ru' => 'Количество элементов на странице',
                ],
                [
                    'name' => 'menu.name',
                    'ru' => 'Шаблоны писем',
                ],
                [
                    'name' => 'basic.settings-name',
                    'ru' => 'Базовые настройки',
                ],
                [
                    'name' => 'basic.attributes.admin-email',
                    'ru' => 'E-Mail администратора сайта (отправитель по умолчанию)',
                ],
                [
                    'name' => 'basic.attributes.site-email',
                    'ru' => 'E-Mail  сайта (в футере)',
                ],
                [
                    'name' => 'basic.attributes.hot-line',
                    'ru' => 'Горячая линия',
                ],
                [
                    'name' => 'basic.attributes.phone-number',
                    'ru' => 'Номер телефона',
                ],
                [
                    'name' => 'basic.attributes.schedule-ru',
                    'ru' => 'График работы (RU)',
                ],
                [
                    'name' => 'basic.attributes.schedule-uk',
                    'ru' => 'График работы (UK)',
                ],
                [
                    'name' => 'mail.settings-name',
                    'ru' => 'Почта',
                ],
                [
                    'name' => 'mail.attributes.driver',
                    'ru' => 'Почтовый сервис',
                ],
                [
                    'name' => 'mail.attributes.smtp_host',
                    'ru' => 'Хост',
                ],
                [
                    'name' => 'mail.attributes.smtp_port',
                    'ru' => 'Порт',
                ],
                [
                    'name' => 'mail.attributes.smtp_login',
                    'ru' => 'Логин',
                ],
                [
                    'name' => 'mail.attributes.smtp_password',
                    'ru' => 'Пароль',
                ],
                [
                    'name' => 'mail.attributes.smtp_from_email',
                    'ru' => 'Email отправителя',
                ],
                [
                    'name' => 'mail.attributes.smtp_from_name',
                    'ru' => 'Имя отправителя',
                ],
                [
                    'name' => 'mail.attributes.mailgun_domain',
                    'ru' => 'Mailgun domain',
                ],
                [
                    'name' => 'mail.attributes.mailgun_secret',
                    'ru' => 'Mailgun secret',
                ],
                [
                    'name' => 'mail.attributes.mandrill_secret',
                    'ru' => 'Mandrill secret',
                ],
                [
                    'name' => 'mail.attributes.sparkpost_secret',
                    'ru' => 'Sparkpost secret',
                ],
                [
                    'name' => 'mail.attributes.sendpulse_user_id',
                    'ru' => 'ID',
                ],
                [
                    'name' => 'mail.attributes.sendpulse_secret',
                    'ru' => 'Секретный ключ',
                ],
                [
                    'name' => 'mail.attributes.sendpulse_from_email',
                    'ru' => 'Email отправителя',
                ],
                [
                    'name' => 'mail.attributes.sendpulse_from_name',
                    'ru' => 'Имя отправителя',
                ],
                [
                    'name' => 'mail.attributes.smtp_encryption',
                    'ru' => 'Тип подключения ',
                ],
                [
                    'name' => 'mail.encryptions.tls',
                    'ru' => 'TLS',
                ],
                [
                    'name' => 'mail.encryptions.ssl',
                    'ru' => 'SSL',
                ],

                [
                    'name' => 'mail.drivers.smtp',
                    'ru' => 'SMTP',
                ],
                [
                    'name' => 'mail.drivers.mailgun',
                    'ru' => 'Mailgun',
                ],
                [
                    'name' => 'mail.drivers.mandrill',
                    'ru' => 'Mandrill',
                ],
                [
                    'name' => 'mail.drivers.sparkpost',
                    'ru' => 'Sparkpost',
                ],
                [
                    'name' => 'mail.drivers.sendpulse',
                    'ru' => 'SendPulse',
                ],
                [
                    'name' => 'variables.name',
                    'ru' => 'Имя зарегистрированного пользователя',
                ],
                [
                    'name' => 'variables.email',
                    'ru' => 'Email зарегистрированного пользователя',
                ],
            ],
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
