<?php

/**
 * =============================================================================
 * @file        Commons/Console/Console.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Console;

use Commons\Autoloader\DefaultAutoloader;
use Commons\Autoloader\Exception as AutoloaderException;
use Commons\Console\Task\TaskInterface;

class Console
{
    
    protected $_tasks = array();
    
    /**
     * Register task.
     * @param string $taskName
     * @param string $className
     * @return \Commons\Console\Console
     */
    public function registerTask($taskName, $className)
    {
        $this->_tasks[$taskName] = $className;
        return $this;
    }
    
    /**
     * Has task.
     * @param string $taskName
     * @return boolean
     */
    public function hasTask($taskName)
    {
        return isset($this->_tasks[$taskName]);
    }
    
    /**
     * Get task name.
     * @param string $taskName
     * @throws NotFoundException
     * @return string
     */
    public function getTaskClassName($taskName)
    {
        if (!$this->hasTask($taskName)) {
            throw new Exception("Task '{$taskName}' is not registered");
        }
        return $this->_tasks[$taskName];
    }
    
    /**
     * Unregister task.
     * @param string $taskName
     * @return \Commons\Console\Console
     */
    public function unregisterTask($taskName)
    {
        unset($this->_tasks[$taskName]);
        return $this;
    }
    
    /**
     * Run task.
     * @param string $task
     * @param array $params
     * @throws InvalidArgumentException
     * @return mixed
     */
    public function runTask($taskName, array $params = array())
    {
        $className = $this->getTaskClassName($taskName);
        try {
            DefaultAutoloader::loadClass($className);
        } catch (AutoloaderException $e) {
            throw new Exception("Cannot load task class '{$className}'");
        }
        $task = new $className($this);
        if (!($task instanceof TaskInterface)) {
            throw new Exception("Task '{$taskName}' has to implement TaskInterface");
        }
        return $task->run($params);
    }
    
}