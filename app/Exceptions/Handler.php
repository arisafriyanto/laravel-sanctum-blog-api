<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // Mengembalikan respons JSON saat token tidak ada atau tidak valid
        return response()->json([
            'status' => false,
            'errors' => 'Unauthorized'
        ], 401);
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            // Mendapatkan nama model dari exception
            $modelName = class_basename($exception->getModel());

            return response()->json([
                'status' => false,
                'errors' => "$modelName not found",
            ], 404);
        }

        return parent::render($request, $exception);
    }
}
