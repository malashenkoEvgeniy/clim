<?php

namespace App\Core\Modules\Notifications\Listeners;

use App\Core\Interfaces\ListenerInterface;
use App\Core\Modules\Notifications\Models\Notification;
use App\Core\ObjectValues\RouteObjectValue;

class SuccessListener implements ListenerInterface
{
    
    public static function listens(): string
    {
        return 'notify-admin';
    }
    
    public function handle(string $message, string $type = 'info', RouteObjectValue $route)
    {
        Notification::send(
            $type,
            $message,
            $route->getRouteName(),
            $route->getRouteParameters()
        );
    }
    
}