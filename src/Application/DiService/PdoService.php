<?php

namespace Application\DiService;

use Application\Di\Di;
use Application\Di\DiService;

class PdoService implements DiService
{
    /**
     * @param Di $diImpl
     * @return mixed
     */
    public function getService(Di $diImpl)
    {
        $config = $diImpl->get('config');
        $pdo = new \PDO($config->pdo->dsn, $config->pdo->username, $config->pdo->password);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    /**
     * @return bool
     */
    public function isShared()
    {
        return true;
    }
}
