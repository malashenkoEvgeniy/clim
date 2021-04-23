<?php

namespace App\Modules\ProductsAvailability\Listeners;

use App\Components\Mailer\MailSender;
use App\Core\Interfaces\ListenerInterface;
use App\Core\Modules\Mail\Models\MailTemplate;
use App\Core\Modules\Notifications\Models\Notification;
use App\Modules\ProductsAvailability\Events\ProductsAvailabilityEvent;

/**
 * Class NewOrder
 *
 * @package App\Modules\ProductsAvailability\Listeners
 */
class NewOrder implements ListenerInterface
{

    const NOTIFICATION_TYPE = 'products-availability';

    const NOTIFICATION_ICON = 'fa fa-get-pocket';

    public static function listens(): string
    {
        return ProductsAvailabilityEvent::class;
    }

    /**
     * Handle the event.
     *
     * @param ProductsAvailabilityEvent $event
     * @return void
     */
    public function handle(ProductsAvailabilityEvent $event)
    {
        $this->sendMail($event);
        Notification::send(
            static::NOTIFICATION_TYPE,
            'products-availability::general.notification',
            'admin.products_availability.edit',
            ['productsAvailability' => $event->orderId]
        );
    }

    /**
     * @param ProductsAvailabilityEvent $event
     */
    public function sendMail(ProductsAvailabilityEvent $event)
    {
        if (!config('db.basic.admin_email')) {
            return;
        }
        $template = MailTemplate::getTemplateByAlias('products-availability');
        if (!$template) {
            return;
        }
        $from = [
            '{email}',
        ];
        $to = [
            $event->email,
        ];
        $subject = str_replace($from, $to, $template->current->subject);
        $body = str_replace($from, $to, $template->current->text);
        MailSender::send(config('db.basic.admin_email'), $subject, $body);
    }

}
