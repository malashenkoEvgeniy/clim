<?php

namespace App\Modules\Users\Listeners;

use App\Core\Interfaces\ListenerInterface;
use App\Core\Modules\Mail\Models\MailTemplate;
use App\Components\Mailer\MailSender;
use App\Core\Modules\Notifications\Models\Notification;
use App\Modules\Users\Models\PhoneVerification;
use App\Modules\Users\Models\User;
use Illuminate\Auth\Events\Registered;

/**
 * Class NewRegistration
 *
 * @package App\Modules\Users\Listeners
 */
class NewRegistration implements ListenerInterface
{
    
    const NOTIFICATION_TYPE = 'registration';
    
    const NOTIFICATION_ICON = 'fa fa-users';
    
    public static function listens(): string
    {
        return Registered::class;
    }
    
    /**
     * Handle the event.
     *
     * @param Registered $event
     * @throws \Exception
     */
    public function handle(Registered $event)
    {
        /** @var User $user */
        $user = $event->user;
        Notification::send(
            static::NOTIFICATION_TYPE,
            'users::general.notification',
            'admin.users.edit',
            ['user' => $user->id]
        );
        $this->sendMail($event);
    }

    /**
     * @param Registered $event
     */
    public function sendMail(Registered $event)
    {
        /** @var User $user */
        $user = $event->user;
        $template = MailTemplate::getTemplateByAlias('registration');
        if (!$template) {
            return;
        }
        $from = [
            '{email}',
            '{password}',
        ];
        $to = [
            $user->email,
            request()->input('password'),
        ];
        $subject = str_replace($from, $to, $template->current->subject);
        $body = str_replace($from, $to, $template->current->text);
        MailSender::send($user->email, $subject, $body);
    }
}
