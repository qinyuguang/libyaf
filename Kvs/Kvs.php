<?php
namespace Kvs;

use Kvs\Exception;
use Logkit\Logger;

class Kvs
{
    private static $instances = [];

    private static $default = 'default';

    public static function ins($group = null)
    {
        if (! isset($group)) {
            $group = Kvs::$default;
        }

        if (isset(Kvs::$instances[$group])) {
            return Kvs::$instances[$group];
        };

        $config  = \Yaf\Application::app()->getConfig()->kvs;

        $config = isset($config) ? $config->$group : null;

        if (! isset($config)) {
            throw new Exception('Failed to load Kvs group: '.$group);
        }

        $driver = 'Kvs\\Driver\\'.ucfirst($config->driver);

        if (! class_exists($driver)) {
            throw new Exception('Driver '.$driver.' not found.');
        }

        $logger = Logger::ins('_kvs');

        $instance = new $driver($config, $logger);

        Kvs::$instances[$group] = $instance;

        return Kvs::$instances[$group];
    }

    private function __construct()
    {

    }

}


