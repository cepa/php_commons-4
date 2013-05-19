<?php

/**
 * =============================================================================
 * @file        Commons/Console/ConsoleTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Console;

class ConsoleTask extends \PHPUnit_Framework_TestCase
{
    
    public function testRegisterHasGetUnregisterTask()
    {
        $console = new Console();
        $this->assertFalse($console->hasTask('mock'));
        $c = $console->registerTask('mock', 'Mock\\Console\\Task');
        $this->assertTrue($c instanceof Console);
        $this->assertTrue($console->hasTask('mock'));
        $this->assertEquals('Mock\\Console\\Task', $console->getTaskClassName('mock'));
        $c = $console->unregisterTask('mock');
        $this->assertTrue($c instanceof Console);
        $this->assertFalse($console->hasTask('mock'));
    }
    
    public function testRunTask()
    {
        $console = new Console();
        $console->registerTask('mock', 'Mock\\Console\\Task');
        $this->assertEquals(666, $console->runTask('mock', array('test' => 666)));
    }
    
    public function testRunTask_NotFoundException()
    {
        $this->setExpectedException('Commons\\Console\\Exception');
        $console = new Console();
        $console->runTask('mock');
    }
     
}

