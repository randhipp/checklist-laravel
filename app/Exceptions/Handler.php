<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException or $e instanceof NotFoundHttpException) {
            return response()->json([
                'status' => "404",
                'error' => "Not Found"
            ], 404);
        }

        if ($e instanceof ErrorException) {
            return response()->json([
                'status' => "500",
                'error' => "Server Error"
            ], 500);
        }

        if($e instanceof \Illuminate\Auth\AuthenticationException ){
            return response()->json([
                'status' => "401",
                'error' => "Not Authorized"
            ], 401);
        }

        return parent::render($request, $e);
    }

}
