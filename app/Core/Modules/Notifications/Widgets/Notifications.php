<?php

namespace App\Core\Modules\Notifications\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Core\Modules\Notifications\Models\Notification;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class TopUserMenu
 * Menu on the top of the page in admin panel
 *
 * @package App\Modules\Auth\Widgets\Admin
 */
class Notifications implements AbstractWidget
{

    public function render()
    {
        /** @var Notification[]|Collection $notifications */
        $notifications = Notification::getListForWidget();
        return view(
            'notifications::widgets.notifications', [
                'total' => $notifications->count(),
                'notifications' => $notifications->take(config('db.notifications.per-page-in-widget', 10)),
            ]
        );
    }

}

