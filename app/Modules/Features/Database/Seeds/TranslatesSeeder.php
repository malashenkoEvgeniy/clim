<?php

namespace App\Modules\Features\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'features';

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
                    'name' => 'general.permission-name',
                    'ru' => 'Характеристики товаров',
                ],
                [
                    'name' => 'general.settings-name',
                    'ru' => 'Характеристики товаров',
                ],
                [
                    'name' => 'general.menu',
                    'ru' => 'Характеристики товаров',
                ],
                [
                    'name' => 'general.attributes.in_filter',
                    'ru' => 'Показывать в фильтре',
                ],
                [
                    'name' => 'general.attributes.type',
                    'ru' => 'Тип характеристики',
                ],
                [
                    'name' => 'general.titleValues',
                    'ru' => 'Значения характеристик товаров',
                ],
                [
                    'name' => 'general.createValue',
                    'ru' => 'Добавить значение',
                ],
                [
                    'name' => 'general.attributes.main',
                    'ru' => 'Показывать в карточке товара в списке',
                ],
                [
                    'name' => 'general.types.multiple',
                    'ru' => 'Множественный выбор',
                ],
                [
                    'name' => 'general.types.single',
                    'ru' => 'Обычная характеристика',
                ],
                [
                    'name' => 'general.tabs.values',
                    'ru' => 'Значения',
                ],
                [
                    'name' => 'general.delete-feature-value-warning',
                    'ru' => 'Подтвердите удаление значения',
                ],
                [
                    'name' => 'general.delete-feature-link',
                    'ru' => 'Подтвердите действие',
                ],
                [
                    'name' => 'general.add-feature-value',
                    'ru' => 'Содать значение',
                ],
                [
                    'name' => 'general.update-feature-value-title',
                    'help' => [
                        ':value' => 'features::variables.description-for-value'
                    ],
                    'ru' => 'Редактирование значения :value',
                ],
                [
                    'name' => 'general.add-feature-value-title',
                    'ru' => 'Добавление значния',
                ],
                [
                    'name' => 'general.add',
                    'ru' => 'Добавить',
                ],
                [
                    'name' => 'general.feature',
                    'ru' => 'Характеристика',
                ],
                [
                    'name' => 'general.values',
                    'ru' => 'Значения',
                ],
                [
                    'name' => 'seo.index',
                    'ru' => 'Список характеристик',
                ],
                [
                    'name' => 'seo.edit',
                    'ru' => 'Редактирование характеристики',
                ],
                [
                    'name' => 'seo.create',
                    'ru' => 'Добавление новой характеристики',
                ],
                [
                    'name' => 'seo.destroy',
                    'ru' => 'Удаление характеристики',
                ],
                [
                    'name' => 'seo.valuesEdit',
                    'ru' => 'Редактирование значения характеристики',
                ],
                [
                    'name' => 'seo.valueCreate',
                    'ru' => 'Добавление нового значения',
                ],
                [
                    'name' => 'settings.attributes.per-page',
                    'ru' => 'Количество характеристик на странице в админ панели',
                ],
                [
                    'name' => 'general.feature-deleted-successfully',
                    'ru' => 'Характеристика успешно удалена. Всезначения для существующих привязанных товаров изменены!',
                ],
                [
                    'name' => 'admin.current-value',
                    'ru' => 'Значение характеристики',
                ],
                [
                    'name' => 'admin.choose-new-value',
                    'ru' => 'Значение новой характеристики',
                ],
                [
                    'name' => 'admin.you-can-not-delete-main-modification',
                    'ru' => 'Вы не можете удалить основную модификацию!',
                ],
                [
                    'name' => 'admin.you-can-not-delete-only-modification',
                    'ru' => 'Вы не можете удалить единственную модификацию!',
                ],
                [
                    'name' => 'settings.attributes.show-main-features',
                    'ru' => 'Вывести основные характеристики в списке товаров',
                ],
            ],
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
