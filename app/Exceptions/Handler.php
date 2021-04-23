<?php

namespace App\Exceptions;

use App\Core\AjaxTrait;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    use AjaxTrait;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param Exception $exception
     * @return mixed|void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param Exception $exception
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception)
    {
        if ($request->expectsJson()) {
            if ($exception instanceof ValidationException) {
                $errors = $exception->errors();
                $firstError = array_shift($errors);
                $firstError = array_shift($firstError);
                return $this->errorJsonAnswer([
                    'notyMessage' => $firstError,
                ]);
            } elseif($exception->getMessage()) {
                return $this->errorJsonAnswer([
                    'console' => $exception->getMessage(),
                ]);
            }
        }
        return parent::render($request, $exception);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param AuthenticationException $exception
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        $guards = $exception->guards();
        if (count($guards) > 0) {
            $guard = array_shift($guards);
            if ($guard === 'admin') {
                $url = route('admin.login');
            }
        }
        return $request->expectsJson()
            ? response()->json(['console' => $exception->getMessage()], 401)
            : redirect()->guest($url ?? route('site.login'));
    }

    protected function renderHttpException(HttpException $e)
    {
        $this->registerErrorViewPaths();

        $view = $this->getViewName();
        if (view()->exists($view)) {
            return response()->view($view, [
                'errors' => new ViewErrorBag(),
                'exception' => $e,
            ], $e->getStatusCode(), $e->getHeaders());
        }

        return $this->convertExceptionToResponse($e);
    }

    protected function getViewName()
    {
        if (config('app.place') === 'admin') {
            return "errors.admin.basic";
        }
        return "errors::basic";
    }
}
