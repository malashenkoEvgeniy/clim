<?php

namespace App\Modules\SocialButtons\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'social_buttons';

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
                    'ru' => 'Социальные сети',
                ],
                [
                    'name' => 'general.settings-block-name',
                    'ru' => 'Социальные сети',
                ],
                [
                    'name' => 'general.addthis',
                    'ru' => 'Ключ для плагина AddThis',
                ],
                [
                    'name' => 'general.icon-labels.vk',
                    'ru' => 'ВКонтакте',
                ],
                [
                    'name' => 'general.icon-labels.facebook',
                    'ru' => 'FaceBook',
                ],
                [
                    'name' => 'general.icon-labels.instagram',
                    'ru' => 'Instagram',
                ],
                [
                    'name' => 'general.icon-labels.twitter',
                    'ru' => 'Twitter',
                ],
                [
                    'name' => 'general.icon-labels.google-plus',
                    'ru' => 'Google+',
                ],
                [
                    'name' => 'general.icon-labels.youtube',
                    'ru' => 'YouTube',
                ],
            ],
            Translate::PLACE_SITE => [
                [
                    'name' => 'site.icon-labels.vk',
                    'ru' => 'Мы в VK',
                ],
                [
                    'name' => 'site.icon-labels.facebook',
                    'ru' => 'Мы в FaceBook',
                ],
                [
                    'name' => 'site.icon-labels.instagram',
                    'ru' => 'Мы в Instagram',
                ],
                [
                    'name' => 'site.icon-labels.twitter',
                    'ru' => 'Мы в Twitter',
                ],
                [
                    'name' => 'site.icon-labels.google-plus',
                    'ru' => 'Мы в Google+',
                ],
                [
                    'name' => 'site.icon-labels.youtube',
                    'ru' => 'Мы в YouTube',
                ],
            ]
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
