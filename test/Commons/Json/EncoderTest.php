<?php

/**
 * =============================================================================
 * @file       Commons/Json/EncoderTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Json;

class EncoderTest extends \PHPUnit_Framework_TestCase
{
    
    public function testEncode()
    {
        $encoder = new Encoder();
        
        $this->assertEquals(
            '""',
            $encoder->encode(''));
        $this->assertEquals(
            '"abc"',
            $encoder->encode('abc'));
        $this->assertEquals(
            'null',
            $encoder->encode(null));
        $this->assertEquals(
            'false',
            $encoder->encode(false));
        $this->assertEquals(
            '0',
            $encoder->encode(0));
        $this->assertEquals(
            '123',
            $encoder->encode('123'));
        $this->assertEquals(
            '[]',
            $encoder->encode(array()));
        $this->assertEquals(
            '["abc",123]',
            $encoder->encode(array('abc', 123)));
        $this->assertEquals(
            '{"a":"abc","b":123}',
            $encoder->encode(array('a' => 'abc', 'b' => 123)));
    }

}
