<?php
namespace CBTTool\Lib;

use \Slim\Slim as Slim;
use \CBTTool\Lib\Config;

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

    /**
     * This returns the App's config stuff in a \CBTTool\Lib\Config wrapper, suitable for use in other libs
     * @see \CBTTool\Lib\Config::setFromArray
     * @return \CBTTool\Lib\Config
     */
    public function getConfig()
    {
        $c = new Config();
        $c->setFromArray($this->container['settings']);
        return $c;
    }
}
