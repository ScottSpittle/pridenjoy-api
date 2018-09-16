<?php

use App\Exceptions\Handlers;
use Illuminate\Validation;
use Symfony\Component\HttpKernel\Exception;

/*
    |--------------------------------------------------------------------------
    | Exception Handlers
    |--------------------------------------------------------------------------
    |
    | Here we register the execption with their handlers. These exceptions will
    | be handled by the their respective handlers and execute the handle method
    | if the isCatchable method returns true.
    |
    */

return [
    Validation\ValidationException::class
        => Handlers\ValidationHandler::class,

    Exception\UnauthorizedHttpException::class
        => Handlers\UnauthorizedHandler::class,

    Exception\MethodNotAllowedHttpException::class
        => Handlers\MethodNotAllowedHandler::class,

    Exception\HttpException::class
        => Handlers\HttpHandler::class,

    "*" => Handlers\WhoopsHandler::class,
];
