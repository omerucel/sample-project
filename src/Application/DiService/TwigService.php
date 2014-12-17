<?php

namespace Application\DiService;

use Application\Di\Di;
use Application\Di\DiService;
use Application\Twig\TwigEnvironmentFactory;

class TwigService implements DiService
{
    /**
     * @param Di $diImpl
     * @return mixed
     */
    public function getService(Di $diImpl)
    {
        $httpRequest = $diImpl->get('http_request');
        $config = $diImpl->get('config');
        $translator = $diImpl->get('translator');
        $twigFactory = new TwigEnvironmentFactory($config, $translator, $httpRequest);
        return $twigFactory->factory();
    }

    /**
     * @return bool
     */
    public function isShared()
    {
        return true;
    }
}
