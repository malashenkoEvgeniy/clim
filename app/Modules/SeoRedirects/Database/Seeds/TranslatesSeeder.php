<?php

namespace App\Modules\SeoRedirects\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'seo_redirects';

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
                    'ru' => 'Перенаправления сайта',
                ],
                [
                    'name' => 'general.settings-name',
                    'ru' => 'Перенаправления сайта',
                ],
                [
                    'name' => 'general.menu',
                    'ru' => 'Перенаправления сайта',
                ],
                [
                    'name' => 'general.link_from',
                    'ru' => 'Ссылка с',
                ],
                [
                    'name' => 'general.link_to',
                    'ru' => 'Ссылка на',
                ],
                [
                    'name' => 'general.type',
                    'ru' => 'Тип',
                ],
                [
                    'name' => 'seo.index',
                    'ru' => 'Перенаправления сайта',
                ],
                [
                    'name' => 'seo.edit',
                    'ru' => 'Редактирование перенаправлений',
                ],
                [
                    'name' => 'seo.create',
                    'ru' => 'Создание перенаправлений',
                ],
                [
                    'name' => 'settings.group-name',
                    'ru' => 'Перенаправления сайта',
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
