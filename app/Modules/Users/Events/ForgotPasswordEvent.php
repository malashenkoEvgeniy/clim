<?php

namespace App\Modules\Users\Events;

/**
 * Class ForgotPasswordEvent
 *
 * @package App\Modules\Users\Events
 */
class ForgotPasswordEvent
{
    /**
     * @var string
     */
    public $token;
    
    /**
     * @var string
     */
    public $email;
    
    /**
     * Create a new event instance.
     *
     * @param string $email
     * @param string $token
     * @return void
     */
    public function __construct(string $email, string $token)
    {
        $this->email = $email;
        $this->token = $token;
    }
}