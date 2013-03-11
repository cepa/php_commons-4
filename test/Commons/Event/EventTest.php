<?php

/**
 * =============================================================================
 * @file        Commons/Event/EventTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Event;

class EventTest extends \PHPUnit_Framework_TestCase
{
    
    protected $_state = null;
    
    public function changeState(Event $event)
    {
        $this->_state = $event->state;
    }
    
    public function testEvent()
    {
        $event = new Event('event');
        $this->assertEquals('event', $event->getName());
        $this->assertEquals('event', (string) $event);
    }
    
    public function testEvent_InvalidName()
    {
        $this->setExpectedException('Commons\\Exception\\InvalidArgumentException');
        $event = new Event(new \stdClass());
    }
    
    public function testSetGetDispatcher()
    {
        $this->assertTrue(Event::getDispatcher() instanceof Dispatcher);
        Event::setDispatcher(new \Mock\Event\Dispatcher());
        $this->assertTrue(Event::getDispatcher() instanceof \Mock\Event\Dispatcher);
    }
    
    public function testBindRaiseClear()
    {
        Event::setDispatcher(new Dispatcher());
        Event::bind('mock_event', array($this, 'changeState'));
        
        Event::raise('mock_event', array('state' => 'test'));
        $this->assertEquals('test', $this->_state);
        
        $this->_state = null;
        Event::clear('mock_event');
        Event::raise('mock_event', array('state' => 'test'));
        $this->assertNull($this->_state);
    }
    
}
