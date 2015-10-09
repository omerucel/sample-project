<?php

$environment = strtolower(getenv('APPLICATION_ENV'));

// Check app_env setting.
if (!$environment) {
    echo 'Please check your project configuration!';
    exit;
}

/**
 * @var \OU\DI $di
 */
$di = require_once (realpath(__DIR__ . '/../configs/bootstrap.php'));
$di->get('error_catcher')->register();

ToroHook::add('404', function ($params) use ($di) {
    $method = $params['request_method'];
    $controller = new \Project\WebController\NotFoundController($di);
    $controller->{$method}();
});

Toro::serve([
    '/' => function () use ($di) {
        return new \Project\WebController\Homepage($di);
    }
]);
