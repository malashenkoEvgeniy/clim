<?php

namespace App\Modules\Consultations\Listeners;

use App\Components\Mailer\MailSender;
use App\Core\Interfaces\ListenerInterface;
use App\Core\Modules\Mail\Models\MailTemplate;
use App\Modules\Consultations\Models\Consultation;

/**
 * Class ConsultationCreatedListener
 *
 * @package App\Modules\Consultation\Listeners
 */
class ConsultationCreatedListener implements ListenerInterface
{
    public static function listens(): string
    {
        return 'consultation::created';
    }
    
    /**
     * Handle the event.
     *
     * @param Consultation $consultation
     * @return void
     */
    public function handle(Consultation $consultation)
    {
        $this->sendMail($consultation);
    }
    
    private function sendMail(Consultation $consultation): void
    {
        $template = MailTemplate::getTemplateByAlias('consultation-admin');
        if ($template) {
            $from = [
                '{name}',
                '{phone}',
                '{question}',
                '{admin_href}',
            ];
            $to = [
                $consultation->name,
                $consultation->phone,
                $consultation->question,
                route('admin.consultations.edit', ['id' => $consultation->id])
            ];
            $subject = str_replace($from, $to, $template->current->subject);
            $body = str_replace($from, $to, $template->current->text);
            MailSender::send(config('db.basic.admin_email'), $subject, $body);
        }
        return;
    }

}
