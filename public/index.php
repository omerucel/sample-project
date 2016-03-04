<?php

$environment = strtolower(getenv('APPLICATION_ENV'));
if (!$environment) {
    echo 'Please check your project configuration!';
    exit;
}

/**
 * @var \OU\DI $di
 */
$di = require_once(realpath(__DIR__ . '/../') . '/configs/bootstrap.php');
$dispatcher = $di->get('dispatcher');
$dispatcher->dispatch();
