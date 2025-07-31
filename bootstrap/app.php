<?php


use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php'
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->validateCsrfTokens(except: [
            'oauth/*',
        ]);
        $middleware->api(append: [
            Illuminate\Routing\Middleware\SubstituteBindings::class,
            //AuthenticationMiddleware::class
        ]);
        $middleware->alias([
            'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
            'auth.basic' => AuthenticateWithBasicAuth::class,
            'cache.headers' => SetCacheHeaders::class,
            'can' => Authorize::class,
            'throttle' => ThrottleRequests::class,
            'verified' => EnsureEmailIsVerified::class,
            //'authenticate' => AuthenticationMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Exception $exception, Request $request) {
            $status = 500;
            if ($exception instanceof AuthorizationException)
                $status = 403;
            if ($exception instanceof AuthenticationException)
                $status = 401;
            if ($exception instanceof ValidationException) {
                return response()->json([
                    'message' => 'خطا در اعتبارسنجی ورودی‌ها',
                    'errors'  => $exception->errors(),
                ], 422, [], JSON_UNESCAPED_UNICODE);
            }
            if ($exception instanceof MethodNotAllowedHttpException)
                $status = 405;
            if ($exception instanceof NotFoundHttpException)
                $status = 404;
            if ($exception instanceof BadRequestHttpException)
                $status = 400;
            if ($exception instanceof HttpException)
                $status = $exception->getStatusCode();


            $extra_output = [];
            if (app()->hasDebugModeEnabled())
                $extra_output = [
                    'exception' => get_class($exception),
                    'line' => $exception->getFile() . ':' . $exception->getLine(),
                    'trace' => $exception->getTraceAsString()
                ];
            return response()->json(array_merge([
                'message' => $exception->getMessage(),
                'status' => $status
            ], $extra_output), $status);
        });
    })->create();
