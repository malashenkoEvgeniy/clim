<?php

namespace App\Modules\SiteMenu\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'site_menu';

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
                    'ru' => 'Меню',
                ],
                [
                    'name' => 'general.menu',
                    'ru' => 'Меню',
                ],
                [
                    'name' => 'general.header',
                    'ru' => 'Меню в хедере',
                ],
                [
                    'name' => 'general.footer',
                    'ru' => 'Меню в футере',
                ],
                [
                    'name' => 'general.mobile',
                    'ru' => 'Мобильное меню',
                ],
                [
                    'name' => 'general.internal',
                    'ru' => 'Внутренняя ссылка',
                ],
                [
                    'name' => 'general.external',
                    'ru' => 'Внешняя ссылка',
                ],
                [
                    'name' => 'general.place',
                    'ru' => 'Расположение меню',
                ],
                [
                    'name' => 'general.slug_type',
                    'ru' => 'Тип ссылки',
                ],
                [
                    'name' => 'seo.index',
                    'ru' => 'Список пунктов меню',
                ],
                [
                    'name' => 'seo.edit',
                    'ru' => 'Редактирование пункта меню',
                ],
                [
                    'name' => 'seo.create',
                    'ru' => 'Добавление нового пункта меню',
                ],
                [
                    'name' => 'seo.footer',
                    'ru' => 'Меню в подвале сайта',
                ],
                [
                    'name' => 'seo.header',
                    'ru' => 'Меню в шапке сайта',
                ],
                [
                    'name' => 'seo.mobile',
                    'ru' => 'Мобильное меню',
                ],
            ],
            Translate::PLACE_SITE => [
                [
                    'name' => 'site.for-clients',
                    'ru' => 'Клиентам',
                ],
                [
                    'name' => 'site.hot-line-text',
                    'ru' => 'Горячая линия',
                ],
                [
                    'name' => 'site.free-for-all-phones',
                    'ru' => 'Бесплатно со стационарных и мобильных телефонов в Украине',
                ],
                [
                    'name' => 'site.schedule-call-center',
                    'ru' => 'График работы',
                ],
                [
                    'name' => 'site.mobile-menu-block',
                    'ru' => 'Меню сайта',
                ],
            ]
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
