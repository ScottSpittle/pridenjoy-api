<?php

namespace App\Exceptions\Handlers;

use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class MethodNotAllowedHandler extends BaseHandler
{
    /**
     * Handle the exception.
     *
     * @return mixed
     */
    public function handle()
    {
        return response()->json([
            'errors' => [
                'status' => $this->exception->getStatusCode(),
                'title' => $this->exception->getMessage() ?: "Invalid HTTP method",
            ],
        ], $this->exception->getStatusCode());
    }

    /**
     * @inheritDoc
     */
    protected function isCatchable()
    {
        return $this->exception instanceof MethodNotAllowedHttpException;
    }
}
