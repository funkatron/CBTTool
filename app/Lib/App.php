<?php
namespace CBTTool\Lib;

use \Slim\Slim as Slim;

/**
* extends Slim App class to add functionality
*/
class App extends Slim
{
    public static function factory(array $settings = null)
    {
        if (empty($settings)) {
            $settings = self::getConfig();
        }
        return new App($settings);
    }

    public function setJSONBody($structure, $status = 200)
    {
        $this->response->headers->set('Content-Type', 'application/json');
        $this->response->setStatus($status);
        $this->response->setBody(json_encode($structure, JSON_PRETTY_PRINT));
    }
}
