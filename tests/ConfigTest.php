<?php

use CBTTool\Lib\Config;
use CBTTool\Lib\App;

class ConfigTest extends PHPUnit_Framework_TestCase
{
    public static $APP_MODE = 'testing';

    public function testLoadAppConfig()
    {
        $base_path = realpath(dirname(__FILE__) . '/..');
        $c = Config::loadAppConfig($base_path, self::$APP_MODE);

        $db_type = $c->get('db.type');
        $this->assertEquals('sqlite', $db_type);

        $app = new App($c->toArray());
        $app_db_type = $app->config('db.type');
        $this->assertEquals($db_type, $app_db_type);
    }

}