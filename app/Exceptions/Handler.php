<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Validation\ValidationException;
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
        // $this->reportable(function (Throwable $e) {
        //     //
        // });
        $this->renderable( function ( ValidationException $ex, $request ) {
            $response = [
                'ErrorCode' => 'my_error_code',
                'ErrorMessage' => $ex->validator->errors()
            ];

            return response()->json( $response );
        } );
    }

    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*')) {
            return $this->handleApiException($request, $exception);
        }else {
                if ($exception instanceof ModelNotFoundException) {
                    if ($request->wantsJson()) {
                        return response()->json([
                            'status' => 'error',
                            'error' => 'MODEL_NOT_FOUND',
                            'message' => 'The requested resource could not be found.',
                        ], 404);
                    }
                    return response()->view('errors.404', [], 404);
                }
                elseif ($exception instanceof ValidationException) {
                    return response()->json([
                        'status' => 'error',
                        'error' => $exception->getMessage(),
                        'message' => $exception->validator->errors()->all()[0]
                    ], 200);
                }
                // Prevent Method Not Allowed In Route
          //      if(App::isProduction())
                if($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException){
                    return redirect('/');
                }
                return parent::render($request, $exception);
        }
    }


    private function handleApiException($request, Throwable $exception)
    {
        $exception = $this->prepareException($exception);

        if ($exception instanceof \Illuminate\Http\Exception\HttpResponseException) {
            $exception = $exception->getResponse();
        } elseif ($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
            $message = $exception->getMessage();
        } elseif ($exception instanceof \Illuminate\Database\QueryException) {
            $message = $exception->getMessage();
            $sql = $exception->getSql();
            $bindings = $exception->getBindings();
        } elseif ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            $exception = $this->unauthenticated($request, $exception);
        } elseif ($exception instanceof \Illuminate\Validation\ValidationException) {
            $exception = $this->convertValidationExceptionToResponse($exception, $request);
        }

        return $this->customApiResponse($request, $exception);
    }
    private function customApiResponse($request,$exception)
    {
        if (method_exists($exception, 'getStatusCode')) {
            $statusCode = $exception->getStatusCode();
        } else {
            $statusCode = 500;
        }
        $response = [];

        switch ($statusCode) {
            case 401:
                $response['message'] = 'Unauthorized';
                break;
            case 403:
                $response['message'] = 'Forbidden';
                break;
            case 404:
                $response['message'] = 'Not Found';
                break;
            case 405:
                $response['message'] = 'Method Not Allowed';
                break;
            case 422:
                if ($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException){
                    $response['message'] = $exception->getMessage();
                    $response['errors'] = '';
                }else {
                    $response['message'] = isset($exception->original['message']) ? $exception->original['message'] : $exception->getMessage();
                    $response['errors'] = isset($exception->original['errors']) ? $exception->original['errors'] : '';
                }
                break;
            default:
                $response['message'] = ($statusCode == 500) ? 'Đã có lỗi xảy ra.' : $exception->getMessage();
                break;
        }
        if (config('app.debug')) {
            $response['trace'] = $exception->getTrace();
            $response['code'] = $exception->getCode();
            return parent::render($request, $exception);
        }
        $response['status'] = $statusCode;
        return response()->json($response, $statusCode);
    }
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

}
