<?php

namespace Application\DiService;

use Application\Di\Di;
use Application\Di\DiService;
use Application\ErrorCatcher;
use Application\Web\ExceptionCallbackHandler;
use Application\Web\FatalErrorCallbackHandler;

class WebErrorCatcherService implements DiService
{
    /**
     * @param Di $diImpl
     * @return mixed
     */
    public function getService(Di $diImpl)
    {
        $config = $diImpl->get('config');
        $errorCatcher = new ErrorCatcher();
        $exceptionHandler = new ExceptionCallbackHandler($diImpl->get('logger'), $config);
        $fatalErrorHandler = new FatalErrorCallbackHandler($diImpl->get('logger'), $config);
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
