<?php

/**
 * =============================================================================
 * @file        Commons/Log/Writer/NullWriter.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Log\Writer;

class NullWriter extends AbstractWriter
{
    
    /**
     * Dummy.
     * @see Commons\Log\Writer\AbstractWriter::_write()
     */
    public function _write($message, $priority)
    {
        // Dummy writter.
    }
    
}
