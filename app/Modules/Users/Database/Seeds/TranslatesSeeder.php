<?php

namespace App\Modules\Users\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'users';

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
                    'ru' => 'Пользователи',
                ],
                [
                    'name' => 'general.menu.list',
                    'ru' => 'Клиенты',
                ],
                [
                    'name' => 'general.menu.block',
                    'ru' => 'Пользователи',
                ],
                [
                    'name' => 'general.stat-widget-title',
                    'ru' => 'Клиенты',
                ],
                [
                    'name' => 'general.attributes.created_at',
                    'ru' => 'Дата регистрации',
                ],
                [
                    'name' => 'general.registered',
                    'help' => [
                        ':date' => 'labels::variables.date'
                    ],
                    'ru' => 'Зарегистрирован :date',
                ],
                [
                    'name' => 'general.deleted',
                    'help' => [
                        ':date' => 'labels::variables.date'
                    ],
                    'ru' => 'Удален :date',
                ],
                [
                    'name' => 'general.personal-info',
                    'ru' => 'Личная информация',
                ],
                [
                    'name' => 'general.settings',
                    'ru' => 'Настройки',
                ],
                [
                    'name' => 'general.notification',
                    'ru' => 'Новый пользователь',
                ],
                [
                    'name' => 'general.phone',
                    'ru' => 'Моб. телефон',
                ],
                [
                    'name' => 'general.email',
                    'ru' => 'Email',
                ],
                [
                    'name' => 'general.customer-page',
                    'ru' => 'Страница пользователя',
                ],
                [
                    'name' => 'general.user',
                    'ru' => 'Пользователь',
                ],
                [
                    'name' => 'seo.index',
                    'ru' => 'Список клиентов',
                ],
                [
                    'name' => 'seo.deleted',
                    'ru' => 'Удаленные клиенты',
                ],
                [
                    'name' => 'seo.edit',
                    'ru' => 'Редактирование клиентов',
                ],
                [
                    'name' => 'seo.create',
                    'ru' => 'Добавление нового клиента',
                ],
                [
                    'name' => 'settings.group-name',
                    'ru' => 'Пользователи',
                ],
                [
                    'name' => 'settings.attributes.per-page',
                    'ru' => 'Количество пользователей на странице в админ панели',
                ],
                [
                    'name' => 'settings.attributes.auth-by-phone',
                    'ru' => 'Включить авторизацию по номеру телефона',
                ],
                [
                    'name' => 'auth.registered-successfully',
                    'ru' => 'Вы были успешно зарегистрированы',
                ],
                [
                    'name' => 'mail-templates.names.registration',
                    'ru' => 'Регистрация нового пользователя',
                ],
                [
                    'name' => 'mail-templates.names.forgot-password',
                    'ru' => 'Форма "Забыли пароль"',
                ],
                [
                    'name' => 'mail-templates.attributes.email',
                    'ru' => 'Email',
                ],
                [
                    'name' => 'mail-templates.attributes.password',
                    'ru' => 'Пароль',
                ],
                [
                    'name' => 'mail-templates.attributes.link',
                    'ru' => 'Ссылка на страницу обновления пароля',
                ],
            ],
            Translate::PLACE_SITE => [
                [
                    'name' => 'site.entrance-to-the-site',
                    'ru' => 'Вход в личный кабинет',
                ],
                [
                    'name' => 'site.logout-from-the-site',
                    'ru' => 'Выйти',
                ],
                [
                    'name' => 'site.my-account',
                    'ru' => 'Личные данные',
                ],
                [
                    'name' => 'site.menu.right.edit',
                    'ru' => 'Редактировать личные данныее',
                ],
                [
                    'name' => 'site.menu.right.address',
                    'ru' => 'Изменить адрес',
                ],
                [
                    'name' => 'site.menu.right.password',
                    'ru' => 'Изменить пароль',
                ],
                [
                    'name' => 'site.menu.right.phone',
                    'ru' => 'Изменить номер телефона',
                ],
                [
                    'name' => 'site.menu.left.profile',
                    'ru' => 'Личные данные',
                ],
                [
                    'name' => 'site.mobile.cabinet',
                    'ru' => 'Личные данные',
                ],
                [
                    'name' => 'site.male',
                    'ru' => 'Мужской',
                ],
                [
                    'name' => 'site.female',
                    'ru' => 'Женский',
                ],
                [
                    'name' => 'site.sms-code-sent',
                    'ru' => 'SMS код отправлен',
                ],
                [
                    'name' => 'site.sms-code-not-sent',
                    'ru' => 'Невохможно отправить SMS код. Ошибка сервиса',
                ],
                [
                    'name' => 'site.wrong-code',
                    'ru' => 'Введите код, отправленный на указанный номер телефона',
                ],
                [
                    'name' => 'site.your-code',
                    'help' => [
                        ':code' => 'labels::variables.code'
                    ],
                    'ru' => 'Ваш код для регистрации: :code',
                ],
                [
                    'name' => 'site.seo.my-profile',
                    'ru' => 'Личные данные',
                ],
                [
                    'name' => 'site.seo.edit-profile',
                    'ru' => 'Изменение личных данных',
                ],
                [
                    'name' => 'site.seo.edit-phone',
                    'ru' => 'Изменение номера телефона',
                ],
                [
                    'name' => 'site.seo.edit-password',
                    'ru' => 'Изменение пароля',
                ],
                [
                    'name' => 'site.seo.login',
                    'ru' => 'Вход',
                ],
                [
                    'name' => 'site.seo.registration',
                    'ru' => 'Регистрация',
                ],
                [
                    'name' => 'site.seo.forgot-password',
                    'ru' => 'Восстановления пароля',
                ],
                [
                    'name' => 'site.seo.reset-password',
                    'ru' => 'Сброс пароля',
                ],
                [
                    'name' => 'site.seo.restore-password',
                    'ru' => 'Восстановить пароль',
                ],
                [
                    'name' => 'site.seo.new-password',
                    'ru' => 'Новый пароль придет на указанную Вами почту в течении 5 минут',
                ],
                [
                    'name' => 'site.seo.your-password',
                    'ru' => 'Ваш пароль',
                ],
                [
                    'name' => 'site.seo.your-email',
                    'ru' => 'Ваш email',
                ],
                [
                    'name' => 'site.seo.your-phone',
                    'ru' => 'Ваш номер телефона',
                ],
                [
                    'name' => 'site.seo.your-name',
                    'ru' => 'Ваше имя',
                ],
                [
                    'name' => 'site.seo.invent-password',
                    'ru' => 'Придумайте пароль',
                ],
                [
                    'name' => 'site.seo.repeat-password',
                    'ru' => 'Повторите пароль',
                ],
                [
                    'name' => 'site.seo.restore',
                    'ru' => 'Відновити',
                ],
                [
                    'name' => 'site.enter',
                    'ru' => 'Войти',
                ],
                [
                    'name' => 'site.are-you-client',
                    'ru' => 'Постоянный клиент?',
                ],
                [
                    'name' => 'site.login-by-social-networks',
                    'ru' => 'Вход через Вашу социальную сеть',
                ],
                [
                    'name' => 'site.sing-in',
                    'ru' => 'Вход на сайт',
                ],
                [
                    'name' => 'site.sing-up',
                    'ru' => 'Регистрация на сайте',
                ],
                [
                    'name' => 'site.benefits-after-login',
                    'ru' => 'Вы сможете получить первые преимущества сразу после входа',
                ],
                [
                    'name' => 'site.enter-by',
                    'ru' => 'Вход через',
                ],
                [
                    'name' => 'site.enter-by-social-acc',
                    'ru' => 'Позволяет входить в аккаунт используя учетную запись связанных соцсетей',
                ],
                [
                    'name' => 'site.through-your-social-network',
                    'ru' => 'Через Вашу социальную сеть',
                ],
                [
                    'name' => 'site.code-from-sms',
                    'ru' => 'Код из СМС',
                ],
                [
                    'name' => 'site.send-code',
                    'ru' => 'Отправить код',
                ],
                [
                    'name' => 'site.agreement',
                    'ru' => 'Я согласен на обработку моих данных.',
                ],
                [
                    'name' => 'site.agreement-more',
                    'ru' => 'Подробнее',
                ],
                [
                    'name' => 'site.new-phone',
                    'ru' => 'Новый телефон',
                ],
                [
                    'name' => 'site.current-password',
                    'ru' => 'Текущий пароль',
                ],
                [
                    'name' => 'site.new-password',
                    'ru' => 'Новый пароль',
                ],
                [
                    'name' => 'site.repeat-password',
                    'ru' => 'Повторите новый пароль',
                ],
                [
                    'name' => 'site.save',
                    'ru' => 'Сохранить',
                ],
                [
                    'name' => 'site.cancel',
                    'ru' => 'Отмена',
                ],
                [
                    'name' => 'site.profile-password-title',
                    'ru' => 'Изменение пароля',
                ],
                [
                    'name' => 'site.profile-edit-title',
                    'ru' => 'Редактирование личных данных',
                ],[
                    'name' => 'site.profile-basic-title',
                    'ru' => 'Основные данные',
                ],
                [
                    'name' => 'site.placeholder-name',
                    'ru' => 'Имя',
                ],
                [
                    'name' => 'site.placeholder-lastname',
                    'ru' => 'Фамилия',
                ],
                [
                    'name' => 'site.placeholder-email',
                    'ru' => 'Эл. почта',
                ],
                [
                    'name' => 'site.placeholder-city',
                    'ru' => 'Город',
                ],
                [
                    'name' => 'site.placeholder-birthday',
                    'ru' => 'Дата рождения',
                ],
                [
                    'name' => 'site.placeholder-phone',
                    'ru' => 'Телефон',
                ],
                [
                    'name' => 'site.placeholder-day',
                    'ru' => 'День',
                ],
                [
                    'name' => 'site.placeholder-month',
                    'ru' => 'Месяц',
                ],
                [
                    'name' => 'site.placeholder-year',
                    'ru' => 'Год',
                ],
                [
                    'name' => 'site.placeholder-sex',
                    'ru' => 'Выберите пол',
                ],
                [
                    'name' => 'site.success-message',
                    'ru' => 'Данные успешно сохранены',
                ],
                [
                    'name' => 'site.validation.rules.required',
                    'ru' => 'Вы должны заполнить все обязательные поля',
                ],
                [
                    'name' => 'site.validation.attributes.forgot-email',
                    'ru' => 'e-mail',
                ],
                [
                    'name' => 'site.validation.attributes.login-email',
                    'ru' => 'e-mail',
                ],
                [
                    'name' => 'site.validation.attributes.login-phone',
                    'ru' => 'Телефон',
                ],
                [
                    'name' => 'site.validation.attributes.password',
                    'ru' => 'Пароль',
                ],
                [
                    'name' => 'site.validation.attributes.code',
                    'ru' => 'Код',
                ],
                [
                    'name' => 'site.validation.attributes.city',
                    'ru' => 'Город',
                ],
                [
                    'name' => 'site.validation.attributes.day',
                    'ru' => 'День',
                ],
                [
                    'name' => 'site.validation.attributes.year',
                    'ru' => 'Год',
                ],
                [
                    'name' => 'site.forms.forgot-email',
                    'ru' => 'Ваш e-mail',
                ],
                [
                    'name' => 'site.forms.login',
                    'ru' => 'Вход на сайт',
                ],
                [
                    'name' => 'site.forms.register',
                    'ru' => 'Регистрация',
                ],
                [
                    'name' => 'site.forms.restore',
                    'ru' => 'Восстановить',
                ],
                [
                    'name' => 'site.mobile.cabinet',
                    'ru' => 'Личный кабинет',
                ],
            ]
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
