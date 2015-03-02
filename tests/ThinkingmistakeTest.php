<?php

use CBTTool\Lib\Config;
use CBTTool\Model\Thinkingmistake;

class ThinkingmistakeTest extends PHPUnit_Framework_TestCase
{
    public static $APP_MODE = 'testing';

    /**
     * @var CBTTool\Lib\Config
     */
    public $config;

    public function setUp()
    {
        $base_path = realpath(dirname(__FILE__) . '/..');
        $this->config = Config::loadAppConfig($base_path, self::$APP_MODE);
    }

    public function testGetAll()
    {
        $tm = new Thinkingmistake($this->config);
        $rows = $tm->getAll(100, 0);
        foreach ($rows as $row) {
            $this->assertTrue(array_key_exists('id', $row));
            $this->assertTrue(array_key_exists('value', $row));
            $this->assertTrue(array_key_exists('label', $row));
            $this->assertTrue(array_key_exists('sort_order', $row));
            $this->assertTrue(!empty($row['id']));
            $this->assertTrue(!empty($row['value']));
            $this->assertTrue(!empty($row['label']));
            $this->assertTrue(!empty($row['sort_order']));
        }
    }
}