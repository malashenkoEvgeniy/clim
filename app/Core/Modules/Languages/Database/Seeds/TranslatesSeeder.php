<?php

namespace App\Core\Modules\Languages\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'langs';

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
                    'name' => 'general.menu.languages',
                    'ru' => 'Языки',
                ],
                [
                    'name' => 'general.menu.list',
                    'ru' => 'Языки',
                ],
                [
                    'name' => 'general.menu',
                    'ru' => 'Языки',
                ],
                [
                    'name' => 'general.language',
                    'ru' => 'Язык',
                ],
                [
                    'name' => 'messages.warning-title',
                    'ru' => 'Внимание!',
                ],
                [
                    'name' => 'messages.warning-body',
                    'ru' => 'Изменение языка по-умолчанию приведет к изменению ссылок и потере позиций по существующим!',
                ],
            ],
            Translate::PLACE_GENERAL => [
                [
                    'name' => 'admin.buttons.create',
                    'ru' => 'Создать',
                ],
                [
                    'name' => 'admin.buttons.list',
                    'ru' => 'Список',
                ],
                [
                    'name' => 'admin.buttons.deleted',
                    'ru' => 'Удаленные',
                ],
                [
                    'name' => 'admin.buttons.translit',
                    'ru' => 'Транслитерировать',
                ],
                [
                    'name' => 'admin.messages.data-created',
                    'ru' => 'Новая запись успешно создана',
                ],
                [
                    'name' => 'admin.messages.data-updated',
                    'ru' => 'Данные успешно обновлены',
                ],
                [
                    'name' => 'admin.messages.cache-cleared',
                    'ru' => 'Кэш успешно сброшен. Для сброса кэша браузера необходимо нажать комбинацию клавиш Ctrl+F5 на нужной странице сайта',
                ],
                [
                    'name' => 'admin.messages.data-destroyed',
                    'ru' => 'Данные успешно удалены',
                ],
                [
                    'name' => 'admin.messages.data-restored',
                    'ru' => 'Данные успешно восстановлены',
                ],
                [
                    'name' => 'admin.messages.delete',
                    'ru' => 'Удаление записи',
                ],
                [
                    'name' => 'admin.messages.restore',
                    'ru' => 'Восстановление записи',
                ],
                [
                    'name' => 'admin.messages.image-deleted',
                    'ru' => 'Изображение успешно удалено',
                ],
                [
                    'name' => 'admin.messages.fail',
                    'ru' => 'Операция провалилась!',
                ],
                [
                    'name' => 'admin.messages.zero-results-title',
                    'ru' => 'Нет результатов!',
                ],
                [
                    'name' => 'admin.messages.zero-results-description',
                    'help' => [
                        ':url' => 'variables.create-url'
                    ],
                    'ru' => 'Еще нет ни одной записи в этом разделе. Вы можете создать первую перейдя по <a href=":url">ссылке</a>',
                ],
                [
                    'name' => 'admin.menu.default',
                    'ru' => 'Управление',
                ],
                [
                    'name' => 'admin.tabs.general-information',
                    'ru' => 'Основная информация',
                ],
                [
                    'name' => 'admin.tabs.seo',
                    'ru' => 'Мета данные',
                ],
                [
                    'name' => 'admin.tabs.images',
                    'ru' => 'Изображения',
                ],
                [
                    'name' => 'auth.failed',
                    'ru' => 'Введенные данные не подходят',
                ],
                [
                    'name' => 'auth.failed',
                    'ru' => 'Введенные данные не подходят',
                ],
                [
                    'name' => 'auth.succeed',
                    'ru' => 'Вы успешно авторизованы',
                ],
                [
                    'name' => 'auth.throttle',
                    'ru' => 'Слишком много попыток. Пожалуйста, попробуйте через :seconds секунд.',
                ],
                [
                    'name' => 'auth.sign-in-please',
                    'ru' => 'Авторизуйтесь для доступа в панель',
                ],
                [
                    'name' => 'auth.logout',
                    'ru' => 'Выход',
                ],
                [
                    'name' => 'auth.remember-me',
                    'ru' => 'Запомнить меня',
                ],
                [
                    'name' => 'auth.sign-in',
                    'ru' => 'Войти',
                ],
                [
                    'name' => 'buttons.save',
                    'ru' => 'Сохранить',
                ],
                [
                    'name' => 'buttons.save-and-close',
                    'ru' => 'Сохранить и закрыть',
                ],
                [
                    'name' => 'buttons.save-and-add',
                    'ru' => 'Сохранить и добавить еще',
                ],
                [
                    'name' => 'buttons.close',
                    'ru' => 'Закрыть',
                ],
                [
                    'name' => 'buttons.detail',
                    'ru' => 'Подробнее',
                ],
                [
                    'name' => 'cookie.message',
                    'ru' => 'Этот сайт использует файлы cookies для более комфортной работы пользователя. Продолжая просмотр страниц сайта, вы соглашаетесь с использованием файлов cookies. Если вам нужна дополнительная информация или вы не хотите соглашаться с использованием cookies, пожалуйста, посетите страницу "Про cookies"',
                ],
                [
                    'name' => 'cookie.button',
                    'ru' => 'Принимаю',
                ],
                [
                    'name' => 'emails.soc_title',
                    'ru' => 'Мы в соц. сетях',
                ],
                [
                    'name' => 'emails.total',
                    'ru' => 'Итого',
                ],
                [
                    'name' => 'global.more',
                    'ru' => 'Подробнее',
                ],
                [
                    'name' => 'global.change',
                    'ru' => 'Изменить',
                ],
                [
                    'name' => 'global.close',
                    'ru' => 'Закрыть',
                ],
                [
                    'name' => 'global.version',
                    'ru' => 'Версия',
                ],
                [
                    'name' => 'global.copyright',
                    'ru' => 'Все права защищены',
                ],
                [
                    'name' => 'global.sitemap',
                    'ru' => 'Карта сайта',
                ],
                [
                    'name' => 'global.yes',
                    'ru' => 'Да',
                ],
                [
                    'name' => 'global.no',
                    'ru' => 'Нет',
                ],
                [
                    'name' => 'global.url',
                    'ru' => 'Ссылка',
                ],
                [
                    'name' => 'global.back',
                    'ru' => 'Назад',
                ],
                [
                    'name' => 'global.all',
                    'ru' => 'Все',
                ],
                [
                    'name' => 'global.unprocessed',
                    'ru' => 'Необработаные',
                ],
                [
                    'name' => 'global.processed',
                    'ru' => 'Обработаные',
                ],
                [
                    'name' => 'global.unpublished',
                    'ru' => 'Неопубликованы',
                ],
                [
                    'name' => 'global.published',
                    'ru' => 'Опубликованы',
                ],
                [
                    'name' => 'global.print',
                    'ru' => 'Распечатать',
                ],
                [
                    'name' => 'global.attention',
                    'ru' => 'Внимание',
                ],
                [
                    'name' => 'global.locotrade_text',
                    'ru' => 'Создано на Locotrade',
                ],
                [
                    'name' => 'global.error-code',
                    'help' => [
                        ':code' => 'variables.error-code'
                    ],
                    'ru' => 'Ошибка :code',
                ],
                [
                    'name' => 'global.seo-page',
                    'ru' => 'страница №:page',
                ],
                [
                    'name' => 'messages.image-max-size',
                    'help' => [
                        ':code' => 'variables.image-max-size'
                    ],
                    'ru' => 'Изображение не должно превышать размер :size Мб',
                ],
                [
                    'name' => 'messages.page-not-found',
                    'ru' => 'Locotrade - Ошибка 404. Страница не найдена',
                ],
                [
                    'name' => 'messages.page-does-not-exist',
                    'ru' => 'Страница, которую вы ищете, не существует или больше не доступна',
                ],
                [
                    'name' => 'messages.go-to-the-home-page',
                    'help' => [
                        ':url' => 'variables.url-on-main-page'
                    ],
                    'ru' => 'Перейдите на <a href=":url">главную страницу</a> или воспользуйтесь поиском.',
                ],
                [
                    'name' => 'messages.no-content',
                    'ru' => 'К сожалению, в этом разделе ничего нет',
                ],
                [
                    'name' => 'messages.thank',
                    'ru' => 'Спасибо',
                ],
                [
                    'name' => 'messages.ok',
                    'ru' => 'OK',
                ],
                [
                    'name' => 'noscript-msg.close_notification',
                    'ru' => 'Закрыть уведомление',
                ],
                [
                    'name' => 'noscript-msg.disabled_javascript',
                    'ru' => 'В Вашем браузере отключен JavaScript!',
                ],
                [
                    'name' => 'noscript-msg.required_javascript',
                    'ru' => 'Для корректной работы с сайтом необходима поддержка Javascript.',
                ],
                [
                    'name' => 'noscript-msg.enable_javascript',
                    'ru' => 'Мы рекомендуем Вам включить использование JavaScript в настройках вашего браузера.',
                ],
                [
                    'name' => 'passwords.password',
                    'ru' => 'Пароль должен быть не короче 6 символов и совпадать с полем подтверждения.',
                ],
                [
                    'name' => 'passwords.reset',
                    'ru' => 'Ваш пароль сброшен!',
                ],
                [
                    'name' => 'passwords.sent',
                    'ru' => 'Мы отправили вам ссылку для подтверждения пароля на ваш email адрес!',
                ],
                [
                    'name' => 'passwords.token',
                    'ru' => 'Этот токен для сброса пароля некорректен.',
                ],
                [
                    'name' => 'passwords.user',
                    'ru' => 'Мы не можем найти пользователя с указыннм email адресом.',
                ],
                [
                    'name' => 'pagination.previous',
                    'ru' => '&laquo; Пред.',
                ],
                [
                    'name' => 'pagination.next',
                    'ru' => 'След. &raquo',
                ],
                [
                    'name' => 'pagination.next-rows',
                    'help' => [
                        ':count' => 'variables.pagination-count'
                    ],
                    'ru' => 'Следующие :count',
                ],
                [
                    'name' => 'pagination.prev-rows',
                    'help' => [
                        ':count' => 'variables.pagination-count'
                    ],
                    'ru' => 'Предыдущие :count',
                ],
                [
                    'name' => 'months.full.jan',
                    'ru' => 'Январь',
                ],
                [
                    'name' => 'months.full.feb',
                    'ru' => 'Февраль',
                ],
                [
                    'name' => 'months.full.mar',
                    'ru' => 'Март',
                ],
                [
                    'name' => 'months.full.apr',
                    'ru' => 'Апрель',
                ],
                [
                    'name' => 'months.full.may',
                    'ru' => 'Май',
                ],
                [
                    'name' => 'months.full.jun',
                    'ru' => 'Июнь',
                ],
                [
                    'name' => 'months.full.jul',
                    'ru' => 'Июль',
                ],
                [
                    'name' => 'months.full.aug',
                    'ru' => 'Август',
                ],
                [
                    'name' => 'months.full.sep',
                    'ru' => 'Сентябрь',
                ],
                [
                    'name' => 'months.full.oct',
                    'ru' => 'Октябрь',
                ],
                [
                    'name' => 'months.full.nov',
                    'ru' => 'Ноябрь',
                ],
                [
                    'name' => 'months.full.dec',
                    'ru' => 'Декабрь',
                ],

                [
                    'name' => 'months.short.jan',
                    'ru' => 'Янв',
                ],
                [
                    'name' => 'months.short.feb',
                    'ru' => 'Фев',
                ],
                [
                    'name' => 'months.short.mar',
                    'ru' => 'Мар',
                ],
                [
                    'name' => 'months.short.apr',
                    'ru' => 'Апр',
                ],
                [
                    'name' => 'months.short.may',
                    'ru' => 'Май',
                ],
                [
                    'name' => 'months.short.jun',
                    'ru' => 'Июн',
                ],
                [
                    'name' => 'months.short.jul',
                    'ru' => 'Июл',
                ],
                [
                    'name' => 'months.short.aug',
                    'ru' => 'Авг',
                ],
                [
                    'name' => 'months.short.sep',
                    'ru' => 'Сен',
                ],
                [
                    'name' => 'months.short.oct',
                    'ru' => 'Окт',
                ],
                [
                    'name' => 'months.short.nov',
                    'ru' => 'Ноя',
                ],
                [
                    'name' => 'months.short.dec',
                    'ru' => 'Дек',
                ],
            ],
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
