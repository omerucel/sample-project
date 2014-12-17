<?php

namespace Application;

use Psr\Log\LoggerInterface;

class ExceptionCallbackHandler
{
    /**
     * @var LoggerInterface
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
     * @param \Exception $exception
     */
    public function handle(\Exception $exception)
    {
        $this->logger->error($exception);
    }
}
