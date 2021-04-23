<?php

namespace App\Core\Modules\Mail\Controllers\Admin;

use App\Core\ObjectValues\RouteObjectValue;
use App\Core\Modules\Mail\Forms\MailTemplateForm;
use App\Core\Modules\Mail\Models\MailTemplate;
use App\Core\Modules\Mail\Requests\MailTemplateRequest;
use Seo;
use App\Core\AdminController;

/**
 * Class NewsController
 *
 * @package App\Modules\News\Controllers\Admin
 */
class MailTemplatesController extends AdminController
{
    
    public function __construct()
    {
        Seo::breadcrumbs()->add(
            'mail_templates::seo.index',
            RouteObjectValue::make('admin.mail_templates.index')
        );
    }
    
    /**
     * News sortable list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // Set h1
        Seo::meta()->setH1('mail_templates::seo.index');
        // Get news
        $mailTemplates = MailTemplate::getList();
        // Return view list
        return view('mail_templates::index', ['templates' => $mailTemplates]);
    }
    
    /**
     * Update element page
     *
     * @param MailTemplate $mailTemplate
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(MailTemplate $mailTemplate)
    {
        $templateName = __($mailTemplate->name);
        // Breadcrumb
        Seo::breadcrumbs()->add($templateName);
        // Set h1
        Seo::meta()->setH1(__('mail_templates::seo.edit', ['template' => $templateName]));
        // Javascript validation
        $this->initValidation((new MailTemplateRequest)->rules());
        // Return form view
        return view(
            'mail_templates::update', [
                'form' => MailTemplateForm::make($mailTemplate),
            ]
        );
    }
    
    /**
     * Update page in database
     *
     * @param  MailTemplateRequest $request
     * @param  MailTemplate $mailTemplate
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(MailTemplateRequest $request, MailTemplate $mailTemplate)
    {
        // Update existed news
        if ($message = $mailTemplate->updateRow($request)) {
            return $this->afterFail($message);
        }
        // Do something
        return $this->afterUpdate();
    }
    
}
