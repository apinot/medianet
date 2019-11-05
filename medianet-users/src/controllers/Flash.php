<?php

namespace medianet\controllers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class Flash {
    
    private static $flashedData;
    private static $validated = false;
    
    private static function init()
    {
        if (! isset($_SESSION["flash"]))
        {
            $_SESSION['flash'] = [];
        }
        if (self::$flashedData === null)
        self::$flashedData = [];
    }
    
    public static function has($name) {
        self::init();
        if (is_array($name))
        {
            $array = $_SESSION["flash"];
            foreach($name as $key)
            {
                if (!isset($array[$key]))
                return false;
                $array = $array[$key];
            }
            return true;
        }
        else
        return isset($_SESSION["flash"][$name]);
    }
    
    public static function get($name) {
        self::init();
        if (!self::has($name))
        return null;
        if (is_array($name))
        {
            $value = $_SESSION["flash"];
            foreach($name as $key)
            $value = $value[$key];
            return $value;
        }
        else
        return $_SESSION["flash"][$name];
    }
    
    private static function flash(string $key, $value)
    {
        self::init();
        self::$flashedData[$key] = $value;
    }

    public static function flashError($value) {
        self::flash('error', $value);
    }
    
    public static function flashInfo($value) {
        self::flash('info', $value);
    }
    public static function flashSuccess($value) {
        self::flash('success', $value);
    }
    public static function clear()
    {
        self::init();
        $_SESSION['flash'] = [];
        self::$flashedData = [];
    }
    
    public static function next()
    {
        self::init();
        if (!self::$validated)
        {
            $_SESSION['flash'] = self::$flashedData;
            self::$flashedData = [];
            self::$validated = true;
        }
    }
}
