<?php

namespace App\Core\Modules\SystemPages\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'system_pages';

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
                    'ru' => 'Системные страницы',
                ],
                [
                    'name' => 'seo.index',
                    'ru' => 'Список системных страниц',
                ],
                [
                    'name' => 'seo.edit',
                    'ru' => 'Редактирование системной страницы',
                ],
            ],
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
