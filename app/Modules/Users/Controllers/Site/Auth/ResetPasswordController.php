<?php

namespace App\Modules\Users\Controllers\Site\Auth;

use App\Core\AjaxTrait;
use App\Core\SiteController;
use App\Modules\Users\Models\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class ResetPasswordController extends SiteController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */
    
    use ResetsPasswords, AjaxTrait;
    
    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';
    
    public function showResetForm(Request $request, $token = null)
    {
        $this->sameMeta('users::site.seo.reset-password');
        $this->breadcrumb('users::site.seo.reset-password');
        $formId = uniqid('form-reset-password');
        $validation = \JsValidator::make(
            $this->rules(),
            $this->validationErrorMessages(),
            [],
            "#$formId"
        );
        return view('users::site.reset-password')->with([
            'token' => $token,
            'email' => $request->input('email'),
            'formId' => $formId,
            'validation' => $validation,
        ]);
    }
    
    public function reset(Request $request)
    {
        $validator = \Validator::make($request->all(), $this->rules(), $this->validationErrorMessages());
        if ($validator->errors()->count() > 0) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                    'captcha' => true,
                ]);
            }
        }
        
        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset($this->credentials($request), function ($user, $password) {
            $this->resetPassword($user, $password);
        });
        
        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
            ? $this->sendResetResponse($response)
            : $this->sendResetFailedResponse($response);
    }
    
    /**
     * @param User $user
     * @param $password
     * @throws \Throwable
     */
    protected function resetPassword(User $user, $password)
    {
        $user->updatePassword($password);
        event(new PasswordReset($user));
        $this->guard()->login($user);
    }
    
    /**
     * @param $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function sendResetResponse($response)
    {
        return redirect()->route('site.home');
    }
    
    /**
     * @param $response
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendResetFailedResponse($response)
    {
        return response()->json([
            'success' => false,
            'message' => trans($response),
        ]);
    }
}
