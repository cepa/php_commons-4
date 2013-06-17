<?php

/**
 * =============================================================================
 * @file       Commons/Timer/TimerTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Timer;

class TimerTest extends \PHPUnit_Framework_TestCase
{

    public function testTimer()
    {
        $timer = new Timer();
        sleep(1);
        $v = $timer->getValue();
        $this->assertTrue($v > 1.0);
    }

}
