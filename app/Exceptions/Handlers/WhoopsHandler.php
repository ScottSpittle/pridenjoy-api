<?php

namespace App\Exceptions\Handlers;

use Whoops\Run;
use ErrorException;
use Whoops\Handler\PrettyPageHandler;
use Symfony\Component\Debug\Exception\FatalThrowableError;

class WhoopsHandler extends BaseHandler
{
    /**
     * Handle the exception.
     *
     * @return mixed
     */
    public function handle()
    {
        $whoops = new Run;
        $whoops->pushHandler(new PrettyPageHandler);
        return $whoops->handleException($this->exception);
    }

    /**
     * @inheritDoc
     */
    protected function isCatchable()
    {
        return app('config')->get('app.debug') && (! $this->isApiRequest() || $this->isFatalError());
    }

    /**
     * Check if the exception is a fatal error.
     *
     * @return boolean
     */
    private function isFatalError()
    {
        if (! method_exists($this->exception, 'getStatusCode')) {
            return true;
        }

        if ($this->exception->getStatusCode() >= 500) {
            return true;
        }

        return false;
    }
}
