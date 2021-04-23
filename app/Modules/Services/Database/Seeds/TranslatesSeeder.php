<?php

namespace App\Modules\Services\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'services';

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
                    'ru' => 'Услуги',
                ],
                [
                    'name' => 'general.settings-name',
                    'ru' => 'Услуги',
                ],
                [
                    'name' => 'general.menu-block',
                    'ru' => 'Услуги',
                ],
                [
                    'name' => 'general.menu',
                    'ru' => 'Список услуг',
                ],
                [
                    'name' => 'general.menu-rubrics',
                    'ru' => 'Список категорий услуг',
                ],
                [
                    'name' => 'seo.index-rubrics',
                    'ru' => 'Список категорий услуг',
                ],
                [
                    'name' => 'seo.create-rubrics',
                    'ru' => 'Создать категорию',
                ],
                [
                    'name' => 'admin.services_rubrics.create',
                    'ru' => 'Создать категорию услуг',
                ],
                [
                    'name' => 'seo.edit-rubric',
                    'ru' => 'Редактировать категорию',
                ],
                [
                    'name' => 'seo.index',
                    'ru' => 'Список услуг',
                ],
                [
                    'name' => 'seo.edit',
                    'ru' => 'Редактирование услуги',
                ],
                [
                    'name' => 'seo.create',
                    'ru' => 'Создание услуги',
                ],
                [
                    'name' => 'site.last-rubrics',
                    'ru' => 'Услуги',
                ],
                [
                    'name' => 'site.all-services-rubrics',
                    'ru' => 'Все услуги',
                ],

            ],
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
