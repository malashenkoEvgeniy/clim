<?php

namespace App\Modules\Callback\Listeners;

use App\Core\Interfaces\ListenerInterface;
use App\Core\Modules\Mail\Models\MailTemplate;
use App\Core\Modules\Notifications\Models\Notification;
use App\Modules\Callback\Models\Callback;
use App\Modules\Subscribe\Events\NewSubscriberEvent;
use App\Components\Mailer\MailSender;

/**
 * Class NewCallbackOrderNotification
 *
 * @package App\Modules\Callback\Listeners
 */
class NewCallbackOrderNotification implements ListenerInterface
{
    
    const NOTIFICATION_TYPE = 'callback';
    
    const NOTIFICATION_ICON = 'fa fa-phone';
    
    public static function listens(): string
    {
        return 'callback';
    }
    
    /**
     * Handle the event.
     *
     * @param Callback $callback
     * @return void
     */
    public function handle(Callback $callback)
    {
        Notification::send(
            static::NOTIFICATION_TYPE,
            'callback::general.notification',
            'admin.callback.edit',
            ['id' => $callback->id]
        );
    }
}