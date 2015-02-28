<?php

use Monolog\Logger;

return array(
    "mode" => "base",
    'view' => new \Slim\Views\Twig(),
    "debug" => false,
    "templates.path" => "../templates",
    "cookies.encrypt" => true,
    "cookies.lifetime" => "2 years",
    "cookies.path" => "/",
    "cookies.secure" => true,
    "cookies.httponly" => true,
    "cookies.secret_key" => "FIX_ME",
    "cookies.cipher" => MCRYPT_RIJNDAEL_256,
    "cookies.cipher_mode" => MCRYPT_MODE_CBC,
    "cookies.name" => "app_session",
    "http.version" => "1.1",

    "monolog.level" => Logger::ERROR,

    "csrf.secret" => "FIX_ME",
);
