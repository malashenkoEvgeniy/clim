<?php

namespace App\Modules\ProductsAvailability\Listeners;

use App\Components\Mailer\MailSender;
use App\Core\Interfaces\ListenerInterface;
use App\Core\Modules\Mail\Models\MailTemplate;
use App\Modules\ProductsAvailability\Events\ChangeProductStatusEvent;
use App\Modules\ProductsAvailability\Models\ProductsAvailability;

/**
 * Class ChangeProductStatus
 *
 * @package App\Modules\ProductsAvailability\Listeners
 */
class ChangeProductStatus implements ListenerInterface
{

    public static function listens(): string
    {
        return ChangeProductStatusEvent::class;
    }

    /**
     * Handle the event.
     *
     * @param ChangeProductStatusEvent $event
     * @return void
     */
    public function handle(ChangeProductStatusEvent $event)
    {
        $this->sendMail($event);
    }

    /**
     * @param ChangeProductStatusEvent $event
     */
    public function sendMail(ChangeProductStatusEvent $event)
    {
        if (!config('db.basic.admin_email') || !$event->productId) {
            return;
        }
        $orders = ProductsAvailability::with('product')->whereProductId($event->productId)->get();
        if (empty($orders)) {
            return;
        }
        $ids = [];
        $template = MailTemplate::getTemplateByAlias('products-availability-for-users');
        if (!$template) {
            return;
        }
        foreach ($orders as $order) {
            $from = [
                '{product}',
            ];
            $to = [
                route('site.product', $order->product->current->slug),
            ];
            $subject = str_replace($from, $to, $template->current->subject);
            $body = str_replace($from, $to, $template->current->text);
            if(MailSender::send($order->email, $subject, $body) !== false){
                $ids[] = $order->id;
            }
        }
        if (empty($ids)) {
            return;
        }
        ProductsAvailability::whereIn('id', $ids)->delete();
    }

}
