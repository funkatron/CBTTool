<?php

return array(
    "mode" => "production",
    "debug" => false,
    "log.enabled" => false,
    "cookies.encrypt" => true,
    "cookies.secure" => true,
    "cookies.httponly" => true,
    "twig.debug" => false,

    "db.type" => "sqlite",
    "db.pdo.connect" => "sqlite:{$_ENV['CONFIG_APP_BASE_PATH']}/data/cbttool.sqlite3",

);
