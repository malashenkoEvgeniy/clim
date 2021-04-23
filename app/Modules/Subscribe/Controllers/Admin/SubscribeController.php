<?php

namespace App\Modules\Subscribe\Controllers\Admin;

use App\Components\Mailer\MailSender;
use App\Core\AdminController;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Subscribe\Filters\SubscribeHistoryFilter;
use App\Modules\Subscribe\Forms\AdminMailingForm;
use App\Modules\Subscribe\Models\Subscriber;
use App\Modules\Subscribe\Models\SubscriberMails;
use App\Modules\Subscribe\Requests\AdminSubscriberMailsRequest;
use Seo;

/**
 * Class SubscribersController
 *
 * @package App\Modules\Subscribe\Controllers\Admin
 */
class SubscribeController extends AdminController
{
    public function __construct()
    {
        Seo::breadcrumbs()->add('subscribe::seo.subscribe.history', RouteObjectValue::make('admin.subscribe.history'));
    }

    /**
     * Subscribe mechanism list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function history()
    {
        // Set h1
        Seo::meta()->setH1('subscribe::seo.subscribe.history');
        // Get subscribe
        $mails = SubscriberMails::getList();
        // Return view list
        return view('subscribe::admin.mailing.history', [
            'mails' => $mails,
            'filter' => SubscribeHistoryFilter::showFilter()
        ]);
    }
    
    /**
     * Mailing page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function mailing()
    {
        Seo::breadcrumbs()->add('subscribe::seo.subscribe.mailing');
        // Set h1
        Seo::meta()->setH1('subscribe::seo.subscribe.mailing');
        // Validation
        $this->initValidation((new AdminSubscriberMailsRequest)->rules());
        // Return view list
        return view('subscribe::admin.mailing.index', [
            'form' => AdminMailingForm::make(),
        ]);
    }
    
    /**
     * Send mails
     *
     * @param AdminSubscriberMailsRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \App\Exceptions\WrongParametersException
     */
    public function send(AdminSubscriberMailsRequest $request)
    {
        $recipients = Subscriber::getRecipients();
        MailSender::sendMany(
            $recipients,
            $request->input('subject'),
            $request->input('text')
        );
        // Save to the database
        SubscriberMails::stat($request, count($recipients));
        // Do something
        return $this->afterStore();
    }
}
