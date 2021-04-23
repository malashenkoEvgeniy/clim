<?php

namespace App\Core\Modules\Notifications\Listeners;

use App\Core\Interfaces\ListenerInterface;
use App\Core\Modules\Notifications\Models\Notification;

class ErrorListener implements ListenerInterface
{
    
    const NOTIFICATION_TYPE = 'error';
    
    const NOTIFICATION_ICON = 'fa fa-warning';
    
    public static function listens(): string
    {
        return 'notification.error';
    }
    
    public function handle(string $message, ?string $route = null, array $routeParameters = [])
    {
        Notification::send(
            static::NOTIFICATION_TYPE,
            $message,
            $route,
            $routeParameters
        );
    }
    
}