<?php

namespace Application\Web;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Zend\Config\Config;

class FatalErrorCallbackHandler extends \Application\FatalErrorCallbackHandler
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
     * @param $message
     */
    public function handle($message)
    {
        parent::handle($message);
        $url = $this->config->site_base_url . '500.html';
        $response = new RedirectResponse($url);
        $response->send();
    }
}
