<?php

$di = include(realpath(__DIR__ . '/../') . '/configs/bootstrap.php');
$di->getClassLoader()->add('Project\\', realpath(__DIR__ . '/unit/src/'));
$di->getClassLoader()->add('OU\\', realpath(__DIR__ . '/unit/src/'));
include_once(realpath(__DIR__) . '/DiSingleton.php');
\DiSingleton::getInstance()->setDi($di);
