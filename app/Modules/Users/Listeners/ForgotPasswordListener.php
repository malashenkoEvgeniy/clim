<?php

namespace App\Modules\Users\Listeners;

use App\Core\Interfaces\ListenerInterface;
use App\Core\Modules\Mail\Models\MailTemplate;
use App\Components\Mailer\MailSender;
use App\Modules\Users\Events\ForgotPasswordEvent;

/**
 * Class ForgotPasswordListener
 *
 * @package App\Modules\Users\Listeners
 */
class ForgotPasswordListener implements ListenerInterface
{
    public static function listens(): string
    {
        return ForgotPasswordEvent::class;
    }
    
    /**
     * Handle the event.
     *
     * @param ForgotPasswordEvent $event
     * @return void
     */
    public function handle(ForgotPasswordEvent $event)
    {
        $template = MailTemplate::getTemplateByAlias('forgot-password');
        if (!$template) {
            return;
        }
        $from = [
            '{email}',
            '{link}',
        ];
        $to = [
            $event->email,
            route('site.password.reset', ['token' => $event->token]),
        ];
        $subject = str_replace($from, $to, $template->current->subject);
        $body = str_replace($from, $to, $template->current->text);
        MailSender::send($event->email, $subject, $body);
    }
}