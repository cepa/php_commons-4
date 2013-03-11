<?php

/**
 * =============================================================================
 * @file        Commons/Timer/Timer.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Timer;

class Timer
{
    
    protected $_startTime = 0;
    
    /**
     * Prepare timer.
     */
    public function __construct()
    {
        $this->reset();
    }
    
    /**
     * Reset timer.
     * @return Commons\Timer\Timer
     */
    public function reset()
    {
        list($x, $y) = explode(' ', microtime());
        $this->_startTime = $x + $y;
        return $this;
    }
    
    /**
     * Get current uptime.
     * @return float
     */
    public function getValue()
    {
        list($x, $y) = explode(' ', microtime());
        return (float)($x + $y - $this->_startTime);
    }
    
}
