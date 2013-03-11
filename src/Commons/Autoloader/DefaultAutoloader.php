<?php

/**
 * =============================================================================
 * @file        Commons/Autoloader/DefaultAutoloader.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Autoloader;

require_once 'Exception.php';

class DefaultAutoloader
{

    protected function __construct() {
    }

    /**
     * Autoloader.
     * @param string $className
     * @return string | false
     */
    public static function autoloader($className)
    {
        try {
            self::loadClass($className);
            return $className;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Load class.
     * @param string $className
     * @return string
     * @throws Commons\Autoloader\Exception
     */
    public static function loadClass($className)
    {
        if (class_exists($className, false) || interface_exists($className, false)) {
            return;
        }
        $classPath = $className.'.php';
        $result = @include $classPath;
        if ($result !== false) {
            if (!class_exists($className, false) && !interface_exists($className, false)) {
                throw new Exception("Class $className is not declared in file '{$classPath}'!");
            }
        } else {
            $classPath = str_replace('_', '/', str_replace('\\', '_', $className)).'.php';
            $result = @include $classPath;
            if ($result === false) {
                throw new Exception("Cannot load class file '{$classPath}'!");
            }
            if (!class_exists($className, false) && !interface_exists($className, false)) {
                throw new Exception("Class $className is not declared in file '{$classPath}'!");
            }
        }
        return $className;
    }

    /**
     * Append a path to the include path.
     * @param string $path
     */
    public static function appendIncludePath($path)
    {
        set_include_path(get_include_path().PATH_SEPARATOR.$path);
    }

    /**
     * Prepend a path to the include path.
     * @param string $path
     */
    public static function prependIncludePath($path)
    {
        set_include_path($path.PATH_SEPARATOR.get_include_path());
    }

    /**
     * Alias to appendIncludePath.
     * @param string $path
     */
    public static function addIncludePath($path)
    {
        self::appendIncludePath($path);
    }

    /**
     * Init autoloaders.
     */
    public static function init()
    {
        spl_autoload_register(array('\\Commons\\Autoloader\\DefaultAutoloader', 'autoloader'));
    }
     
}

