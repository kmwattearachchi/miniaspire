<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {

        //return parent::render($request, $exception);

        if ($exception->getMessage() == 'You are not authorized to access this resource.') {
            return response()->json(['error' =>'You are not authorized to access this resource.']);
        }

        if ($exception instanceof NotFoundHttpException)
        {
            return response()->json(['error' =>'Url not found']);
        }

        if ($exception instanceof MethodNotAllowedHttpException)
        {
            return response()->json(['error' =>'Invalid request']);
        }

        if ($exception instanceof QueryException)
        {
            return response()->json(['error' =>'Database issue occurd!']);
        }

    }
}
