<?php

/**
 * =============================================================================
 * @file        Commons/Event/DispatcherTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Event;

use Commons\Callback\Callback;

class DispatcherTest extends \PHPUnit_Framework_TestCase
{
    
    protected $_state = null;
    
    public function changeState(Event $event)
    {
        $this->_state = $event->state;
    }
    
    public function testDispatcher()
    {
        $event = new Event('mock_event');
        $dispatcher = new Dispatcher();
        
        $d = $dispatcher->bind($event, new Callback($this, 'changeState'));
        $this->assertTrue($d instanceof Dispatcher);
        
        $event->state = 'ok';
        $d = $dispatcher->raise($event);
        $this->assertTrue($d instanceof Dispatcher);
        $this->assertEquals('ok', $this->_state);
        
        $d = $dispatcher->clear($event);
        $this->assertTrue($d instanceof Dispatcher);
        
        $this->_state = null;
        $d = $dispatcher->raise($event);
        $this->assertTrue($d instanceof Dispatcher);
        $this->assertNull($this->_state);
    }
    
}
