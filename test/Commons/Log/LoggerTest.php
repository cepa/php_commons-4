<?php

/**
 * =============================================================================
 * @file        Commons/Log/LoggerTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Log;

use Commons\Log\Writer\NullWriter;

use Commons\Log\Writer\SyslogWriter;

class LoggerTest extends \PHPUnit_Framework_TestCase
{

    public function testAddSetGetClearWriters()
    {
        $logger = new Logger();
        $this->assertEquals(0, count($logger->getWriters()));
        $l = $logger->addWriters(array(new NullWriter(), new NullWriter()));
        $this->assertTrue($l instanceof Logger);
        $l = $logger->addWriter(new NullWriter());
        $this->assertTrue($l instanceof Logger);
        $this->assertEquals(3, count($logger->getWriters()));
        $l = $logger->clearWriters();
        $this->assertTrue($l instanceof Logger);
        $this->assertEquals(0, count($logger->getWriters()));
    }
    
    public function testLog()
    {
        $logger = new Logger();
        $logger->addWriter(new SyslogWriter());
        $logger->log('test log');
        $logger->emergency('test emergency');
        $logger->alert('test alert');
        $logger->critical('test critical');
        $logger->error('test error');
        $logger->warning('test warning');
        $logger->notice('test notice');
        $logger->info('test info');
        $logger->debug('test debug');
    }

}
