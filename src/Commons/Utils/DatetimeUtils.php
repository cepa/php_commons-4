<?php

/**
 * =============================================================================
 * @file       Commons/Utils/DatetimeUtils.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Utils;

class DatetimeUtils 
{
    
    protected function __construct() {}

    /**
     * Convert time interval to simple text representation.
     * Format: DAYSd HOURSh MINUTESm SECONDSs
     * @param int $time
     * @param int $now
     * @return string
     */
    public static function ago($time, $now = null)
    {
        if (!isset($now)) {
            $now = time();
        }
        
        if ($time > $now) {
            return false;
        }
        
        $delta = $now - $time;
        $days = 0;
        $hours = 0;
        $minutes = 0;
        $seconds = 0;
        $ago = '';
        
        if ($delta >= 86400) {
            $days = (int) ($delta / 86400.0);
            $delta -= $days * 86400;
            $ago .= "{$days}d ";
        }

        if ($delta >= 3600) {
            $hours = (int) ($delta / 3600.0);
            $delta -= $hours * 3600;
            $ago .= "{$hours}h "; 
        }
        
        if ($delta >= 60) {
            $minutes = (int) ($delta / 60.0);
            $delta -= $minutes * 60;
            $ago .= "{$minutes}m ";
        }
        
        $seconds = $delta;
        $ago .= "{$seconds}s";
        
        return trim($ago);
    }
    
}
