<?php

namespace App\Modules\Pages\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'pages';

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
                    'ru' => 'Контент',
                ],
                [
                    'name' => 'general.menu',
                    'ru' => 'Текстовые страницы',
                ],
                [
                    'name' => 'general.menu-type-field',
                    'ru' => 'Участвует в боковом меню на текстовых страницах',
                ],
                [
                    'name' => 'general.menu-types-name.about',
                    'ru' => 'О компании',
                ],
                [
                    'name' => 'general.menu-types-name.pages-list',
                    'ru' => 'Список текстовых страниц',
                ],
                [
                    'name' => 'seo.index',
                    'ru' => 'Список текстовых страниц',
                ],
                [
                    'name' => 'seo.edit',
                    'ru' => 'Редактирование текстовой страницы',
                ],
                [
                    'name' => 'seo.create',
                    'ru' => 'Добавление текстовой страницы',
                ],
            ],
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
