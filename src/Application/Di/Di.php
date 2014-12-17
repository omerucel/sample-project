<?php

namespace Application\Di;

interface Di
{
    /**
     * @param $namespace
     * @return mixed
     */
    public function setServiceNamespace($namespace);

    /**
     * @param $name
     * @param bool $reloadShared
     * @return mixed
     */
    public function get($name, $reloadShared = false);

    /**
     * @param $name
     * @return mixed
     */
    public function reloadShared($name);

    /**
     * @param $name
     * @param $value
     * @param $isShared
     * @return mixed
     */
    public function set($name, $value, $isShared = false);
}
