<?php

namespace App\Modules\Orders\Database\Seeds;

use App\Core\Modules\Translates\Models\Translate;
use Illuminate\Database\Seeder;

class TranslatesSeeder extends Seeder
{
    const MODULE = 'orders';

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
                    'ru' => 'Заказы',
                ],
                [
                    'name' => 'general.notification',
                    'ru' => 'Оформлен новый заказ',
                ],
                [
                    'name' => 'general.attributes.user_can_cancel',
                    'ru' => 'Пользователь может отменить заказ с этим статусом',
                ],
                [
                    'name' => 'general.menu.statuses',
                    'ru' => 'Статусы заказов',
                ],
                [
                    'name' => 'general.menu.orders',
                    'ru' => 'Заказы',
                ],
                [
                    'name' => 'general.menu.list',
                    'ru' => 'Заказы',
                ],
                [
                    'name' => 'general.deliveries.self',
                    'ru' => 'Самовывоз',
                ],
                [
                    'name' => 'general.deliveries.nova-poshta-self',
                    'ru' => 'Самовывоз из отделения Новой Почты',
                ],
                [
                    'name' => 'general.deliveries.nova-poshta',
                    'ru' => 'Курьер Новая Почта',
                ],
                [
                    'name' => 'general.deliveries.address',
                    'ru' => 'Адресная доставка',
                ],
                [
                    'name' => 'general.deliveries.other',
                    'ru' => 'Другое',
                ],
                [
                    'name' => 'general.deliveries.ukrposhta',
                    'ru' => 'УкрПошта',
                ],
                [
                    'name' => 'general.payment-methods.cash',
                    'ru' => 'Оплата наличными при получении',
                ],
                [
                    'name' => 'general.payment-methods.bank_transaction',
                    'ru' => 'Банковский перевод',
                ],
                [
                    'name' => 'general.payment-methods.liqpay',
                    'ru' => 'Оплата через LiqPay',
                ],
                [
                    'name' => 'general.payment-methods.cash-on-delivery',
                    'ru' => 'Наложенный платеж',
                ],
                [
                    'name' => 'general.delivery',
                    'ru' => 'Доставка',
                ],
                [
                    'name' => 'general.all-items-cost',
                    'ru' => 'Стоимость товаров',
                ],
                [
                    'name' => 'general.total-to-pay',
                    'ru' => 'Итого',
                ],
                [
                    'name' => 'general.delivery-type',
                    'ru' => 'Способ доставки',
                ],
                [
                    'name' => 'general.delivery-address',
                    'ru' => 'Адрес доставки',
                ],
                [
                    'name' => 'general.payment-method',
                    'ru' => 'Способ оплаты',
                ],
                [
                    'name' => 'general.customer',
                    'ru' => 'Заказчик',
                ],
                [
                    'name' => 'general.receiver',
                    'ru' => 'Получатель',
                ],
                [
                    'name' => 'general.phone',
                    'ru' => 'Номер телефона',
                ],
                [
                    'name' => 'general.email',
                    'ru' => 'Эл. почта',
                ],
                [
                    'name' => 'general.ttn',
                    'ru' => 'Номер ТТН',
                ],
                [
                    'name' => 'general.order-id',
                    'ru' => 'Номер заказа',
                ],
                [
                    'name' => 'general.order-title',
                    'ru' => 'Заказ',
                ],
                [
                    'name' => 'general.order-created-at',
                    'ru' => 'Дата заказа',
                ],
                [
                    'name' => 'general.order-items',
                    'ru' => 'Товары в заказе',
                ],
                [
                    'name' => 'general.order-item',
                    'ru' => 'Товар',
                ],
                [
                    'name' => 'general.print-order',
                    'ru' => 'Распечатать заказ',
                ],
                [
                    'name' => 'general.order-status',
                    'ru' => 'Статус заказа',
                ],
                [
                    'name' => 'general.order-amount',
                    'ru' => 'Сумма заказа',
                ],
                [
                    'name' => 'general.order-comment',
                    'ru' => 'Коментарий заказчика',
                ],
                [
                    'name' => 'general.quantity',
                    'ru' => 'Количество',
                ],
                [
                    'name' => 'general.price-for-one',
                    'ru' => 'Цена за единицу',
                ],
                [
                    'name' => 'general.total',
                    'ru' => 'Всего',
                ],
                [
                    'name' => 'general.by-delivery-service-tariff',
                    'ru' => 'По тарифу перевозчика',
                ],
                [
                    'name' => 'general.last-orders',
                    'ru' => 'Последние заказы',
                ],
                [
                    'name' => 'general.invoice',
                    'ru' => 'Инвойс',
                ],
                [
                    'name' => 'general.status-history',
                    'ru' => 'История изменения статуса заказа',
                ],
                [
                    'name' => 'general.customer-page',
                    'ru' => 'Страница заказчика',
                ],
                [
                    'name' => 'general.registered',
                    'ru' => 'Зарегистрирован :date',
                ],
                [
                    'name' => 'general.pieces',
                    'ru' => 'шт.',
                ],
                [
                    'name' => 'general.do-not-call-me',
                    'ru' => 'Не надо перезванивать',
                ],
                [
                    'name' => 'general.status-date',
                    'ru' => 'Дата изменения статуса',
                ],
                [
                    'name' => 'general.status-comment',
                    'ru' => 'Коментарий',
                ],
                [
                    'name' => 'general.payment-status',
                    'ru' => 'Статус оплаты',
                ],
                [
                    'name' => 'general.paid',
                    'ru' => 'Оплачено',
                ],
                [
                    'name' => 'general.not-paid',
                    'ru' => 'Не оплачено',
                ],
                [
                    'name' => 'general.add-item',
                    'ru' => 'Добавить товар',
                ],
                [
                    'name' => 'general.remove-item',
                    'ru' => 'Удалить товар',
                ],
                [
                    'name' => 'general.do-not-call-to-me-message',
                    'ru' => 'Во время оформления заказа, клиент указал, что нет необходимости ему перезванивать.',
                ],
                [
                    'name' => 'general.choose-order-status',
                    'ru' => 'Выберите статус заказа',
                ],
                [
                    'name' => 'general.change-order-status',
                    'ru' => 'Изменить статус',
                ],
                [
                    'name' => 'general.no-items-message',
                    'ru' => 'Заказ не содержит товаров! Воспользуйтесь кнопкой ниже для исправления ситуации',
                ],
                [
                    'name' => 'general.choose-product',
                    'ru' => 'Выберите товар',
                ],
                [
                    'name' => 'general.no-user-selected',
                    'ru' => 'Пользователь не подвязан к заказу',
                ],
                [
                    'name' => 'general.edit-order',
                    'ru' => 'Редактировать заказ',
                ],
                [
                    'name' => 'general.status-change-history',
                    'ru' => 'История изменения статуса',
                ],
                [
                    'name' => 'general.change-payment-status',
                    'ru' => 'Изменить статус оплаты',
                ],
                [
                    'name' => 'general.no-orders',
                    'ru' => 'Заказов пока нет',
                ],
                [
                    'name' => 'general.create-new',
                    'ru' => 'Создать новый',
                ],
                [
                    'name' => 'general.full-list',
                    'ru' => 'Весь список',
                ],
                [
                    'name' => 'general.back-main',
                    'ru' => 'На главную',
                ],
                [
                    'name' => 'general.back-to-orders',
                    'ru' => 'К моим заказам',
                ],
                [
                    'name' => 'general.to-orders-list',
                    'ru' => 'К заказам',
                ],
                [
                    'name' => 'general.add-order-item-title',
                    'ru' => 'Добавить товар в заказ',
                ],
                [
                    'name' => 'general.delete-item-confirmation',
                    'ru' => 'Удалить позицию из заказа?',
                ],
                [
                    'name' => 'general.paid-auto',
                    'ru' => 'Оплачено через платежную систему',
                ],
                [
                    'name' => 'general.user',
                    'ru' => 'Пользователь',
                ],
                [
                    'name' => 'general.stat-widget-title',
                    'ru' => 'Заказы',
                ],
                [
                    'name' => 'general.unknown',
                    'ru' => 'Неизвестен',
                ],
                [
                    'name' => 'mail.template.name',
                    'ru' => 'Оформлен новый заказ',
                ],
                [
                    'name' => 'mail.total',
                    'ru' => 'Итого',
                ],
                [
                    'name' => 'seo.statuses.index',
                    'ru' => 'Список статусов заказов',
                ],
                [
                    'name' => 'seo.statuses.create',
                    'ru' => 'Создание нового статуса заказа',
                ],
                [
                    'name' => 'seo.statuses.edit',
                    'ru' => 'Редактирование статуса заказа',
                ],
                [
                    'name' => 'seo.orders.index',
                    'ru' => 'Список заказов',
                ],
                [
                    'name' => 'seo.orders.deleted',
                    'ru' => 'Удаленные заказы',
                ],
                [
                    'name' => 'seo.orders.create',
                    'ru' => 'Создание нового заказа',
                ],
                [
                    'name' => 'seo.orders.edit',
                    'ru' => 'Редактирование заказа',
                ],
                [
                    'name' => 'seo.orders.show',
                    'ru' => 'Просмотр деталей заказа #:id',
                ],
                [
                    'name' => 'settings.group-name',
                    'ru' => 'Заказы',
                ],
                [
                    'name' => 'settings.attributes.per-page',
                    'ru' => 'Количество записей на странице в админ панели',
                ],
                [
                    'name' => 'settings.attributes.per-page-for-user',
                    'ru' => 'Количество записей на странице в ЛК пользователя',
                ],
                [
                    'name' => 'settings.attributes.address_for_self_delivery',
                    'ru' => 'Адрес для самовывоза',
                ],
                [
                    'name' => 'settings.attributes.email-is-required',
                    'ru' => 'Форма заказа. Обязательное ли поле email?',
                ],
                [
                    'name' => 'general.mail-templates.attributes.admin_href',
                    'ru' => 'Ссылка на админ панель',
                ],
            ],
            Translate::PLACE_SITE => [
                [
                    'name' => 'site.account-left-menu',
                    'ru' => 'Мои заказы',
                ],
                [
                    'name' => 'site.my-orders',
                    'ru' => 'Мои заказы',
                ],
                [
                    'name' => 'site.orders-history-is-empty',
                    'ru' => 'Ваша история заказов пока пуста.',
                ],
                [
                    'name' => 'site.more',
                    'ru' => 'еще',
                ],
                [
                    'name' => 'site.order-full-information',
                    'ru' => 'Полная информацию о заказе',
                ],
                [
                    'name' => 'site.money-to-pay',
                    'ru' => 'Итого к оплате',
                ],
                [
                    'name' => 'site.step-1',
                    'ru' => 'Шаг первый',
                ],
                [
                    'name' => 'site.step-2',
                    'ru' => 'Шаг второй',
                ],
                [
                    'name' => 'site.checkout',
                    'ru' => 'Оформление заказа',
                ],
                [
                    'name' => 'site.contact-data',
                    'ru' => 'Контактные данные',
                ],
                [
                    'name' => 'site.payment-and-delivery',
                    'ru' => 'Доставка и оплата',
                ],
                [
                    'name' => 'site.next-step',
                    'ru' => 'Продолжить',
                ], [
                    'name' => 'site.name-and-last-name',
                    'ru' => 'Имя и фамилия',
                ],
                [
                    'name' => 'site.edit',
                    'ru' => 'Редактировать',
                ],
                [
                    'name' => 'site.city',
                    'ru' => 'Город',
                ],
                [
                    'name' => 'site.add-comment',
                    'ru' => 'Добавить пожелание или коментарий к заказу',
                ],
                [
                    'name' => 'site.delivery-price',
                    'ru' => 'Стоимость доставки будет рассчитываться<br>в зависимости от объема посылки и точки доставки',
                ],
                [
                    'name' => 'site.approve',
                    'ru' => 'Заказ подтверждаю',
                ],
                [
                    'name' => 'site.accept',
                    'ru' => 'Подтверждая заказ, я принимаю условия',
                ],
                [
                    'name' => 'site.agreement',
                    'ru' => 'пользовательского соглашения',
                ],
                [
                    'name' => 'site.validation.rules.required',
                    'ru' => 'Вы должны заполнить все обязательные поля',
                ],
                [
                    'name' => 'site.validation.attributes.name',
                    'ru' => 'ФИО',
                ],
                [
                    'name' => 'site.validation.attributes.phone',
                    'ru' => 'Телефон',
                ],
                [
                    'name' => 'site.validation.attributes.email',
                    'ru' => 'E-mail',
                ],
                [
                    'name' => 'site.your-order',
                    'ru' => 'Ваш заказ',
                ],
                [
                    'name' => 'site.your-order-accept',
                    'ru' => 'Спасибо, ваш заказ принят',
                ],
                [
                    'name' => 'site.thank-you',
                    'ru' => 'Спасибо, ваш заказ принят',
                ],
                [
                    'name' => 'site.print',
                    'ru' => 'Печать заказа',
                ],
                [
                    'name' => 'site.name',
                    'ru' => 'Название',
                ],
                [
                    'name' => 'site.artikul',
                    'ru' => 'Код товара',
                ],
                [
                    'name' => 'site.quantity',
                    'ru' => 'Количество',
                ],
                [
                    'name' => 'site.price',
                    'ru' => 'Цена',
                ],
                [
                    'name' => 'site.price-total',
                    'ru' => 'Сумма',
                ],
                [
                    'name' => 'site.print-button',
                    'ru' => 'Печать заказа',
                ],
                [
                    'name' => 'site.min-order-noty',
                    'ru' => 'Ваш заказ меньше минимального',
                ],
                [
                    'name' => 'site.cart',
                    'ru' => 'Корзина',
                ],
                [
                    'name' => 'site.cart-is-empty',
                    'ru' => 'Ваша корзина пуста',
                ],
                [
                    'name' => 'site.cart-is-empty-text',
                    'ru' => 'У нас есть много отличных товаров, которые ждут вас. Начните совершать покупки и ищите кнопку <strong style="color: #000; font-size: 20px; font-weight: 900;">«Купить»</strong>. Вы можете добавить несколько товаров в свою корзину и заплатить за все товары одновременно.',
                ],
                [
                    'name' => 'site.cart-is-empty-message',
                    'ru' => 'Ваша корзина пуста. Добавляйте понравившиеся товары в корзину',
                ],
                [
                    'name' => 'site.cart-is-empty-message-not-authorized',
                    'ru' => 'Ваша корзина пуста. Добавляйте понравившиеся товары в корзину или <span role="button" class="js-init" data-mfp="inline" data-mfp-src="#popup-regauth">авторизуйтесь</span>, если добавляли товары ранее',
                ],
                [
                    'name' => 'site.in-the-cart',
                    'ru' => '{1}В корзине <strong>:count товар</strong>|[2,4]В корзине <strong>:count товара</strong>|[5,]В корзине <strong>:count товаров</strong>',
                ],
                [
                    'name' => 'site.in-the-cart-amount',
                    'ru' => 'На сумму',
                ],
                [
                    'name' => 'site.total',
                    'ru' => 'Итого',
                ],
                [
                    'name' => 'site.item-added-to-cart',
                    'ru' => 'Вы добавили товар в корзину',
                ],
                [
                    'name' => 'site.other-items',
                    'ru' => 'Другие товары в корзине',
                ],
                [
                    'name' => 'site.buy',
                    'ru' => 'Купить',
                ],
                [
                    'name' => 'site.in-cart',
                    'ru' => 'В корзине',
                ],
                [
                    'name' => 'site.edit-order',
                    'ru' => 'Редактировать заказ',
                ],
                [
                    'name' => 'site.remove-product',
                    'ru' => 'Удалить товар',
                ],
                [
                    'name' => 'site.cancel',
                    'ru' => 'Отмена',
                ],
                [
                    'name' => 'site.quantity-attr-name',
                    'ru' => 'Количество',
                ],
                [
                    'name' => 'site.to-checkout',
                    'ru' => 'Оформить заказ',
                ],
                [
                    'name' => 'site.currency',
                    'ru' => 'грн',
                ],
                [
                    'name' => 'site.min-amount-order',
                    'ru' => 'Сумма минимального заказа',
                ],
                [
                    'name' => 'site.liqpay.title',
                    'ru' => 'Обработка данных...',
                ],
                [
                    'name' => 'site.liqpay.text',
                    'ru' => 'Поажлуйста, подождите. Идет обработка данных...',
                ],
            ]
        ];

        Translate::setTranslates($translates, static::MODULE);
    }
}
