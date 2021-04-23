<?php

namespace App\Modules\Products\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'products';

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
                    'ru' => 'Модификации',
                ],
                [
                    'name' => 'general.permission-name',
                    'ru' => 'Продукция',
                ],
                [
                    'name' => 'general.attributes.text',
                    'ru' => 'Описание товара',
                ],
                [
                    'name' => 'general.text-related',
                    'ru' => 'Заголовок блока "Cопутствующие товары"',
                ],
                [
                    'name' => 'general.attributes.vendor_code',
                    'ru' => 'Артикул',
                ],
                [
                    'name' => 'general.attributes.related',
                    'ru' => 'Сопутствующие товары',
                ],
                [
                    'name' => 'general.attributes.position',
                    'ru' => 'Позиция',
                ],
                [
                    'name' => 'general.attributes.categories',
                    'ru' => 'Категории товара',
                ],
                [
                    'name' => 'general.available',
                    'ru' => 'В наличии',
                ],
                [
                    'name' => 'general.not-available',
                    'ru' => 'Нет в наличии',
                ],
                [
                    'name' => 'general.product-deleted',
                    'ru' => 'Товар удален',
                ],
                [
                    'name' => 'seo.products.index',
                    'ru' => 'Модификации',
                ],
                [
                    'name' => 'seo.groups.index',
                    'ru' => 'Товары',
                ],
                [
                    'name' => 'seo.groups.create',
                    'ru' => 'Создать новый товар',
                ],
                [
                    'name' => 'seo.groups.edit',
                    'ru' => 'Редактирование товара',
                ],
                [
                    'name' => 'seo.groups.change-feature',
                    'ru' => 'Смена основной характеристики',
                ],
                [
                    'name' => 'seo.template-variables.product-name',
                    'ru' => 'Название товара',
                ],
                [
                    'name' => 'seo.template-variables.product-category',
                    'ru' => 'Основная категория товара',
                ],
                [
                    'name' => 'seo.template-variables.product-categories',
                    'ru' => 'Список категорий товара через запятую',
                ],
                [
                    'name' => 'seo.template-variables.product-price',
                    'ru' => 'Цена товара',
                ],
                [
                    'name' => 'settings.group-name',
                    'ru' => 'Продукты',
                ],
                [
                    'name' => 'settings.microdata',
                    'ru' => 'Микроразметка',
                ],
                [
                    'name' => 'settings.attributes.per-page',
                    'ru' => 'Количество товаров на странице в админ панели',
                ],
                [
                    'name' => 'settings.attributes.site-per-page',
                    'ru' => 'Количество товаров по-умолчанию на странице на сайте',
                ],
                [
                    'name' => 'settings.attributes.filter-counters',
                    'ru' => 'Формировать счетчики в фильтре',
                ],
                [
                    'name' => 'settings.attributes.microdata-search',
                    'ru' => 'Включить микроразметку поисковой строки',
                ],
                [
                    'name' => 'settings.attributes.microdata-product',
                    'ru' => 'Включить микроразметку страницы товара',
                ],
                [
                    'name' => 'settings.attributes.show-categories-if-has',
                    'ru' => 'Показывать список категорий вместо списка товаров, если внутри категории есть дети?',
                ],
                [
                    'name' => 'settings.attributes.show-brand-in-item-card',
                    'ru' => 'Выводить название производителя на карточке товара в списках',
                ],
                [
                    'name' => 'menu.block',
                    'ru' => 'Каталог',
                ],
                [
                    'name' => 'menu.products',
                    'ru' => 'Модификации',
                ],
                [
                    'name' => 'menu.groups',
                    'ru' => 'Товары',
                ],
                [
                    'name' => 'settings.attributes.sizes_title',
                    'ru' => 'Заголовок всплывающего окна "Таблица размеров"',
                ],
                [
                    'name' => 'settings.attributes.sizes_text',
                    'ru' => 'Текст всплывающего окна "Таблица размеров"',
                ],
                [
                    'name' => 'admin.tabs.related',
                    'ru' => 'Сопутствующие товары',
                ],
                [
                    'name' => 'admin.tabs.features',
                    'ru' => 'Характеристики',
                ],
                [
                    'name' => 'admin.choose-your-features',
                    'ru' => 'Выберите характеристику и ее значение перед добавлением!',
                ],
                [
                    'name' => 'admin.choose-feature-to-destroy',
                    'ru' => 'Выберите характеристику перед удалением!',
                ],
                [
                    'name' => 'admin.choose-feature-to-update',
                    'ru' => 'Выберите хотя бы одно значение перед обновлением!',
                ],
                [
                    'name' => 'admin.success-update',
                    'ru' => 'Изменение сохранено!',
                ],
                [
                    'name' => 'admin.clone-product',
                    'ru' => 'Клонировать',
                ],
                [
                    'name' => 'admin.data-cloned',
                    'ru' => 'Товар успешно склонирован!',
                ],
                [
                    'name' => 'admin.choose-product',
                    'ru' => 'Выберите товар',
                ],
                [
                    'name' => 'admin.main-feature',
                    'ru' => 'Основная характеристика для построения модификаций',
                ],
                [
                    'name' => 'admin.feature-changed-successfully',
                    'ru' => 'Основная характеристика успешно изменена!',
                ],
                [
                    'name' => 'admin.attributes.modification-value',
                    'ru' => 'Значение основной характеристики',
                ],
                [
                    'name' => 'admin.modification-name',
                    'ru' => 'Название модификации',
                ],
                [
                    'name' => 'admin.new-value',
                    'ru' => 'Новое значение',
                ],
                [
                    'name' => 'admin.add-modification',
                    'ru' => 'Добавить модификацию',
                ],
                [
                    'name' => 'admin.new-modification',
                    'ru' => 'Новая модификация',
                ],
                [
                    'name' => 'admin.image-on-server-delete-warning',
                    'ru' => 'Изображение загружено на сервер. Удалить?',
                ],
                [
                    'name' => 'admin.add-image',
                    'ru' => 'Добавить изображение',
                ],
                [
                    'name' => 'admin.delete-related-product-message',
                    'ru' => 'Удалить связанный товар?',
                ],
                [
                    'name' => 'admin.group-cloned-successfully',
                    'ru' => 'Продукт скопирован успешно',
                ],
            ],
            Translate::PLACE_SITE => [
                [
                    'name' => 'site.main-specifications',
                    'ru' => 'Основные характеристики',
                ],
                [
                    'name' => 'site.buy',
                    'ru' => 'Купить',
                ],
                [
                    'name' => 'site.related',
                    'ru' => 'Сопутствующие товары',
                ],
                [
                    'name' => 'site.all-about-product',
                    'ru' => 'Все о товаре',
                ],
                [
                    'name' => 'site.description',
                    'ru' => 'Описание',
                ],
                [
                    'name' => 'site.features',
                    'ru' => 'Характеристики',
                ],
                [
                    'name' => 'site.instructions',
                    'ru' => 'Инструкции',
                ],
                [
                    'name' => 'site.registration',
                    'ru' => 'Регистрационное свидетельство',
                ],
                [
                    'name' => 'site.main-features',
                    'ru' => 'ОСНОВНЫЕ ХАРАКТЕРИСТИКИ:',
                ],
                [
                    'name' => 'site.offers',
                    'ru' => 'ДОСТУПНЫЕ ПРЕДЛОЖЕНИЯ:',
                ],
                [
                    'name' => 'site.one-click-buy',
                    'ru' => 'Купить в один клик',
                ],
                [
                    'name' => 'site.delivery-link',
                    'ru' => 'Условия доставки',
                ],
                [
                    'name' => 'site.payment-link',
                    'ru' => 'Варианты оплаты',
                ],
                [
                    'name' => 'site.filter-reset',
                    'ru' => 'Сбросить фильтр',
                ],
                [
                    'name' => 'site.compare',
                    'ru' => 'Сравнить',
                ],
                [
                    'name' => 'site.add-product',
                    'ru' => 'Добавить товар к сравнению',
                ],
                [
                    'name' => 'site.brand',
                    'ru' => 'Производитель',
                ],
                [
                    'name' => 'site.wishlist',
                    'ru' => 'Желания',
                ],
                [
                    'name' => 'site.sizes',
                    'ru' => 'Таблица размеров',
                ],
                [
                    'name' => 'site.delete',
                    'ru' => 'Удалить',
                ],
                [
                    'name' => 'site.deleted',
                    'ru' => 'Удален',
                ],
                [
                    'name' => 'site.filter-btn',
                    'ru' => 'Фильтр',
                ],
                [
                    'name' => 'site.products-review',
                    'ru' => '[1]:count отзыв|[2,4]:count отзыва|[5,9]:count отзывов',
                ],
                [
                    'name' => 'site.products-review-write',
                    'ru' => 'Написать отзыв',
                ],
                [
                    'name' => 'site.new',
                    'ru' => 'Новинки',
                ],
                [
                    'name' => 'site.in-wishlist',
                    'ru' => 'В желаниях',
                ],
                [
                    'name' => 'site.see-all',
                    'ru' => 'Смотреть все',
                ],
                [
                    'name' => 'site.order.default',
                    'ru' => 'По умолчанию',
                ],
                [
                    'name' => 'site.order.price-asc',
                    'ru' => 'от дешевых к дорогим',
                ],
                [
                    'name' => 'site.order.price-desc',
                    'ru' => 'от дорогих к дешевым',
                ],
                [
                    'name' => 'site.order.name-asc',
                    'ru' => 'по названию от А до Я',
                ],
                [
                    'name' => 'site.order.name-desc',
                    'ru' => 'по названию от Я до А',
                ],
                [
                    'name' => 'site.filter.price-filter',
                    'ru' => 'Цена, грн.',
                ],
                [
                    'name' => 'site.filter.from',
                    'ru' => 'от',
                ],
                [
                    'name' => 'site.filter.to',
                    'ru' => 'до',
                ],
                [
                    'name' => 'site.filter.OK',
                    'ru' => 'OK',
                ],
                [
                    'name' => 'site.cart.delete',
                    'ru' => 'Удалить товар',
                ],
                [
                    'name' => 'site.cart.cancel',
                    'ru' => 'Отмена',
                ],
                [
                    'name' => 'site.search.button-title',
                    'ru' => 'Поиск',
                ],
                [
                    'name' => 'site.reviews',
                    'ru' => 'Отзывы',
                ],
                [
                    'name' => 'site.guaranty-link',
                    'ru' => 'Гарантия',
                ],
                [
                    'name' => 'site.search.no-results',
                    'ru' => 'Задайте поисковый запрос',
                ],
                [
                    'name' => 'site.products-search',
                    'ru' => '[1]:count товар|[2,4]:count товара|[5,9]:count товаров',
                ],
                [
                    'name' => 'site.search.results',
                    'help' => [
                        ':query' => 'labels::variables.query',
                        ':total' => 'labels::variables.total'
                    ],
                    'ru' => 'По запросу <span class="_color-main">«:query»</span> нашлось <span class="_color-main">:total</span>',
                ],
                [
                    'name' => 'admin.choose-product',
                    'ru' => 'Выберите товар',
                ],
            ]
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
