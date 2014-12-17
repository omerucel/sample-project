<?php

namespace Application\DiService;

use Application\Di\Di;
use Application\Di\DiService;
use Zend\Config\Config;

class ConfigService implements DiService
{
    /**
     * @param Di $diImpl
     * @return mixed
     */
    public function getService(Di $diImpl)
    {
        $environment = $diImpl->get('environment');
        $configPath = realpath(__DIR__ . '/../../../configs/') . '/env/' . $environment . '.php';
        $config = new Config(include($configPath), true);
        $config->environment = $environment;
        return $config;
    }

    /**
     * @return bool
     */
    public function isShared()
    {
        return true;
    }
}
