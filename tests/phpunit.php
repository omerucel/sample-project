<?php

/**
 * @var \Application\Di\Di $diImpl
 */
include_once(realpath(__DIR__) . '/DiContainer.php');
$environment = 'testing';
$diImpl = include(realpath(__DIR__ . '/../') . '/configs/bootstrap.php');
DiContainer::setDiImpl($diImpl);
