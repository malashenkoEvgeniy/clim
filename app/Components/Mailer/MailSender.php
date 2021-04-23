<?php

namespace App\Components\Mailer;

use App\Components\Mailer\Drivers\Simple as StandardMailer;
use App\Components\Mailer\Drivers\SendPulse;
use Exception;

/**
 * Class Sender
 *
 * @package Appp\Components\Mail
 */
class MailSender
{
    const DRIVER_SENDPULSE = 'sendpulse';
    
    /**
     * @var MailerFactory
     */
    public $mailer;
    
    /**
     * Sender constructor.
     *
     * @param MailerFactory $mailer
     */
    public function __construct(MailerFactory $mailer)
    {
        $this->mailer = $mailer;
    }
    
    /**
     * Creates instance of Sender
     *
     * @return MailSender
     * @throws Exception
     */
    protected static function init(): MailSender
    {
        switch (config('db.mail.driver')) {
            case static::DRIVER_SENDPULSE:
                $driver = new SendPulse;
                break;
            default:
                $driver = new StandardMailer;
        }
        return new MailSender($driver);
    }
    
    /**
     * Send mail
     *
     * @param string $recipient
     * @param string $subject
     * @param string $text
     * @param null|string $markdown
     * @param array $parameters
     * @return bool
     */
    public static function send(string $recipient, string $subject, string $text, ?string $markdown = null, array $parameters = [])
    {
        try {
            $mailSender = MailSender::init();
            $mailSender->mailer->addRecipient($recipient);
            $mailSender->mailer->setSubject($subject);
            $mailSender->mailer->setBody($text);
            $mailSender->mailer->setMarkdown($markdown ?? config('mail.layouts.default'));
            return $mailSender->mailer->send($parameters);
        } catch (Exception $exception) {
            event('notification.error', [
                'Email: ' . $exception->getMessage(),
                'admin.settings.group',
                ['group' => 'mail']
            ]);
            return false;
        }
    }
    
    public static function sendMany(array $recipients, string $subject, string $text, ?string $markdown = null)
    {
        try {
            $mailSender = MailSender::init();
            foreach ($recipients as $recipient) {
                $mailSender->mailer->addRecipient($recipient);
            }
            $mailSender->mailer->setSubject($subject);
            $mailSender->mailer->setBody($text);
            $mailSender->mailer->setMarkdown($markdown ?? config('mail.layouts.default'));
            return $mailSender->mailer->send();
        } catch (Exception $exception) {
            event('notification.error', [
                'Email: ' . $exception->getMessage(),
                'admin.settings.group',
                ['group' => 'mail']
            ]);
            return false;
        }
    }
    
}
