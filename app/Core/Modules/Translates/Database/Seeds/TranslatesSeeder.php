<?php

namespace App\Core\Modules\Translates\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'translates';

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
                    'ru' => 'Переводы',
                ],
                [
                    'name' => 'general.settings-name',
                    'ru' => 'Переводы',
                ],
                [
                    'name' => 'general.permission-name',
                    'ru' => 'Переводы',
                ],
                [
                    'name' => 'settings.attributes.per-page',
                    'ru' => 'Количество переводов на странице в админ панели',
                ],
                [
                    'name' => 'seo.index',
                    'ru' => 'Список переводов',
                ],
                [
                    'name' => 'list.keys',
                    'ru' => 'Ключ',
                ],
                [
                    'name' => 'module.general',
                    'ru' => 'Общие',
                ],
                [
                    'name' => 'module.all-translates',
                    'ru' => 'Все',
                ],
            ],
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
