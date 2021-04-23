<?php

namespace App\Modules\Users\Controllers\Site\Auth;

use App\Core\AjaxTrait;
use App\Core\SiteController;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

/**
 * Class ForgotPasswordController
 *
 * @package App\Modules\Users\Controllers\Site\Auth
 */
class ForgotPasswordController extends SiteController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    
    use SendsPasswordResetEmails, AjaxTrait;
    
    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        $this->sameMeta('users::site.seo.forgot-password');
        $this->breadcrumb('users::site.seo.forgot-password');
        return view('users::site.forgot-password');
    }
    
    /**
     * Get the response for a successful password reset link.
     *
     * @param Request $request
     * @param $response
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        if ($request->expectsJson()) {
            return $this->successMfpMessage(trans($response));
        }
        return back()->with('status', trans($response));
    }
    
    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        if ($request->expectsJson()) {
            return $this->errorJsonAnswer([
                'notyMessage' => trans($response),
            ]);
        }
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);
    }
    
}
