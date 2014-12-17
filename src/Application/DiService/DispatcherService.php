<?php

namespace Application\DiService;

use Application\Di\Di;
use Application\Di\DiService;
use Application\Router\Dispatcher;

class DispatcherService implements DiService
{
    /**
     * @param Di $diImpl
     * @return mixed
     */
    public function getService(Di $diImpl)
    {
        return new Dispatcher($diImpl);
    }

    /**
     * @return bool
     */
    public function isShared()
    {
        return true;
    }
}
