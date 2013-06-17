<?php

/**
 * =============================================================================
 * @file       Commons/Log/Writer/StreamWriterTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
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
