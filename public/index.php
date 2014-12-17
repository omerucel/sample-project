<?php

$environment = strtolower(getenv('APPLICATION_ENV'));

// Check app_env setting.
if (!$environment) {
    throw new \Exception('APPLICATION_ENV : empty');
}

/**
 * @var \Application\Di\Di $diImpl
 */
$diImpl = include(realpath(__DIR__ . '/../') . '/configs/bootstrap.php');
$diImpl->get('web_error_catcher')->register();
$diImpl->get('dispatcher')->dispatch(
    $diImpl->get('config')->web_application->default_controller,
    $diImpl->get('config')->web_application->routes->toArray()
);
