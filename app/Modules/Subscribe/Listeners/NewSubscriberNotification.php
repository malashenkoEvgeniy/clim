<?php

namespace App\Modules\Subscribe\Listeners;

use App\Core\Interfaces\ListenerInterface;
use App\Core\Modules\Mail\Models\MailTemplate;
use App\Modules\Subscribe\Events\NewSubscriberEvent;
use App\Components\Mailer\MailSender;

/**
 * Class NewSubscriberNotification
 *
 * @package App\Modules\Subscribe\Listeners
 */
class NewSubscriberNotification implements ListenerInterface
{
    
    public static function listens(): string
    {
        return NewSubscriberEvent::class;
    }
    
    /**
     * Handle the event.
     *
     * @param NewSubscriberEvent $event
     * @return void
     */
    public function handle(NewSubscriberEvent $event)
    {
        $template = MailTemplate::getTemplateByAlias('subscription');
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
        MailSender::send($event->email, $subject, $body);
    }
}