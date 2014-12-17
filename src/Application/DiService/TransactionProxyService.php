<?php

namespace Application\DiService;

use Application\Di\Di;
use Application\Di\DiService;
use Application\Database\MySQL\TransactionProxyImpl;

class TransactionProxyService implements DiService
{
    /**
     * @param Di $diImpl
     * @return mixed
     */
    public function getService(Di $diImpl)
    {
        return new TransactionProxyImpl($diImpl->get('pdo'));
    }

    /**
     * @return bool
     */
    public function isShared()
    {
        return true;
    }
}