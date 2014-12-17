<?php

if (!defined('MINIFRAME_BASE_PATH')) {
    define('MINIFRAME_BASE_PATH', realpath(__DIR__ . '/../'));
}

ini_set('display_errors', false);
date_default_timezone_set('Europe/Istanbul');

/**
 * Init
 */
$configs = array(
    'base_path' => MINIFRAME_BASE_PATH,
    'req_id' => uniqid(gethostname() . '-REQ-'),
    'php_bin' => '/usr/bin/php'
);

/**
 * Console Application
 */
$configs['console_application'] = array();
$configs['console_application']['name'] = 'Console Application';

/**
 * Web Application
 */
$configs['web_application'] = array();
$configs['web_application']['default_controller'] = 'Application\Web\NotFound';
$configs['web_application']['routes'] = include(MINIFRAME_BASE_PATH . '/configs/routes.php');
$configs['web_application']['asset_base_url'] = '/';
$configs['web_application']['site_base_url'] = '/';
$configs['web_application']['base_domain'] = 'site.com';

/**
 * PDO Service Configs
 */
$configs['pdo'] = array();
$configs['pdo']['dsn'] = 'mysql:host=127.0.0.1;dbname=project;charset=utf8';
$configs['pdo']['username'] = 'root';
$configs['pdo']['password'] = '';

/**
 * Twig
 */
$configs['twig'] = array();
$configs['twig']['templates_path'] = MINIFRAME_BASE_PATH . '/templates';
$configs['twig']['cache'] = MINIFRAME_BASE_PATH . '/tmp/twig';
$configs['twig']['auto_reload'] = true;

/**
 * Swift Mailer
 */
$configs['swiftmailer'] = array();
$configs['swiftmailer']['host'] = 'smtp.example.org';
$configs['swiftmailer']['port'] = 25;
$configs['swiftmailer']['username'] = 'root@example.org';
$configs['swiftmailer']['password'] = '123456';
$configs['swiftmailer']['sender_name'] = 'Test Email';
$configs['swiftmailer']['sender_email'] = 'root@example.org';

/**
 * Session
 */
$configs['session'] = array();
$configs['session']['storage'] = array();
$configs['session']['storage']['cookie_lifetime'] = 60 * 60 * 24 * 7;

/**
 * levels:
 *
 * 7 DEBUG
 * 6 INFO
 * 5 NOTICE
 * 4 WARNING
 * 3 ERROR
 * 2 CRITICAL
 * 1 ALERT
 * 0 EMERGENCY
 *
 */
$configs['logger'] = array();
$configs['logger']['name'] = 'app';
$configs['logger']['line_format'] = "[%datetime%] [%req-id%-%counter%] [%level_name%] %message%\n";
$configs['logger']['path'] = realpath(MINIFRAME_BASE_PATH . '/log');
$configs['logger']['level'] = 6;
$configs['logger']['datetime_format'] = 'Y-m-d H:i:s';

return $configs;
