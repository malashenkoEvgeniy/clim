<?php

namespace App\Core\Modules\Settings\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'settings';

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
                    'ru' => 'Настройки',
                ],
                [
                    'name' => 'general.menu-system',
                    'ru' => 'Системные',
                ],
                [
                    'name' => 'general.search',
                    'ru' => 'Поиск',
                ],
                [
                    'name' => 'general.empty-table',
                    'ru' => 'Таблица пуста',
                ],
                [
                    'name' => 'general.processing',
                    'ru' => 'Ищем...',
                ],
                [
                    'name' => 'general.zero-records',
                    'ru' => 'Ничего не найдено',
                ],
                [
                    'name' => 'general.slogan',
                    'ru' => 'Слоган сайта',
                ],
                [
                    'name' => 'general.slogan-info',
                    'ru' => 'Располагается справа от логотипа',
                ],
                [
                    'name' => 'general.colors.settings',
                    'ru' => 'Цветовая схема сайта',
                ],
                [
                    'name' => 'general.colors.panel',
                    'ru' => 'Панель цветов',
                ],
                [
                    'name' => 'general.colors.panel',
                    'ru' => 'Панель цветов',
                ],
                [
                    'name' => 'general.colors.main',
                    'ru' => 'Основной цвет',
                ],
                [
                    'name' => 'general.colors.main-lighten',
                    'ru' => 'Основной цвет при наведении',
                ],
                [
                    'name' => 'general.colors.main-darken',
                    'ru' => 'Основной цвет при нажатиии',
                ],
                [
                    'name' => 'general.colors.secondary',
                    'ru' => 'Второстепенный цвет',
                ],
                [
                    'name' => 'general.colors.secondary-lighten',
                    'ru' => 'Второстепенный цвет при наведении',
                ],
                [
                    'name' => 'general.colors.secondary-darken',
                    'ru' => 'Второстепенный цвет при нажатии',
                ],
                [
                    'name' => 'seo.h1',
                    'ru' => 'Настройки',
                ],
                [
                    'name' => 'seo.breadcrumb',
                    'ru' => 'Настройки',
                ],
                [
                    'name' => 'sms.settings-name',
                    'ru' => 'SMS',
                ],
                [
                    'name' => 'sms.drivers.turbo',
                    'ru' => 'TurboSMS',
                ],
                [
                    'name' => 'sms.drivers.eSputnik',
                    'ru' => 'eSputnik',
                ],
                [
                    'name' => 'sms.drivers.smsRu',
                    'ru' => 'SmsRu',
                ],
                [
                    'name' => 'sms.drivers.sendpulse',
                    'ru' => 'SendPulse',
                ],

                [
                    'name' => 'sms.attributes.driver',
                    'ru' => 'Сервис SMS рассылки',
                ],
                [
                    'name' => 'sms.attributes.turbo_login',
                    'ru' => 'Логин',
                ],
                [
                    'name' => 'sms.attributes.turbo_password',
                    'ru' => 'Пароль',
                ],
                [
                    'name' => 'sms.attributes.turbo_secret',
                    'ru' => 'Секретный ключ',
                ],
                [
                    'name' => 'sms.attributes.eSputnik_login',
                    'ru' => 'Логин',
                ],
                [
                    'name' => 'sms.attributes.eSputnik_password',
                    'ru' => 'Пароль',
                ],
                [
                    'name' => 'sms.attributes.eSputnik_secret',
                    'ru' => 'Секретный ключ',
                ],
                [
                    'name' => 'sms.attributes.smsRu_login',
                    'ru' => 'Логин',
                ],
                [
                    'name' => 'sms.attributes.smsRu_password',
                    'ru' => 'Пароль',
                ],
                [
                    'name' => 'sms.attributes.sendpulse_user_id',
                    'ru' => 'ID',
                ],
                [
                    'name' => 'sms.attributes.sendpulse_secret',
                    'ru' => 'Секретный ключ',
                ],
                [
                    'name' => 'sms.attributes.sendpulse_sender',
                    'ru' => 'Имя отправителя SMS (до 11 символов латиницей, можно с цифрами)',
                ],
                [
                    'name' => 'sms.attributes.sendpulse_transliterate',
                    'ru' => 'Использовать транслитерацию текста сообщения?',
                ],
                [
                    'name' => 'nova-poshta.settings-name',
                    'ru' => 'Настройки для Новой Почты',
                ],
                [
                    'name' => 'nova-poshta.key',
                    'ru' => 'Ключ для API',
                ],
                [
                    'name' => 'nova-poshta.sender-last-name',
                    'ru' => 'Фамилия отправителя',
                ],
                [
                    'name' => 'nova-poshta.sender-first-name',
                    'ru' => 'Имя отправителя',
                ],
                [
                    'name' => 'nova-poshta.sender-middle-name',
                    'ru' => 'Отчество отправителя',
                ],
                [
                    'name' => 'nova-poshta.sender-phone',
                    'ru' => 'Телефон отправителя',
                ],
                [
                    'name' => 'nova-poshta.sender-city',
                    'ru' => 'Город отправителя',
                ],
                [
                    'name' => 'nova-poshta.sender-warehouse',
                    'ru' => 'Отделение отправителя',
                ],
                [
                    'name' => 'liqpay.public-key',
                    'ru' => 'Публичный ключ',
                ],
                [
                    'name' => 'liqpay.private-key',
                    'ru' => 'Приватный ключ',
                ],
                [
                    'name' => 'liqpay.settings-name',
                    'ru' => 'Настройки LiqPay',
                ],
                [
                    'name' => 'liqpay.order-pay',
                    'ru' => 'Оплата заказа №',
                ],
                [
                    'name' => 'liqpay.site',
                    'ru' => 'на сайте',
                ],
                [
                    'name' => 'liqpay.test',
                    'ru' => 'Тестовый режим',
                ],
                [
                    'name' => 'logo.settings-name',
                    'ru' => 'Логотип',
                ],
                [
                    'name' => 'logo.name',
                    'ru' => 'Текст на место изображения',
                ],
                [
                    'name' => 'logo.use-image',
                    'ru' => 'Текст на место изображения',
                ],
                [
                    'name' => 'logo.image',
                    'ru' => 'Изображение',
                ],
                [
                    'name' => 'logo.delete-log',
                    'ru' => 'Удалить',
                ],
                [
                    'name' => 'logo.required_if',
                    'ru' => 'Это поле обязательно для заполнения при выбранном варианте отображения',
                ],
                [
                    'name' => 'logo.main-logo',
                    'ru' => 'Основной логотип',
                ],
                [
                    'name' => 'logo.mobile-logo',
                    'ru' => 'Логотип для мобильной версии сайта',
                ],
                [
                    'name' => 'watermark.settings-name',
                    'ru' => 'Watermark',
                ],
                [
                    'name' => 'watermark.positions',
                    'ru' => 'Расположение',
                ],
                [
                    'name' => 'watermark.width',
                    'ru' => 'Размер в %',
                ],
                [
                    'name' => 'watermark.overlay',
                    'ru' => 'Накладывать водяной знак на изображения?',
                ],
                [
                    'name' => 'watermark.opacity',
                    'ru' => 'Прозрачность в %',
                ],
                [
                    'name' => 'watermark.image',
                    'ru' => 'Изображение',
                ],
                [
                    'name' => 'watermark.position.top-left',
                    'ru' => 'Вверху слева',
                ],
                [
                    'name' => 'watermark.position.top',
                    'ru' => 'Вверху',
                ],
                [
                    'name' => 'watermark.position.top-right',
                    'ru' => 'Вверху справа',
                ],
                [
                    'name' => 'watermark.position.left',
                    'ru' => 'Слева',
                ],
                [
                    'name' => 'watermark.position.center',
                    'ru' => 'Посредине',
                ],
                [
                    'name' => 'watermark.position.right',
                    'ru' => 'Справа',
                ],
                [
                    'name' => 'watermark.position.bottom-left',
                    'ru' => 'Внизу слева',
                ],
                [
                    'name' => 'watermark.position.bottom',
                    'ru' => 'Внизу',
                ],
                [
                    'name' => 'watermark.position.bottom-right',
                    'ru' => 'Внизу справа',
                ],
            ],
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
