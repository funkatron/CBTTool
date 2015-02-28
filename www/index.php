<?php

/**
 * edit this if you need to move the www root
 * @var string
 */
$_ENV['APP_BASE_PATH'] = realpath(dirname(__FILE__) . '/..');

/**
 * We use the composer autoloader for everything
 */
require "{$_ENV['APP_BASE_PATH']}/vendor/autoload.php";

/**
 * libs we'll use here
 */
use Monolog\Logger;
use Monolog\Handler\ErrorLogHandler;
use CBTTool\Lib\App;
use CBTTool\Lib\Config;

/**
 * load the config files
 * @var CBTTool\Lib\Config
 */
$config = Config::loadAppConfig($_ENV['APP_BASE_PATH']);

/**
 * App object that extends Slim\Slim
 * @var CBTTool\Lib\App
 */
$app = new App($config->toArray());

/**
 * set-up monolog in app singleton container
 */
$app->container->singleton('log', function () use ($app) {
    $log = new Logger('CBTToolApp');
    $log->pushHandler(new ErrorLogHandler(
        ErrorLogHandler::OPERATING_SYSTEM,
        $app->config('monolog.level')
    ));
    return $log;
});

/**
 * set Twig parser options
 */
$view = $app->view();
$view->parserOptions = array(
    'debug' => $app->config('twig.debug'),
    'cache' => $app->config('twig.cache_path'),
);
/**
 * add Twig parser extensions for Slim
 */
$view->parserExtensions = array(
    new \Slim\Views\TwigExtension(),
    new Twig_Extension_Debug()
);

/**
 * add encrypted cookie session middleware
 * Note that the SessionCookie MW is added LAST so it loads BEFORE any
 * middleware that interacts with the session!
 */
$app->add(new \Slim\Middleware\SessionCookie([
    "encrypt" => $app->config("cookies.encrypt"),
    "expires" => $app->config("cookies.lifetime"),
    "path" => $app->config("cookies.path"),
    "secure" => $app->config("cookies.secure"),
    "httponly" => $app->config("cookies.httponly"),
    "secret_key" => $app->config("cookies.secret_key"),
    "cipher" => $app->config("cookies.cipher"),
    "cipher_mode" => $app->config("cookies.cipher_mode"),
    "name" => $app->config("cookies.name"),
]));

/**
 * include route files
 */
include "{$_ENV['APP_BASE_PATH']}/app/routes/index.php";

$app->run();
