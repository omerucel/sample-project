<?php

namespace Application;

use Psr\Log\LoggerInterface;

class FatalErrorCallbackHandler
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param $message
     */
    public function handle($message)
    {
        $this->logger->emergency($message);
    }
}
