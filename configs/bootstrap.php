<?php

// For unexpected errors.
error_reporting(E_ALL);
ini_set('error_log', realpath(__DIR__ . '/../log') . '/fatal_error.log');

if (!isset($environment)) {
    throw new \Exception('$environment must be set!');
}

$classLoader = include(realpath(__DIR__ . '/../') . '/vendor/autoload.php');

$diImpl = new \Application\Di\DiImpl();
$diImpl->setServiceNamespace('Application\DiService');
$diImpl->set('class_loader', $classLoader);
/**
 * environment değeri APPLICATION_ENV üzerinden okunur. Ancak cli üzeirnden işlem yaparken manual olarak tanımlamak
 * gerekebilir. Bu yüzden $environment değişkeni dışarıdan alındı.
 */
$diImpl->set('environment', $environment);

return $diImpl;