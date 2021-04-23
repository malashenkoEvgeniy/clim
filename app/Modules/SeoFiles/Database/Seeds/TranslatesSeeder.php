<?php

namespace App\Modules\SeoFiles\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'seo_files';

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
                    'name' => 'general.permission-name',
                    'ru' => 'SEO файлы',
                ],
                [
                    'name' => 'general.settings-name',
                    'ru' => 'SEO файлы',
                ],
                [
                    'name' => 'general.menu',
                    'ru' => 'SEO файлы',
                ],
                [
                    'name' => 'general.content',
                    'ru' => 'Содержание файла',
                ],
                [
                    'name' => 'general.not-exist',
                    'ru' => 'Такого файла не существует!',
                ],
                [
                    'name' => 'general.can-not-delete-file',
                    'ru' => 'Невозможно удалить файл!',
                ],
                [
                    'name' => 'general.can-not-update-file',
                    'ru' => 'Невозможно обновить содержимое файла!',
                ],
                [
                    'name' => 'general.can-not-create-file',
                    'ru' => 'Невозможно создать файл!',
                ],
                [
                    'name' => 'general.can-not-create-file-in-db',
                    'ru' => 'Невозможно создать файл в базе данных!',
                ],
                [
                    'name' => 'general.mime',
                    'ru' => 'Mime тип',
                ],
                [
                    'name' => 'general.size',
                    'ru' => 'Размер',
                ],
                [
                    'name' => 'general.byte',
                    'ru' => 'байт',
                ],
                [
                    'name' => 'seo.index',
                    'ru' => 'Сео файлы',
                ],
                [
                    'name' => 'seo.edit',
                    'ru' => 'Редактирование файлов',
                ],
                [
                    'name' => 'seo.create',
                    'ru' => 'Создание нового файла',
                ],
            ],
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
