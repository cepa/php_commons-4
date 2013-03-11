<?php

/**
 * =============================================================================
 * @file        Commons/Log/Formatter/FormatterInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Log\Formatter;

interface FormatterInterface
{
    
    /**
     * Format a message.
     * @param string $message
     * @return string
     */
    public function format($message);
    
}
