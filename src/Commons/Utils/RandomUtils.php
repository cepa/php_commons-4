<?php

/**
 * =============================================================================
 * @file       Commons/Utils/RandomUtils.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Utils;

class RandomUtils
{

    protected function __construct() {}
    
    /**
     * Generate a random string.
     * @param   int $length
     * @return  string
     */
    public static function randomString($length)
    {
        $word = '';
        $n = (int) $length;
        while ($n--)
            $word .= chr((rand() % 26) + ord('a'));
        return $word;
    }
    
    /**
     * Taken from:
     * http://www.php.net/manual/en/function.uniqid.php#94959
     */
    public static function randomUuid()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        
            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),
        
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,
        
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,
        
            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
    
}
