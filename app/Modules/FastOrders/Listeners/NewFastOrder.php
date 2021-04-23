<?php

namespace App\Modules\FastOrders\Listeners;

use App\Components\Mailer\MailSender;
use App\Core\Interfaces\ListenerInterface;
use App\Core\Modules\Mail\Models\MailTemplate;
use App\Core\Modules\Notifications\Models\Notification;
use App\Modules\FastOrders\Events\FastOrderEvent;

/**
 * Class NewFastOrder
 *
 * @package App\Modules\FastOrders\Listeners
 */
class NewFastOrder implements ListenerInterface
{

    const NOTIFICATION_TYPE = 'fast-order';

    const NOTIFICATION_ICON = 'fa fa-cart-plus';

    public static function listens(): string
    {
        return FastOrderEvent::class;
    }

    /**
     * Handle the event.
     *
     * @param FastOrderEvent $event
     * @return void
     */
    public function handle(FastOrderEvent $event)
    {
        $this->sendMail($event);
        Notification::send(
            static::NOTIFICATION_TYPE,
            'fast_orders::general.notification',
            'admin.fast_orders.edit',
            ['fastOrder' => $event->orderId]
        );
    }

    /**
     * @param FastOrderEvent $event
     */
    public function sendMail(FastOrderEvent $event)
    {
        if (!config('db.basic.admin_email')) {
            return;
        }
        $template = MailTemplate::getTemplateByAlias('fast-orders');
        if (!$template) {
            return;
        }
        $from = [
            '{phone}',
            '{admin_href}',
        ];
        $to = [
            $event->phone,
            route('admin.fast_orders.edit', ['id' => $event->orderId])
        ];
        $subject = str_replace($from, $to, $template->current->subject);
        $body = str_replace($from, $to, $template->current->text);
        MailSender::send(config('db.basic.admin_email'), $subject, $body);
    }

}
