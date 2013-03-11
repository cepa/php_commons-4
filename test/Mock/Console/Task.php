<?php

/**
 * =============================================================================
 * @file        Mock/Console/Task.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Mock\Console;

use Commons\Console\Task\AbstractTask;

class Task extends AbstractTask
{
    
    public function run(array $params = array())
    {
        return $params['test'];
    }
    
}
