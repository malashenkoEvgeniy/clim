<?php

namespace App\Core\Interfaces;

/**
 * Interface ListenerInterface
 *
 * @package App\Core\Interfaces
 */
interface ListenerInterface
{
    
    /**
     * Returns event name to listen
     *
     * @return string|array
     */
    public static function listens();
    
}