<?php

namespace Application\DiService;

use Application\Di\Di;
use Application\Di\DiService;
use Symfony\Component\HttpFoundation\Response;

class HttpResponseService implements DiService
{
    /**
     * @param Di $diImpl
     * @return mixed
     */
    public function getService(Di $diImpl)
    {
        return new Response();
    }

    /**
     * @return bool
     */
    public function isShared()
    {
        return true;
    }
}
