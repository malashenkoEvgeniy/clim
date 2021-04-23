<?php

namespace App\Modules\Reviews\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'reviews';

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
                    'ru' => 'Отзывы к сайту',
                ],
                [
                    'name' => 'messages.background-size',
                    'ru' => 'Рекомендуемый размер для фонового изображения 1900х500. Изображение сохранится как есть без обработки!',
                ],
                [
                    'name' => 'general.stat-widget-title',
                    'ru' => 'Отзывы',
                ],
                [
                    'name' => 'general.no-user',
                    'ru' => 'Пользователь не выбран',
                ],
                [
                    'name' => 'general.message-success',
                    'ru' => 'Форма успешно отправлена',
                ],
                [
                    'name' => 'general.message-false',
                    'ru' => 'Не удалось отправить форму, перезагрузите страницу и повторите попытку',
                ],
                [
                    'name' => 'general.publishing_date',
                    'ru' => 'Дата публикации',
                ],
                [
                    'name' => 'seo.index',
                    'ru' => 'Список отзывов',
                ],
                [
                    'name' => 'seo.edit',
                    'ru' => 'Редактирование отзыва',
                ],
                [
                    'name' => 'seo.create',
                    'ru' => 'Добавление нового отзыва',
                ],
                [
                    'name' => 'settings.group-name',
                    'ru' => 'Отзывы',
                ],
                [
                    'name' => 'settings.attributes.per-page',
                    'ru' => 'Количество отзывов на странице в админ панели',
                ],
                [
                    'name' => 'settings.attributes.per-page-client-side',
                    'ru' => 'Количество отзывов на странице на сайте',
                ],
                [
                    'name' => 'settings.attributes.count-in-widget',
                    'ru' => 'Количество отзывов в виджете на главной странице',
                ],
                [
                    'name' => 'settings.attributes.background',
                    'ru' => 'Фоновое изображение в виджете на главной странице',
                ],
                [
                    'name' => 'general.mail-templates.names.reviews-admin',
                    'ru' => 'Новый отзыв о сайте (Администратору)',
                ],
                [
                    'name' => 'general.mail-templates.attributes.name',
                    'ru' => 'Имя клиента',
                ],
                [
                    'name' => 'general.mail-templates.attributes.email',
                    'ru' => 'E-mail клиента',
                ],
                [
                    'name' => 'general.mail-templates.attributes.comment',
                    'ru' => 'Отзыв клиента',
                ],
                [
                    'name' => 'general.mail-templates.attributes.admin_href',
                    'ru' => 'Ссылка на админ панель',
                ],
            ],
            Translate::PLACE_SITE => [
                [
                    'name' => 'site.all-reviews',
                    'ru' => 'Все отзывы',
                ],
                [
                    'name' => 'site.reviews',
                    'ru' => 'Отзывы',
                ],
                [
                    'name' => 'site.widget-title',
                    'ru' => '{0,100}Наши отзывы|[101,200]Более 100 отзывов|[201,300]Более 200 отзывов|[301,*]Наши многочисленные отзывы',
                ],
                [
                    'name' => 'site.required',
                    'ru' => 'Вы должны заполнить все обязательные поля',
                ],
                [
                    'name' => 'site.send-review',
                    'ru' => 'Оставить отзыв',
                ],
                [
                    'name' => 'site.no-content',
                    'ru' => 'Отзывов пока нет. Вы можете быть первым',
                ],
                [
                    'name' => 'message.title',
                    'ru' => 'Спасибо за Ваш отзыв!',
                ],
                [
                    'name' => 'message.content',
                    'ru' => 'Он будет опубликован сразу же после одобрения администратором',
                ],
            ]
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
