<?php

namespace App\Modules\SeoLinks\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'seo_links';

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
                    'ru' => 'Теги для ссылок',
                ],
                [
                    'name' => 'general.settings-name',
                    'ru' => 'Теги для ссылок',
                ],
                [
                    'name' => 'general.menu',
                    'ru' => 'Теги для ссылок',
                ],
                [
                    'name' => 'seo.index',
                    'ru' => 'Теги для ссылок',
                ],
                [
                    'name' => 'seo.edit',
                    'ru' => 'Редактирование тегов для ссылок',
                ],
                [
                    'name' => 'seo.create',
                    'ru' => 'Создание тегов для ссылок',
                ],
                [
                    'name' => 'settings.group-name',
                    'ru' => 'Теги для ссылок',
                ],
                [
                    'name' => 'settings.attributes.per-page',
                    'ru' => 'Количество записей на странице в админ панели',
                ],
            ],
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
