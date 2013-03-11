<?php

/**
 * =============================================================================
 * @file        Commons/Console/Task/AbstractTask.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Console\Task;

use Commons\Console\Console;
use Commons\Exception\NotImplementedException;

abstract class AbstractTask implements TaskInterface
{
    
    protected $_console;

    /**
     * Set console.
     * @param Console $console
     */
    public function __construct(Console $console)
    {
        $this->_console = $console;
    }
    
    /**
     * Get console.
     * @see \Commons\Console\Task\TaskInterface::getConsole()
     */
    public function getConsole()
    {
        return $this->_console;
    }
    
    /**
     * Run task.
     * @see \Commons\Console\Task\TaskInterface::run()
     */
    public function run(array $params = array())
    {
        throw new NotImplementedException();
    }
    
}
