<?php
/**
 * We use \Noodlehaus\Config instead of the Slim config stuff mainly so we can pass around the config more easily,
 * and use it independently of Slim for testing and such.
 */

namespace CBTTool\Lib;

/**
 * Class Config
 * @package CBTTool\Lib
 */
class Config extends \Noodlehaus\Config
{
    const APP_MODE_DEVELOPMENT = 'development';

    const APP_MODE_TESTING = 'testing';

    const APP_MODE_PRODUCTION = 'production';

    /**
     * We extend the constructor to allow no arguments to be passed. If none are passed, we don't do *anything*, which
     * lets us set the config data via an array. If $path is not null, though, it will attempt to load the config
     * from files
     * @param null|string|array $path  Path(s) to config files. Optional.
     * @throws \Noodlehaus\Exception\FileNotFoundException
     * @see \CBTTool\Lib\Config::setFromArray
     */
    public function __construct($path = null)
    {
        if (!empty($path)) {
            parent::__construct($path);
        }
    }

    public static function loadAppConfig($base_path = null, $mode = 'development')
    {
        if (empty($base_path)) {
            if (!empty($_ENV['APP_BASE_PATH'])) {
                $base_path = $_ENV['APP_BASE_PATH'];
            } else {
                throw new InvalidArgumentException("\$base_path not set");
            }
        }

        /**
         * by setting this here we can use it within the PHP config files
         */
        $_ENV['CONFIG_APP_BASE_PATH'] = $base_path;

        $c = self::load(array(
            "{$base_path}/app/config/base.php",
            "{$base_path}/app/config/{$mode}.php",
        ));
        return $c;
    }

    /**
     * Overwrite the get method because we don't explode on periods. use '/' instead.
     * {@inheritDoc}
     */
    public function get($key, $default = null)
    {
        // Check if already cached
        if (isset($this->cache[$key])) {
            return $this->cache[$key];
        }

        $segs = explode('/', $key);
        $root = $this->data;

        // nested case
        foreach ($segs as $part) {
            if (isset($root[$part])) {
                $root = $root[$part];
                continue;
            } else {
                $root = $default;
                break;
            }
        }

        // whatever we have is what we needed
        return ($this->cache[$key] = $root);
    }

    /**
     * Overwrite the set method because we don't explode on periods. use '/' instead.
     * {@inheritDoc}
     */
    public function set($key, $value)
    {
        $segs = explode('/', $key);
        $root = &$this->data;

        // Look for the key, creating nested keys if needed
        while ($part = array_shift($segs)) {
            if (!isset($root[$part]) && count($segs)) {
                $root[$part] = array();
            }
            $root = &$root[$part];
        }

        // Assign value at target node
        $this->cache[$key] = $root = $value;
    }

    /**
     * set values from key/val array pairs
     * We add this here so we can set Config data directly from an array, instead of loading a file
     * We use this to extract the config from the App object and give it to our Models
     * @param array $config_array
     * @see \CBTTool\Lib\App::getConfig
     */
    public function setFromArray(array $config_array)
    {
        $this->data = array_merge($config_array);
    }

    public function toArray()
    {
        return $this->data;
    }
}