<?php

namespace App\Modules\Callback\Listeners;

use App\Components\Mailer\MailSender;
use App\Core\Interfaces\ListenerInterface;
use App\Core\Modules\Mail\Models\MailTemplate;
use App\Modules\Callback\Models\Callback;

/**
 * Class CallbackCreatedListener
 *
 * @package App\Modules\Callback\Listeners
 */
class CallbackCreatedListener implements ListenerInterface
{
    public static function listens(): string
    {
        return 'callback::created';
    }
    
    /**
     * Handle the event.
     *
     * @param Callback $callback
     * @return void
     */
    public function handle(Callback $callback)
    {
        $this->sendMail($callback);
    }
    
    private function sendMail(Callback $callback): void
    {
        $template = MailTemplate::getTemplateByAlias('callback-admin');
        if ($template) {
            $from = [
                '{name}',
                '{phone}',
                '{admin_href}',
            ];
            $to = [
                $callback->name,
                $callback->phone,
                route('admin.orders.edit', ['id' => $callback->id])
            ];
            $subject = str_replace($from, $to, $template->current->subject);
            $body = str_replace($from, $to, $template->current->text);
            MailSender::send(config('db.basic.admin_email'), $subject, $body);
        }
        return;
    }

}
