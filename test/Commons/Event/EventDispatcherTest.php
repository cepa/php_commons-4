<?php

/**
 * =============================================================================
 * @file       Commons/Event/EventDispatcherTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Event;

use Commons\Callback\Callback;

class MockSomeCrazyEvent
{
    public $state;
}

class EventDispatcherTest extends \PHPUnit_Framework_TestCase
{

    public function testDispatcher()
    {
        $dispatcher = new EventDispatcher();
        $d = $dispatcher->bind('\Commons\Event\Event', function ($e) {
            $e->state .= 'X';
        });
        $this->assertTrue($d instanceof EventDispatcherInterface);

        $event = new Event();
        $event->state = '';

        $dispatcher
            ->raise($event)
            ->raise($event)
            ->raise($event)
            ->clear($event)
            ->raise($event);

        $this->assertEquals('XXX', $event->state);
    }

    public function testStopPropagation()
    {
        $dispatcher = new EventDispatcher();

        $dispatcher->bind('Commons\Event\MockSomeCrazyEvent', function (MockSomeCrazyEvent $e) {
            $e->state .= 'X';
        });

        $dispatcher->bind('Commons\Event\MockSomeCrazyEvent', function (MockSomeCrazyEvent $e) {
            $e->state .= 'Y';
            return false; // Stop propagation.
        });

        $dispatcher->bind('Commons\Event\MockSomeCrazyEvent', function (MockSomeCrazyEvent $e) {
            $e->state .= 'Z';
        });

        $event = new MockSomeCrazyEvent();
        $event->state = '';

        $dispatcher->raise($event);

        $this->assertEquals('XY', $event->state);
    }

}
