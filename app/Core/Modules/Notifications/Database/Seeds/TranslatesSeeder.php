<?php

namespace App\Core\Modules\Notifications\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'notifications';

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
                    'ru' => 'Оповещения',
                ],
                [
                    'name' => 'general.permission-name',
                    'ru' => 'Оповещения',
                ],
                [
                    'name' => 'general.settings-name',
                    'ru' => 'Оповещения',
                ],
                [
                    'name' => 'general.see-all',
                    'ru' => 'Смотреть все',
                ],
                [
                    'name' => 'general.new-events',
                    'help' => [
                        ':total' => 'notifications::variables.count-notification'
                    ],
                    'ru' => '{1}У вас <span class="count-notification">:total</span> новое уведомление | У вас <span class="count-notification">:total</span> новых уведомлений',
                ],
                [
                    'name' => 'seo.index',
                    'ru' => 'Оповещения',
                ],
                [
                    'name' => 'settings.attributes.per-page-in-widget',
                    'ru' => 'Количество событий в окне оповещений в админ панели',
                ],
                [
                    'name' => 'settings.attributes.per-page',
                    'ru' => 'Количество событий на странице в админ панели',
                ],
            ],
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
