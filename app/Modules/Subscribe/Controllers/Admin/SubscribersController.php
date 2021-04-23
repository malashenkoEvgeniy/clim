<?php

namespace App\Modules\Subscribe\Controllers\Admin;

use App\Core\AdminController;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Subscribe\Filters\SubscribeFilter;
use App\Modules\Subscribe\Forms\AdminMailingForm;
use App\Modules\Subscribe\Forms\AdminSubscriberForm;
use App\Modules\Subscribe\Models\Subscriber;
use App\Modules\Subscribe\Models\SubscriberMails;
use App\Modules\Subscribe\Requests\AdminSubscriberMailsRequest;
use App\Modules\Subscribe\Requests\AdminSubscriberRequest;
use Illuminate\Http\Request;
use Seo;

/**
 * Class SubscribersController
 *
 * @package App\Modules\Subscribe\Controllers\Admin
 */
class SubscribersController extends AdminController
{
    public function __construct()
    {
        Seo::breadcrumbs()->add('subscribe::seo.subscribers.index', RouteObjectValue::make('admin.subscribers.index'));
    }
    
    /**
     * Register widgets with buttons
     */
    private function registerButtons()
    {
        // Create new subscriber button
        $this->addCreateButton('admin.subscribers.create');
    }

    /**
     * Subscriber sortable list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function index()
    {
        // Set page buttons on the top of the page
        $this->registerButtons();
        // Set h1
        Seo::meta()->setH1('subscribe::seo.subscribers.index');
        // Get subscribe
        $subscribers = Subscriber::getList();
        // Return view list
        return view('subscribe::admin.subscribers.index', [
            'subscribers' => $subscribers,
            'filter' => SubscribeFilter::showFilter(),
        ]);
    }
    
    /**
     * Create new element page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function create()
    {
        // Breadcrumb
        Seo::breadcrumbs()->add('subscribe::seo.subscribers.create');
        // Set h1
        Seo::meta()->setH1('subscribe::seo.subscribers.create');
        // Javascript validation
        $this->initValidation((new AdminSubscriberRequest())->rules());
        // Return form view
        return view(
            'subscribe::admin.subscribers.create', [
                'form' => AdminSubscriberForm::make(),
            ]
        );
    }
    
    /**
     * Create page in database
     *
     * @param  AdminSubscriberRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function store(AdminSubscriberRequest $request)
    {
        $subscriber = new Subscriber();
        // Fill new data
        $subscriber->createByAdmin();
        // Do something
        return $this->afterStore(['id' => $subscriber->id]);
    }
    
    /**
     * Update element page
     *
     * @param  Subscriber $subscriber
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(Subscriber $subscriber)
    {
        // Breadcrumb
        Seo::breadcrumbs()->add($subscriber->email ?? 'subscribe::seo.subscribers.edit');
        // Set h1
        Seo::meta()->setH1('subscribe::seo.subscribers.edit');
        // Javascript validation
        $this->initValidation((new AdminSubscriberRequest)->rules());
        // Return form view
        return view(
            'subscribe::admin.subscribers.update', [
                'form' => AdminSubscriberForm::make($subscriber),
            ]
        );
    }
    
    /**
     * Update page in database
     *
     * @param  AdminSubscriberRequest $request
     * @param  Subscriber $subscriber
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(AdminSubscriberRequest $request, Subscriber $subscriber)
    {
        // Fill new data
        $subscriber->updateByAdmin();
        // Do something
        return $this->afterUpdate();
    }
    
    /**
     * Totally delete page from database
     *
     * @param  Subscriber $subscriber
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function destroy(Subscriber $subscriber)
    {
        // Delete subscribe
        $subscriber->delete();
        // Do something
        return $this->afterDestroy();
    }
}
