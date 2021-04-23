<?php

namespace App\Modules\Subscribe\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'subscribe';

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
                    'ru' => 'Список подписчиков',
                ],
                [
                    'name' => 'general.rule-subscribe',
                    'ru' => 'Подписчик',
                ],
                [
                    'name' => 'general.menu-mailing',
                    'ru' => 'Массовая рассылка',
                ],
                [
                    'name' => 'general.menu-history',
                    'ru' => 'История рассылок',
                ],
                [
                    'name' => 'general.menu-main-block',
                    'ru' => 'Подписки и рассылки',
                ],
                [
                    'name' => 'general.status',
                    'ru' => 'Активность',
                ],
                [
                    'name' => 'general.emails-count',
                    'ru' => 'Отправленных писем',
                ],
                [
                    'name' => 'general.mail-templates.names.subscribe',
                    'ru' => 'Подписка на рассылку',
                ],
                [
                    'name' => 'general.mail-templates.names.unsubscribe',
                    'ru' => 'Отписка от рассылки',
                ],
                [
                    'name' => 'general.mail-templates.attributes.email',
                    'ru' => 'Email подписчика',
                ],
                [
                    'name' => 'general.message-success',
                    'ru' => 'Вы успешно подписались на рассылку',
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
                    'name' => 'general.user-name',
                    'ru' => 'Имя',
                ],
                [
                    'name' => 'general.form-submit-button',
                    'ru' => 'Отправить',
                ],
                [
                    'name' => 'seo.subscribers.index',
                    'ru' => 'Список подписчиков',
                ],
                [
                    'name' => 'seo.subscribers.edit',
                    'ru' => 'Редактирование подписчиков',
                ],
                [
                    'name' => 'seo.subscribers.create',
                    'ru' => 'Добавление нового подписчика',
                ],
                [
                    'name' => 'seo.subscribe.mailing',
                    'ru' => 'Массовая рассылка',
                ],
                [
                    'name' => 'seo.subscribe.history',
                    'ru' => 'История рассылок',
                ],
                [
                    'name' => 'settings.group-name',
                    'ru' => 'Список подписчиков',
                ],
                [
                    'name' => 'settings.attributes.per-page',
                    'ru' => 'Количество подписчиков на странице в админ панели',
                ],
                [
                    'name' => 'settings.attributes.history-per-page',
                    'ru' => 'Количество рассылок на странице истории в админ панели',
                ],
            ],
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
