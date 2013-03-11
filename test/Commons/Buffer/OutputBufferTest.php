<?php

/**
 * =============================================================================
 * @file        Commons/Buffer/OutputBufferTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Buffer;

class OutputBufferTest extends \PHPUnit_Framework_TestCase
{

    public function testBuffer()
    {
        OutputBuffer::start();
        echo "abc";
        $contents = OutputBuffer::end();
        $this->assertEquals('abc', $contents);
    }
    
}
