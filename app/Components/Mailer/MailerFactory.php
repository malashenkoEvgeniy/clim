<?php

namespace App\Components\Mailer;

/**
 * Interface MailerFactory
 *
 * @package App\Components\Mail
 */
interface MailerFactory
{
    
    public function send(array $parameters = []);
    
    public function addRecipient(string $email);
    
    public function setSubject(string $subject);
    
    public function setBody(string $text);
    
    public function setMarkdown(string $template);
    
}
