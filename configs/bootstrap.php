<?php

error_reporting(E_ALL);
$environment = !isset($environment) ? 'development' : $environment;
ini_set('error_log', realpath(__DIR__ . '/../log/') . '/php_error.log');
$loader = include(realpath(__DIR__ . '/../') . '/vendor/autoload.php');
$di = new \OU\DI();
$di->setShared('class_loader', $loader);

$di->setShared('config', function ($di) use ($environment) {
    $configs = new \Zend\Config\Config(include_once(realpath(__DIR__ . '/env/' . $environment . '.php')), true);
    $configs->environment = $environment;
    return $configs;
});

$di->setShared('logger_helper', function ($di) {
    return new \OU\Logger\MonologHelper($di);
});

$di->setShared('error_catcher', function ($di) {
    return new \OU\ErrorCatcher($di);
});

$di->setShared('pdo', function (\OU\DI $di) {
    $config = $di->get('config');
    try {
        $pdo = new \PDO($config->pdo->dsn, $config->pdo->username, $config->pdo->password);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    } catch (\PDOException $exception) {
        /**
         * @var \Monolog\Logger $logger
         */
        $logger = $di->get('logger_helper')->getLogger();
        $logger->critical($exception);
        throw $exception;
    }
    return $pdo;
});

$di->setShared('pdo_helper', function ($di) {
    return new \OU\MySQL\PDOHelper($di);
});

$di->setShared('http_request', function ($di) {
    return \Symfony\Component\HttpFoundation\Request::createFromGlobals();
});

$di->setShared('http_response', function ($di) {
    return new \Symfony\Component\HttpFoundation\Response();
});

$di->setShared('http_session', function (\OU\DI $di) {
    $configs = $di->get('config');
    $handler = new \Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler(
        $di->get('pdo'),
        $configs->session->database->toArray()
    );
    $storage = new \Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage(
        $configs->session->storage->toArray(),
        $handler
    );
    $session = new \Symfony\Component\HttpFoundation\Session\Session($storage);
    $session->start();
    return $session;
});

$di->setShared('mailer', function (\OU\DI $di) {
    $configs = $di->get('config')->mailer;
    $transport = \Swift_SmtpTransport::newInstance($configs->host, $configs->port)
        ->setUsername($configs->username)
        ->setPassword($configs->password);
    return \Swift_Mailer::newInstance($transport);
});

$di->setShared('translator', function (\OU\DI $di) {
    // TODO : Check header
    $configs = $di->get('config');
    $translator = new \Symfony\Component\Translation\Translator('tr_TR');
    $translator->addLoader('array', new \Symfony\Component\Translation\Loader\ArrayLoader());
    $translator->addResource('array', include($configs->base_path . '/translations/tr.php'), 'tr_TR');
    $translator->addResource('array', include($configs->base_path . '/translations/en.php'), 'en_US');
    return $translator;
});

$di->setShared('twig', function (\OU\DI $di) {
    $config = $di->get('config');
    $loader = new \Twig_Loader_Filesystem($config->twig->templates_path);
    $twig = new \Twig_Environment($loader, $config->twig->toArray());
    return $twig;
});

$di->setShared('router', function (\OU\DI $di) {
    $router = new AltoRouter();
    $router->map('GET', '/', '\Project\WebController\Homepage#homepage');
    $router->map('POST|GET|PUT|DELETE', '*', '\Project\WebController\NotFoundController#notFound');
    return $router;
});

$di->setShared('dispatcher', function (\OU\DI $di) {
    return new \OU\Router\Dispatcher($di);
});

return $di;
