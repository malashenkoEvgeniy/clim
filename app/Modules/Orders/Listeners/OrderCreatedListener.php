<?php

namespace App\Modules\Orders\Listeners;

use App\Components\Mailer\MailSender;
use App\Core\Interfaces\ListenerInterface;
use App\Core\Modules\Mail\Models\MailTemplate;
use App\Modules\Orders\Models\Order;
use App\Modules\Orders\Types\OrderType;
use Cart;

/**
 * Class OrderCreatedListener
 *
 * @package App\Modules\Orders\Listeners
 */
class OrderCreatedListener implements ListenerInterface
{
    public static function listens(): string
    {
        return 'orders::created';
    }
    
    /**
     * Handle the event.
     *
     * @param OrderType $orderType
     * @return void
     */
    public function handle(OrderType $orderType)
    {
        $this->sendMail($orderType);
        Cart::delete();
    }
    
    private function sendMail(OrderType $orderType): void
    {
        if (!$orderType->clientEmail) {
            return;
        }
        $template = MailTemplate::getTemplateByAlias(Order::MAIL_TEMPLATE_ORDER_CREATED);
        if ($template) {
            MailSender::send(
                $orderType->clientEmail,
                $template->current->subject,
                $template->current->text,
                'orders::mail.orders',
                [
                    'orderType' => $orderType,
                ]
            );
        }


        $templateAdmin = MailTemplate::getTemplateByAlias(Order::MAIL_TEMPLATE_ORDER_CREATED_ADMIN);
        if ($templateAdmin) {
            $from = [
                '{admin_href}',
            ];
            $to = [
                route('admin.orders.edit', ['id' => $orderType->id])
            ];
            $subject = str_replace($from, $to, $templateAdmin->current->subject);
            $body = str_replace($from, $to, $templateAdmin->current->text);
            MailSender::send(
                config('db.basic.admin_email'),
                $subject,
                $body,
                'orders::mail.orders',
                [
                    'orderType' => $orderType,
                ]
            );
        }
        return;
    }

}
