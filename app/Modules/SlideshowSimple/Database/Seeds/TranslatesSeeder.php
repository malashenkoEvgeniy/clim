<?php

namespace App\Modules\SlideshowSimple\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'slideshow_simple';

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
                    'name' => 'general.menu-block',
                    'ru' => 'Медиа',
                ],
                [
                    'name' => 'general.menu',
                    'ru' => 'Слайдер',
                ],
                [
                    'name' => 'general.slug',
                    'ru' => 'Ссылка',
                ],
                [
                    'name' => 'general.check',
                    'ru' => 'Отметить',
                ],
                [
                    'name' => 'general.view',
                    'ru' => 'Просмотр',
                ],
                [
                    'name' => 'general.edit',
                    'ru' => 'Редактировать',
                ],
                [
                    'name' => 'general.no-photo',
                    'ru' => 'Нет загруженных фото!',
                ],
                [
                    'name' => 'general.images-uploading',
                    'ru' => 'Загрузка изображения',
                ],
                [
                    'name' => 'general.add-image',
                    'ru' => 'Добавить изображение',
                ],
                [
                    'name' => 'general.delete',
                    'ru' => 'Удалить',
                ],
                [
                    'name' => 'general.attributes.row_1',
                    'ru' => 'Строка 1',
                ],
                [
                    'name' => 'general.attributes.row_2',
                    'ru' => 'Строка 2',
                ],
                [
                    'name' => 'general.attributes.row_3',
                    'ru' => 'Строка 3',
                ],
                [
                    'name' => 'general.standard',
                    'ru' => 'Стандартный',
                ],
                [
                    'name' => 'general.fade',
                    'ru' => 'Затухание',
                ],

                [
                    'name' => 'seo.index',
                    'ru' => 'Список слайдов',
                ],
                [
                    'name' => 'seo.edit',
                    'ru' => 'Редактирование слайда',
                ],
                [
                    'name' => 'seo.create',
                    'ru' => 'Создание слайда',
                ],
                [
                    'name' => 'seo.edit-image',
                    'ru' => 'Редактирование изображения',
                ],
                [
                    'name' => 'settings.group-name',
                    'ru' => 'Слайдер',
                ],
                [
                    'name' => 'settings.attributes.per-page',
                    'ru' => 'Количество элементов на странице в админ панели',
                ],
                [
                    'name' => 'settings.attributes.autoplay',
                    'ru' => 'Автоматически запускать слайдер',
                ],
                [
                    'name' => 'settings.attributes.timing',
                    'ru' => 'Время смены слайда (мс)',
                ],
                [
                    'name' => 'settings.attributes.effect',
                    'ru' => 'Эффект слайдера',
                ],

            ],
            Translate::PLACE_SITE => [
                [
                    'name' => 'site.more',
                    'ru' => 'Подробнее',
                ],
            ]
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
