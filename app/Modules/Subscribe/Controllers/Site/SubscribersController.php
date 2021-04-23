<?php

namespace App\Modules\Subscribe\Controllers\Site;

use App\Core\AjaxTrait;
use Event;
use App\Core\SiteController;
use App\Modules\Subscribe\Events\NewSubscriberEvent;
use App\Modules\Subscribe\Models\Subscriber;
use App\Modules\Subscribe\Requests\SiteSubscriberRequest;

/**
 * Class SubscribersController
 *
 * @package App\Modules\Subscribe\Controllers\Site
 */
class SubscribersController extends SiteController
{
    use AjaxTrait;

    /**
     * @param SiteSubscriberRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function send(SiteSubscriberRequest $request)
    {
        try {
            if (Subscriber::registration()) {
                Event::fire(new NewSubscriberEvent($request->input('email')));
            }
            return $this->successJsonAnswer([
                'replaceForm' => view('subscribe::site.message')->render(),
            ]);
        } catch (\Exception $exception) {
            return $this->errorJsonAnswer([
                'notyMessage' => __('subscribe::general.message-false'),
                'description' => $exception->getMessage(),
            ]);
        }
    }

}
