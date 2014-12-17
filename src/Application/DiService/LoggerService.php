<?php

namespace Application\DiService;

use Application\Di\Di;
use Application\Di\DiService;
use Application\Logger\MonologLineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class LoggerService implements DiService
{
    /**
     * @param Di $diImpl
     * @return mixed
     */
    public function getService(Di $diImpl)
    {
        $config = $diImpl->get('config');
        $logFile = $config->logger->path . '/' . $config->environment . '-' . $config->logger->name
            . '-' . date('Y-m-d') . '.log';
        $monolog = new Logger($config->logger->name);
        $fileStream = new StreamHandler($logFile, $config->logger->level, true, 0666);
        $lineFormatter = new MonologLineFormatter(
            $config->logger->line_format,
            $config->logger->datetime_format
        );
        $lineFormatter->setReqId($config->req_id);
        $fileStream->setFormatter($lineFormatter);
        $monolog->pushHandler($fileStream);
        return $monolog;
    }

    /**
     * @return bool
     */
    public function isShared()
    {
        return true;
    }
}
