<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;
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

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $e
     * @return Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $e): Response
    {
        if ($e instanceof ModelNotFoundException && $request->expectsJson()) {
            return response()->json(
                $this->convertExceptionToArray($e, Response::HTTP_NOT_FOUND),
                Response::HTTP_NOT_FOUND
            );
        }

        return parent::render($request, $e);
    }

    /**
     * Convert the given exception to an array.
     *
     * @param Throwable $e
     * @param int $code
     * @return array
     */
    protected function convertExceptionToArray(Throwable $e, int $code = Response::HTTP_INTERNAL_SERVER_ERROR): array
    {
        return config('app.debug') ? [
            'code'    => $code,
            'message' => trans($e->getMessage()),
            'data'    => [
                'message'   => $e->getMessage(),
                'exception' => get_class($e),
                'file'      => $e->getFile(),
                'line'      => $e->getLine(),
                'trace'     => collect($e->getTrace())->map(fn($trace) => Arr::except($trace, ['args']))->all(),
            ],

        ] : [
            'code'    => $e->getCode() ?: $code,
            'message' => $this->isHttpException($e) ? trans($e->getMessage()) : trans('Internal Server Error'),
            'data'    => new \stdClass(),
        ];
    }
}
