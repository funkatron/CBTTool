<?php

use CBTTool\Lib\Config;
use CBTTool\Model\Thoughtrecord;

class ThoughtrecordTest extends PHPUnit_Framework_TestCase
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

    /**
     * @covers CBTTool\Model\Thoughtrecord::generateIdHash
     */
    public function testGenerateIdHash()
    {
        $tr = new Thoughtrecord($this->config);
        $hash = $tr->generateIdHash();
        $this->assertTrue(32 === strlen($hash), "Hash is not exactly 32 characters long");
    }

    /**
     * @covers CBTTool\Model\Thoughtrecord::save
     */
    public function testSave()
    {

        $fkr = Faker\Factory::create();
        $tr = new Thoughtrecord($this->config);
        $trdata = array(
            'event' => $fkr->paragraph(5),
            'thoughts' => $fkr->paragraph(5),
            'feelings' => $fkr->paragraph(5),
            'behaviors' => $fkr->paragraph(5),
            'thoughts_accurate' => $fkr->paragraph(5),
            'thoughts_helpful' => $fkr->paragraph(5),
            'thinking_mistake_id' => $fkr->numberBetween(1,10),
            'say_to_self' => $fkr->paragraph(5),
            'how_feel' => $fkr->paragraph(5),
        );

        $id = $tr->save($trdata);
        $row = $tr->getById($id);
        
        $this->assertTrue(is_numeric($row['id']), "row id should be numeric");
        $this->assertTrue(is_string($row['id_hash']), "row id_rash should be an string");
        $this->assertEquals($trdata['event'], $row['event']);
        $this->assertEquals($trdata['thoughts'], $row['thoughts']);
        $this->assertEquals($trdata['feelings'], $row['feelings']);
        $this->assertEquals($trdata['behaviors'], $row['behaviors']);
        $this->assertEquals($trdata['thoughts_accurate'], $row['thoughts_accurate']);
        $this->assertEquals($trdata['thoughts_helpful'], $row['thoughts_helpful']);
        $this->assertEquals($trdata['thinking_mistake_id'], $row['thinking_mistake_id']);
        $this->assertEquals($trdata['say_to_self'], $row['say_to_self']);
        $this->assertEquals($trdata['how_feel'], $row['how_feel']);
    }

}