<?php

namespace Application\DiService;

use Application\Di\Di;
use Application\Di\DiService;
use Application\ErrorCatcher;
use Application\ExceptionCallbackHandler;
use Application\FatalErrorCallbackHandler;

class ErrorCatcherService implements DiService
{
    /**
     * @param Di $diImpl
     * @return mixed
     */
    public function getService(Di $diImpl)
    {
        $errorCatcher = new ErrorCatcher();
        $exceptionHandler = new ExceptionCallbackHandler($diImpl->get('logger'));
        $fatalErrorHandler = new FatalErrorCallbackHandler($diImpl->get('logger'));
        $errorCatcher->setExceptionCallback([$exceptionHandler, 'handle']);
        $errorCatcher->setFatalCallback([$fatalErrorHandler, 'handle']);
        return $errorCatcher;
    }

    /**
     * @return bool
     */
    public function isShared()
    {
        return true;
    }
}
