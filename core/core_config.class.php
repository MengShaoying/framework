<?php
class core_config {
    public static $config = array();
    public static function get($key) {
        return core_config::$config[$key];
    }
    public static function set($key, $value) {
        core_config::$config[$key] = $value;
    }
}