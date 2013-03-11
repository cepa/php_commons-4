<?php

/**
 * =============================================================================
 * @file        Commons/Console/Task/AbstractTaskTest.php
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

class AbstractTaskTest extends \PHPUnit_Framework_TestCase
{
    
    public function testTask()
    {
        $task = new \Mock\Console\Task(new Console());
        $this->assertTrue($task->getConsole() instanceof Console);
        $this->assertEquals(123, $task->run(array('test' => 123)));
    }
    
}
