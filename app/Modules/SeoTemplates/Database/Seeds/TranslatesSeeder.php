<?php

namespace App\Modules\SeoTemplates\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'seo_templates';

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
                    'ru' => 'СЕО шаблоны',
                ],
                [
                    'name' => 'general.settings-name',
                    'ru' => 'СЕО шаблоны',
                ],
                [
                    'name' => 'general.menu',
                    'ru' => 'СЕО шаблоны',
                ],
                [
                    'name' => 'general.main-menu-block',
                    'ru' => 'SEO',
                ],
                [
                    'name' => 'general.title-block',
                    'ru' => 'Переменные',
                ],
                [
                    'name' => 'messages.warning-title',
                    'ru' => 'Внимание!',
                ],
                [
                    'name' => 'messages.warning-body',
                    'ru' => 'Любой параметр можно обрезать с помощью записи <b>{{parameter-name:number}}</b>',
                ],
                [
                    'name' => 'seo.index',
                    'ru' => 'СЕО шаблоны',
                ],
                [
                    'name' => 'seo.edit',
                    'ru' => 'Редактирование шаблона',
                ],
            ],
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
