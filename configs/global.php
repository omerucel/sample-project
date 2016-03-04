<?php

if (!defined('SAMPLE_BASE_PATH')) {
    define('SAMPLE_BASE_PATH', realpath(__DIR__ . '/../'));
}

ini_set('display_errors', false);
date_default_timezone_set('Europe/Istanbul');

/**
 * Init
 */
$configs = array(
    'base_path' => SAMPLE_BASE_PATH,
    'tmp_path' => SAMPLE_BASE_PATH . '/tmp',
    'req_id' => uniqid('REQ-' . gethostname()),
    'php_bin' => '/usr/bin/php'
);

/**
 * PDO Service Configs
 */
$configs['pdo'] = array();
$configs['pdo']['dsn'] = 'mysql:host=sample_mysql;dbname=sample;charset=utf8';
$configs['pdo']['hostname'] = 'sample_mysql';
$configs['pdo']['database'] = 'sample';
$configs['pdo']['username'] = 'root';
$configs['pdo']['password'] = '';

/**
 * Logger
 */
$configs['logger'] = array();
$configs['logger']['default_name'] = 'default';
$configs['logger']['default_path'] = realpath(SAMPLE_BASE_PATH . '/log');
$configs['logger']['default_level'] = \Monolog\Logger::DEBUG;
/**
 * supports different path and level for log name
 * $configs['logger']['app'] = array();
 * $configs['logger']['app']['path'] = realpath(BASE_PATH . '/log');
 * $configs['logger']['app']['level'] = \Monolog\Logger::DEBUG;
 * $di->getLogger('app')->info('foo bar');
 */

/**
 * Twig
 */
$configs['twig'] = array();
$configs['twig']['templates_path'] = SAMPLE_BASE_PATH . '/templates';
$configs['twig']['cache'] = SAMPLE_BASE_PATH . '/tmp/twig';
$configs['twig']['auto_reload'] = true;

/**
 * Swift Mailer
 */
$configs['mailer'] = array();
$configs['mailer']['host'] = 'smtp.example.org';
$configs['mailer']['port'] = 25;
$configs['mailer']['username'] = 'root@example.org';
$configs['mailer']['password'] = '123456';
$configs['mailer']['sender_name'] = 'Test Email';
$configs['mailer']['sender_email'] = 'root@example.org';

/**
 * Session
 */
$configs['session'] = array();
$configs['session']['storage'] = array();
$configs['session']['storage']['cookie_lifetime'] = 60 * 60 * 24 * 7;
$configs['session']['database'] = array();
$configs['session']['database']['db_table'] = 'session';
$configs['session']['database']['db_id_col'] = 'id';
$configs['session']['database']['db_data_col'] = 'data';
$configs['session']['database']['db_time_col'] = 'time';
$configs['session']['database']['db_lifetime_col'] = 'lifetime';

return $configs;
