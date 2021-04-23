<?php

namespace App\Modules\Consultations\Listeners;

use App\Core\Interfaces\ListenerInterface;
use App\Core\Modules\Mail\Models\MailTemplate;
use App\Core\Modules\Notifications\Models\Notification;
use App\Modules\Consultations\Models\Consultation;
use App\Modules\Subscribe\Events\NewSubscriberEvent;
use App\Components\Mailer\MailSender;

/**
 * Class NewConsultationOrderNotification
 *
 * @package App\Modules\Consultations\Listeners
 */
class NewConsultationOrderNotification implements ListenerInterface
{
    
    const NOTIFICATION_TYPE = 'consultations';
    
    const NOTIFICATION_ICON = 'fa fa-phone';
    
    public static function listens(): string
    {
        return 'consultation';
    }
    
    /**
     * Handle the event.
     *
     * @param Consultation $consultation
     * @return void
     */
    public function handle(Consultation $consultation)
    {
        Notification::send(
            static::NOTIFICATION_TYPE,
            'consultations::general.notification',
            'admin.consultations.edit',
            ['id' => $consultation->id]
        );
    }
}
