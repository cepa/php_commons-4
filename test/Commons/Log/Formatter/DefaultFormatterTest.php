<?php

/**
 * =============================================================================
 * @file        Commons/Log/Formatter/DefaultFormatterTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Log\Formatter;

class DefaultFormatterTest extends \PHPUnit_Framework_TestCase
{
    
    public function testSetGetDateTimeFormat()
    {
        $formatter = new DefaultFormatter();
        $this->assertEquals('Y-m-d H:i:s', $formatter->getDateTimeFormat());
        $f = $formatter->setDateTimeFormat('abc');
        $this->assertTrue($f instanceof DefaultFormatter);
        $this->assertEquals('abc', $f->getDateTimeFormat());
    }
    
    public function testFormat_String()
    {
        $pattern = '/^\d+\-\d+\-\d+ \d+\:\d+\:\d+\: (.*)\:(.*)\: (.*)\: test$/';
        $formatter = new DefaultFormatter();
        $this->assertEquals(1, preg_match($pattern, $formatter->format('test')));
    }
    
    public function testFormat_Array()
    {
        $pattern = '/^\d+\-\d+\-\d+ \d+\:\d+\:\d+\: file\.php\:666\: WARNING\: test$/';
        
        $event = array(
            'priority' => LOG_WARNING,
            'file' => 'file.php',
            'line' => 666,
            'message' => 'test'
        );
        
        $formatter = new DefaultFormatter();
        $this->assertEquals(1, preg_match($pattern, $formatter->format($event)));
    }
    
}
