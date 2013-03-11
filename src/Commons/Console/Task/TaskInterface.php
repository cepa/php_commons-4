<?php

/**
 * =============================================================================
 * @file        Commons/Console/Task/TaskInterface.php
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

interface TaskInterface
{
    
    /**
     * Init task.
     * @param \Commons\Console\Console $console
     */
    public function __construct(Console $console);
    
    /**
     * Get console.
     * @return \Commons\Console\Console
     */
    public function getConsole();
    
    /**
     * Run task.
     * @param array $params
     * @return mixed
     */
    public function run(array $params = array());
    
}
