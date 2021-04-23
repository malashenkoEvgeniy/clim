<?php

namespace App\Core\Modules\Security\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'security';

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
                    'ru' => 'Безопасность',
                ],
                [
                    'name' => 'general.permission-name',
                    'ru' => 'Безопасность',
                ],
                [
                    'name' => 'basic-auth.settings-name',
                    'ru' => 'Безопасность',
                ],
                [
                    'name' => 'basic-auth.attributes.auth',
                    'ru' => 'Запаролить сайт?',
                ],
                [
                    'name' => 'basic-auth.attributes.username',
                    'ru' => 'Логин',
                ],
                [
                    'name' => 'basic-auth.attributes.password',
                    'ru' => 'Пароль',
                ],
            ],
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
