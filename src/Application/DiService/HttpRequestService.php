<?php

namespace Application\DiService;

use Application\Di\Di;
use Application\Di\DiService;
use Symfony\Component\HttpFoundation\Request;

class HttpRequestService implements DiService
{
    /**
     * @param Di $diImpl
     * @return mixed
     */
    public function getService(Di $diImpl)
    {
        return Request::createFromGlobals();
    }

    /**
     * @return bool
     */
    public function isShared()
    {
        return true;
    }
}
