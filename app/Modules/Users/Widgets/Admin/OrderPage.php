<?php

namespace App\Modules\Users\Widgets\Admin;

use App\Components\Widget\AbstractWidget;
use App\Modules\Users\Models\User;
use Auth;

/**
 * Class OrderPage
 *
 * @package App\Modules\Users\Widgets\Admin
 */
class OrderPage implements AbstractWidget
{
    
    protected $userId;
    
    public function __construct(?int $userId)
    {
        $this->userId = $userId;
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     *
     * TODO role rules check
     */
    public function render()
    {
        if (!$this->userId) {
            return null;
        }
        $user = User::withTrashed()->whereId($this->userId)->first();
        if (!$user) {
            return null;
        }
        return view('users::admin.order-page', [
            'user' => $user,
        ]);
    }
    
}
