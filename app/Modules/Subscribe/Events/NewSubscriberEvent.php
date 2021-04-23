<?php

namespace App\Modules\Subscribe\Events;

/**
 * Class NewSubscriberEvent
 *
 * @package App\Modules\Subscribe\Events
 */
class NewSubscriberEvent
{
    /**
     * @var string
     */
    public $email;
    
    /**
     * Create a new event instance.
     *
     * @param string $email
     * @return void
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }
}