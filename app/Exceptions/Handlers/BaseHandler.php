<?php

namespace App\Exceptions\Handlers;

use Exception;

class BaseHandler
{
    /**
     * Application request object.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Application exception object.
     *
     * @var \Exception
     */
    protected $exception;

    /**
     * Base Handler constructor.
     *
     * @param \Illuminate\Http\Request
     * @param \Exception
     */
    public function __construct($request, Exception $e)
    {
        $this->request = $request;
        $this->exception = $e;
    }

    /**
     * Render exception.
     *
     * @return mixed
     */
    public function render()
    {
        if ($this->isCatchable()) {
            return $this->handle();
        }

        return false;
    }

    /**
     * Check if the exception is catchable by this handler.
     *
     * @return boolean
     */
    protected function isCatchable()
    {
        return false;
    }

    /**
     * Check if the request is an API request.
     *
     * @return boolean
     */
    protected function isApiRequest()
    {
        return app('request')->ajax() || app('request')->is('api/*');
    }
}
