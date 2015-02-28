<?php

use Monolog\Logger;

return array(
    "mode" => "testing",
    "debug" => true,
    "cookies.encrypt" => false,
    "cookies.secure" => "false",
    "cookies.httponly" => "true",
    "twig.debug" => true,
    "twig.cache_path" => "/tmp/twig_cache",

    "db.type" => "sqlite",
    "db.pdo.connect" => "sqlite:{$_ENV['CONFIG_APP_BASE_PATH']}/data/cbttool_testing.sqlite3",

    "monolog.level" => Logger::DEBUG,
);
