<?php

namespace App\Components\Mailer\Drivers;

use Mail;
use App\Components\Mailer\MailerAbstract;
use App\Components\Mailer\MailerFactory;

/**
 * Class Mailer
 *
 * @package App\Components\Mail\Simple
 */
class Simple extends MailerAbstract implements MailerFactory
{
    
    /**
     * Sends email
     *
     * @param array $parameters
     */
    public function send(array $parameters = [])
    {
        $subject = $this->subject;
        $body = $this->body;
        foreach ($this->recipients as $recipient) {
            Mail::send($this->markdown, $parameters + [
                'content' => $body,
                'subject' => $subject,
            ], function ($message) use ($recipient, $subject) {
                $message->subject($subject);
                $message->to($recipient);
            });
        }
    }
    
}
