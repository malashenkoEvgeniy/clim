<?php

namespace App\Core\Modules\Dashboard\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'dashboard';

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
                    'name' => 'general.menu.list',
                    'ru' => 'Панель управления',
                ],
                [
                    'name' => 'general.menu.dashboard',
                    'ru' => 'Панель управления',
                ],
            ],
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
