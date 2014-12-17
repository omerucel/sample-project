<?php

/**
 * @var \Application\Di\Di $diImpl
 */
$environment = strtolower(getenv('APPLICATION_ENV'));
$diImpl = include(realpath(__DIR__ . '/../') . '/configs/bootstrap.php');
$diImpl->get('config')->logger->name = 'console';
$diImpl->get('error_catcher')->register();

$consoleApp = new \Symfony\Component\Console\Application(
    $diImpl->get('config')->console_application->name
);
$consoleApp->getHelperSet()->set(new \Application\Console\DiHelper($diImpl));

/**
 * Diğer komutları buradan ekleyebilirsiniz:
 *
 * $symfonyConsoleApp->add(new \Application\Console\MyCommand());
 */

/**
 * Doctrine ile ilgili komutlar özel olarak ekleniyor.
 */
$doctrineConn = \Doctrine\DBAL\DriverManager::getConnection(
    array(
        'driver' => 'pdo_mysql',
        'pdo' => $diImpl->get('pdo')
    )
);
$consoleApp->getHelperSet()->set(new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($doctrineConn));
$consoleApp->getHelperSet()->set(new \Symfony\Component\Console\Helper\DialogHelper(), 'dialog');
$consoleApp->add(new \Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand());
$consoleApp->add(new \Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand());
$consoleApp->add(new \Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand());
$consoleApp->add(new \Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand());
$consoleApp->add(new \Doctrine\DBAL\Migrations\Tools\Console\Command\LatestCommand());
$consoleApp->add(new \Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand());
$consoleApp->add(new \Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand());

$consoleApp->run();
