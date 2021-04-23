<?php

namespace App\Modules\Callback\Controllers\Site;

use App\Core\AjaxTrait;
use App\Core\SiteController;
use App\Modules\Callback\Models\Callback;
use App\Modules\Callback\Requests\SiteCallbackRequest;

/**
 * Class CallbackController
 *
 * @package App\Modules\Callback\Controllers\Admin
 */
class CallbackController extends SiteController
{
    use AjaxTrait;
    
    /**
     * @param SiteCallbackRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function send(SiteCallbackRequest $request)
    {
        $callback = new Callback();
        $callback->fill($request->all());
        if ($callback->save()) {
            event('callback::created', $callback);
            event('callback', $callback);
            return $this->successMfpMessage(trans('callback::general.message-success'), [
                'reset' =>true
            ]);
        }
        return $this->errorJsonAnswer([
            'notyMessage' => trans('callback::general.message-false'),
        ]);
    }
    
}
