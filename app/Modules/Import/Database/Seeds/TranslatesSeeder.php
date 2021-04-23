<?php

namespace App\Modules\Import\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'import';

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
                    'ru' => 'Импорт',
                ],
                [
                    'name' => 'admin.menu',
                    'ru' => 'Импорт',
                ],
                [
                    'name' => 'admin.permission-name',
                    'ru' => 'Каталог',
                ],
                [
                    'name' => 'validation.extension',
                    'ru' => 'Формат файла для импорта должен быть: .xls, .xlsx',
                ],
                [
                    'name' => 'validation.import',
                    'ru' => 'Файл не является корректной выгрузкой с prom.ua',
                ],
            ],
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
