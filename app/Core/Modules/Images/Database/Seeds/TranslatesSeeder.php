<?php

namespace App\Core\Modules\Images\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'images';

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
                    'ru' => 'Изображения',
                ],
                [
                    'name' => 'general.crop-name',
                    'ru' => 'Crop',
                ],
                [
                    'name' => 'general.images-name',
                    'ru' => 'Изменение картинок',
                ],
                [
                    'name' => 'general.images-uploading',
                    'ru' => 'Загрузка изображений',
                ],
                [
                    'name' => 'general.add-image',
                    'ru' => 'Добавление изображений',
                ],
                [
                    'name' => 'general.uploaded-images',
                    'ru' => 'Загруженые изображения',
                ],
                [
                    'name' => 'general.upload-image',
                    'ru' => 'Загрузить все',
                ],
                [
                    'name' => 'general.cancel-all',
                    'ru' => 'Отменить все',
                ],
                [
                    'name' => 'general.check-all',
                    'ru' => 'Отметить все',
                ],
                [
                    'name' => 'general.uncheck-all',
                    'ru' => 'Снять все',
                ],
                [
                    'name' => 'general.delete-checked',
                    'ru' => 'Удалить выделенные',
                ],
                [
                    'name' => 'general.images',
                    'ru' => 'Нет загруженных фото!',
                ],
                [
                    'name' => 'general.delete',
                    'ru' => 'Удалить',
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
                    'name' => 'general.crop',
                    'ru' => 'Обрезать',
                ],
                [
                    'name' => 'general.no-photo',
                    'ru' => 'Нет загруженных фото!',
                ],
                [
                    'name' => 'seo.h1',
                    'ru' => 'Обрезание изображения',
                ],
                [
                    'name' => 'seo.breadcrumb',
                    'ru' => 'Обрезание изображения',
                ],
            ],
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
