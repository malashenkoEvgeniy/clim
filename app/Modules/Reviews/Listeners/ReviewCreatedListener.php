<?php

namespace App\Modules\Reviews\Listeners;

use App\Components\Mailer\MailSender;
use App\Core\Interfaces\ListenerInterface;
use App\Core\Modules\Mail\Models\MailTemplate;
use App\Modules\Reviews\Models\Review;

/**
 * Class ReviewsCreatedListener
 *
 * @package App\Modules\Reviews\Listeners
 */
class ReviewCreatedListener implements ListenerInterface
{
    public static function listens(): string
    {
        return 'review::created';
    }
    
    /**
     * Handle the event.
     *
     * @param Review $review
     * @return void
     */
    public function handle(Review $review)
    {
        $this->sendMail($review);
    }
    
    private function sendMail(Review $review): void
    {
        $template = MailTemplate::getTemplateByAlias('reviews-admin');
        if ($template) {
            $from = [
                '{name}',
                '{email}',
                '{comment}',
                '{admin_href}',
            ];
            $to = [
                $review->name,
                $review->email,
                $review->comment,
                route('admin.consultations.edit', ['id' => $review->id])
            ];
            $subject = str_replace($from, $to, $template->current->subject);
            $body = str_replace($from, $to, $template->current->text);
            MailSender::send(config('db.basic.admin_email'), $subject, $body);
        }
        return;
    }

}
