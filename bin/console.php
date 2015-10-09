<?php

$environment = strtolower(getenv('APPLICATION_ENV'));

// Check app_env setting.
if (!$environment) {
    echo 'APPLICATION_ENV must be configured!' . PHP_EOL;
    exit(255);
}

$di = require_once (realpath(__DIR__ . '/../configs/bootstrap.php'));
$di->get('config')->logger->default_name = 'console';
$di->get('error_catcher')->register();

$symfonyConsoleApp = new \Symfony\Component\Console\Application();
$symfonyConsoleApp->getHelperSet()->set(new \OU\Console\DiHelper($di));

/**
 * Doctrine ile ilgili komutlar özel olarak ekleniyor.
 */
$doctrineConn = \Doctrine\DBAL\DriverManager::getConnection(
    array(
        'driver' => 'pdo_mysql',
        'pdo' => $di->get('pdo')
    )
);
$symfonyConsoleApp->getHelperSet()->set(new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($doctrineConn));
$symfonyConsoleApp->add(new \Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand());
$symfonyConsoleApp->add(new \Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand());
$symfonyConsoleApp->add(new \Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand());
$symfonyConsoleApp->add(new \Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand());
$symfonyConsoleApp->add(new \Doctrine\DBAL\Migrations\Tools\Console\Command\LatestCommand());
$symfonyConsoleApp->add(new \Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand());
$symfonyConsoleApp->add(new \Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand());

$symfonyConsoleApp->run();
