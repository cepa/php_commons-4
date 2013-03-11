<?php

/**
 * =============================================================================
 * @file        Commons/Log/Writer/SyslogWriterTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Log\Writer;

class SyslogWriterTest extends \PHPUnit_Framework_TestCase
{
    
    public function testWriter()
    {
        /*
         * Just cover the _write method.
         */
        $writer = new SyslogWriter();
        $writer->write('test', LOG_DEBUG);
    }
    
}
