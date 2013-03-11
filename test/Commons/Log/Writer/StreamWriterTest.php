<?php

/**
 * =============================================================================
 * @file        Commons/Log/Writer/StreamWriterTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Log\Writer;

use Commons\Buffer\OutputBuffer;

class StreamWriterTest extends \PHPUnit_Framework_TestCase
{
    
    public function testWriter()
    {
        /*
         * PHPUnit catches stderr and thinks its an error.
         */
        $writer = new StreamWriter();
        //$writer->write('test', LOG_DEBUG);
    }
    
}
