<?php

namespace OU\MySQL;

use OU\DI;
use OU\MicroTimer;

class SQLProfiler
{
    /**
     * @var DI
     */
    protected $di;

    /**
     * @var MicroTimer
     */
    protected $timer;

    /**
     * @param DI $di
     */
    protected function __construct(DI $di)
    {
        $this->di = $di;
    }

    /**
     * @param $sql
     * @param $params
     */
    public function startProfile($sql, array $params)
    {
        $this->timer = new MicroTimer();
    }

    public function endProfile($sql, array $params)
    {
        $this->getLogger()->debug($sql . ' executed in ' . $this->timer . ' seconds.', ['SQL_PARAMS' => $params]);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    protected function getLogger()
    {
        return $this->di->get('logger_helper')->getLogger('sql');
    }
}
