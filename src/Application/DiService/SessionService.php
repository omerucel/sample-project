<?php

namespace Application\DiService;

use Application\Di\Di;
use Application\Di\DiService;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

class SessionService implements DiService
{
    /**
     * @param Di $diImpl
     * @return mixed
     */
    public function getService(Di $diImpl)
    {
        $configs = $diImpl->get('config');
        $handler = new PdoSessionHandler($diImpl->get('pdo'), [
            'db_table' => 'session',
            'db_id_col' => 'session_id',
            'db_data_col' => 'session_value',
            'db_time_col' => 'session_time'
        ]);
        $storage = new NativeSessionStorage($configs->session->storage->toArray(), $handler);
        $session = new Session($storage);
        $session->start();
        return $session;
    }

    /**
     * @return bool
     */
    public function isShared()
    {
        return true;
    }
}
