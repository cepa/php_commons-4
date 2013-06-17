<?php

/**
 * =============================================================================
 * @file       Commons/Buffer/OutputBuffer.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Buffer;

class OutputBuffer
{
    
    /**
     * Start buffer.
     */
    public static function start()
    {
        ob_start();
    }
    
    /**
     * End buffer.
     * @return string
     */
    public static function end()
    {
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }
    
}
