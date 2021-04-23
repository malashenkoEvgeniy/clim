<?php

namespace App\Modules\Users\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\Users\Models\User;

/**
 * Class UserAccountLeftSidebar
 *
 * @package App\Modules\Users\Widgets
 */
class ShortUserInformation implements AbstractWidget
{
    
    protected $user;
    
    public function __construct(?User $user)
    {
        $this->user = $user;
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if (!$this->user) {
            return null;
        }
        return view('users::admin.short-user-information', [
            'user' => $this->user,
        ]);
    }
    
}
