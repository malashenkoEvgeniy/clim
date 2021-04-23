<?php

namespace App\Components\Mailer\Drivers;

use App\Components\Mailer\MailerAbstract;
use App\Components\Mailer\MailerFactory;
use Sendpulse\RestApi\ApiClient;
use Sendpulse\RestApi\Storage\FileStorage;

class SendPulse extends MailerAbstract implements MailerFactory
{
    /**
     * @var ApiClient
     */
    private $client;
    
    
    /**
     * SendPulse constructor.
     *
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $this->client = new ApiClient(
            config('db.mail.sendpulse_user_id', config('services.sendpulse.user_id')),
            config('db.mail.sendpulse_secret', config('services.sendpulse.secret')),
            new FileStorage(storage_path('logs'))
        );
    }
    
    /**
     * @param array $parameters
     * @throws \Throwable
     */
    public function send(array $parameters = [])
    {
        $subject = $this->subject;
        $body = $this->body;
        foreach ($this->recipients as $recipient) {
            $email = [
                'html' => view($this->markdown, $parameters + [
                    'content' => $body,
                    'subject' => $subject,
                ])->render(),
                'text' => strip_tags($body),
                'subject' => $subject,
                'from' => [
                    'name' => config('db.mail.sendpulse_from_email'),
                    'email' => config('db.mail.sendpulse_from_name'),
                ],
                'to' => [['email' => $recipient]],
            ];
            $response = $this->client->smtpSendMail($email);
            if ($response && $response->is_error === true) {
                throw new \Exception($response->message ?? 'Unknown error');
            }
        }
    }
    
}
