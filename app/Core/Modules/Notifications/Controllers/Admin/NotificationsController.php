<?php

namespace App\Core\Modules\Notifications\Controllers\Admin;

use App\Core\AdminController;
use App\Core\ObjectValues\RouteObjectValue;
use App\Core\Modules\Notifications\Models\Notification;
use App\Core\Modules\Notifications\Filters\NotificationsFilter;
use Seo;

/**
 * Class NotificationsController
 *
 * @package App\Modules\Notifications\Controllers\Admin
 */
class NotificationsController extends AdminController
{
    
    public function __construct()
    {
        Seo::breadcrumbs()->add('notifications::seo.index', RouteObjectValue::make('admin.notifications.index'));
    }

    /**
     * Notifications sortable list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function index()
    {
        // Set h1
        Seo::meta()->setH1('notifications::seo.index');
        // Get fastOrders
        $notifications = Notification::getList();
        // Return view list
        return view('notifications::admin.index', [
            'notifications' => $notifications,
            'filter' => NotificationsFilter::showFilter(),
        ]);
    }
}
