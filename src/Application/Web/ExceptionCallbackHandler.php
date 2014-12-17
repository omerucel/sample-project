<?php

namespace Application\Web;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Zend\Config\Config;

class ExceptionCallbackHandler extends \Application\ExceptionCallbackHandler
{
    /**
     * @var \Zend\Config\Config
     */
    protected $config;

    /**
     * @param LoggerInterface $logger
     * @param Config $config
     */
    public function __construct(LoggerInterface $logger, Config $config)
    {
        parent::__construct($logger);
        $this->config = $config;
    }

    /**
     * @param \Exception $exception
     */
    public function handle(\Exception $exception)
    {
        parent::handle($exception);
        $url = $this->config->site_base_url . '500.html';
        $response = new RedirectResponse($url);
        $response->send();
    }
}
