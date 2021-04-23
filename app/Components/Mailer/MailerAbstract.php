<?php

namespace App\Components\Mailer;

/**
 * Class MailerAbstract
 *
 * @package App\Components\Mail\Simple
 */
abstract class MailerAbstract
{
    
    /**
     * Mail subject
     *
     * @var string
     */
    protected $subject;
    
    /**
     * Mail body
     *
     * @var string
     */
    protected $body;
    
    /**
     * Sender email
     *
     * @var string
     */
    protected $sender;
    
    /**
     * Template for mail content
     *
     * @var string
     */
    protected $markdown;
    
    /**
     * Recipients list
     *
     * @var array
     */
    protected $recipients = [];
    
    /**
     * Set mail subject
     *
     * @param string $subject
     */
    public function setSubject(string $subject)
    {
        $this->subject = $subject;
    }
    
    /**
     * Set mail body
     *
     * @param string $text
     */
    public function setBody(string $text)
    {
        $this->body = $text;
    }
    
    /**
     * Set mail template name
     *
     * @param string $markdown
     */
    public function setMarkdown(string $markdown)
    {
        $this->markdown = $markdown;
    }
    
    /**
     * Add recipients to the list
     *
     * @param string $email
     */
    public function addRecipient(string $email)
    {
        if (in_array($email, $this->recipients) === false) {
            $this->recipients[] = $email;
        }
    }
    
}