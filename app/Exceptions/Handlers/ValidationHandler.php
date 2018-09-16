<?php

namespace App\Exceptions\Handlers;

use Illuminate\Validation\ValidationException;

class ValidationHandler extends BaseHandler
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
                'status' => 422,
                'title' => $this->exception->getMessage(),
                'detail' => $this->exception->validator->getMessageBag(),
            ],
        ], 422);
    }

    /**
     * @inheritDoc
     */
    protected function isCatchable()
    {
        return $this->exception instanceof ValidationException;
    }
}
