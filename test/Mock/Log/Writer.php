<?php

/**
 * =============================================================================
 * @file        Mock/Log/Writer.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Mock\Log;

use Commons\Log\Writer\AbstractWriter;

class Writer extends AbstractWriter
{
    
    public function _write($message, $priority)
    {
        echo $message.' '.$priority;
    }
    
}
