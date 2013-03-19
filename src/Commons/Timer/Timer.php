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

    const MARKER_START = 'start';
    const MARKER_END = 'end';

    /** @var float[] */
    private $_markers = array();
    
    /**
     * Prepare timer.
     */
    public function __construct()
    {
        $this->reset();
    }
    
    /**
     * Reset timer.
     * @return Timer
     */
    public function reset()
    {
        $this->_markers = array(
            'start' => $this->_getMicroTime(),
        );
        return $this;
    }

    /**
     * Get current up time.
     * @param string $markerFrom
     * @param string $markerTo
     * @return float
     */
    public function getValue($markerFrom = self::MARKER_START, $markerTo = self::MARKER_END)
    {
        $from = ( isset($this->_markers[$markerFrom]) ? $this->_markers[$markerFrom] : $this->_markers[self::MARKER_START]);
        $to = ( isset($this->_markers[$markerTo]) ? $this->_markers[$markerTo] : $this->_getMicroTime() );

        if (extension_loaded('bcmath')) {
            return bcsub($to, $from, 6);
        }
        else {
            return (float)($to - $from);
        }
    }

    /**
     * Set marker time
     * @param $name
     */
    public function setMarker($name)
    {
        if ($name != self::MARKER_START) {
            $this->_markers[$name] = $this->_getMicroTime();
        }
    }

    /**
     * @return float
     */
    private function _getMicroTime()
    {
        return (float)microtime(true);
    }
}
