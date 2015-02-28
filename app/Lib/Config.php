<?php

namespace CBTTool\Lib;

class Config extends \Noodlehaus\Config
{
    const APP_MODE_DEVELOPMENT = 'development';

    const APP_MODE_TESTING = 'testing';

    const APP_MODE_PRODUCTION = 'production';

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

    public function toArray()
    {
        return $this->data;
    }
}