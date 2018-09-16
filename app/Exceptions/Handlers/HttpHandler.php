<?php

namespace App\Exceptions\Handlers;

use Symfony\Component\HttpKernel\Exception\HttpException;

class HttpHandler extends BaseHandler
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
                'title' => $this->exception->getMessage(),
            ],
        ], $this->exception->getStatusCode());
    }

    /**
     * @inheritDoc
     */
    protected function isCatchable()
    {
        return $this->exception instanceof HttpException;
    }
}
