<?php

/**
 * =============================================================================
 * @file       Commons/Log/LogTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Log;

class LogTest extends \PHPUnit_Framework_TestCase
{
    
    public function testLog()
    {
        Log::log('test log');
        Log::emergency('test emergency');
        Log::alert('test alert');
        Log::critical('test critical');
        Log::error('test error');
        Log::warning('test warning');
        Log::notice('test notice');
        Log::info('test info');
        Log::debug('test debug');
    }
    
    public function testStringOutput()
    {
        ob_start();
        Log::setLogger($this->_getLogger());
        Log::log('test123', LOG_ALERT);
        $out = ob_get_contents();
        ob_end_clean();
        $this->assertContains('test123', $out);
        $this->assertContains(__FILE__, $out);
        $this->assertContains('ALERT', $out);
    }

    public function testArrayOutput()
    {
        ob_start();
        Log::setLogger($this->_getLogger());
        Log::log(array('abc', 'def'));
        $out = ob_get_contents();
        ob_end_clean();
        $this->assertContains('abc', $out);
        $this->assertContains('def', $out);
        $this->assertContains(__FILE__, $out);
        $this->assertContains('DEBUG', $out);
    }

    public function testObjectOutput()
    {
        ob_start();
        Log::setLogger($this->_getLogger());
        Log::log(new \Mock\Object());
        $out = ob_get_contents();
        ob_end_clean();
        $this->assertContains('mock_object', $out);
        $this->assertContains(__FILE__, $out);
        $this->assertContains('DEBUG', $out);
    }
    
    protected function _getLogger()
    {
        $logger = new Logger();
        $logger->addWriter(new \Mock\Log\Writer());
        return $logger;
    }

}
