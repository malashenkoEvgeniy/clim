<?php

namespace App\Modules\Home\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'home';

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
                    'ru' => 'Базовые настройки',
                ],
                [
                    'name' => 'basic.settings-name',
                    'ru' => 'Базовые настройки',
                ],
                [
                    'name' => 'basic.attributes.site-email',
                    'ru' => 'E-Mail  сайта (в футере)',
                ],
                [
                    'name' => 'basic.attributes.hot-line',
                    'ru' => 'Горячая линия',
                ],
                [
                    'name' => 'basic.attributes.phone-number',
                    'ru' => 'Номер телефона',
                ],
                [
                    'name' => 'basic.attributes.schedule',
                    'ru' => 'График работы',
                ],
                [
                    'name' => 'basic.attributes.company',
                    'ru' => 'Название компании в подвале сайта',
                ],
                [
                    'name' => 'basic.attributes.copyright',
                    'ru' => 'Copyright',
                ],
                [
                    'name' => 'basic.attributes.agreement_link',
                    'ru' => 'Ссылка на страницу "Условия обработки данных"',
                ],
                [
                    'name' => 'basic.attributes.cache_life_time',
                    'ru' => 'Время хранения кэшированных изображений (в секундах)',
                ],
            ],
            Translate::PLACE_SITE => [
                [
                    'name' => 'general.catalog',
                    'ru' => 'Каталог',
                ],
            ],
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
