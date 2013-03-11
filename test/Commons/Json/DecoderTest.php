<?php

/**
 * =============================================================================
 * @file        Commons/Json/DecoderTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Json;

class DecoderTest extends \PHPUnit_Framework_TestCase
{
    
    public function testDecode()
    {
        $decoder = new Decoder();
        
        $this->assertEquals(
            $decoder->decode(''),
            '');
        $this->assertEquals(
            $decoder->decode('""'),
            '');
        $this->assertEquals(
            $decoder->decode('null'),
            null);
        $this->assertEquals(
            $decoder->decode('false'),
            false);
        $this->assertEquals(
            $decoder->decode('0'),
            0);
        $this->assertEquals(
            $decoder->decode('123'),
            123);
    
        $this->assertTrue(is_array($decoder->decode('[]')));
        $this->assertEquals(0, count($decoder->decode('[]')));
    
        $a = $decoder->decode('["abc",123]');
        $this->assertTrue(is_array($a));
        $this->assertEquals('abc', $a[0]);
        $this->assertEquals(123, $a[1]);
    
        $o = $decoder->decode('{"a":"abc","b":123}');
        $this->assertTrue(is_array($o));
        $this->assertEquals('abc', $o['a']);
        $this->assertEquals(123, $o['b']);
    
        $o = $decoder->decode('{"a":"abc","b":123}', false);
        $this->assertTrue(is_object($o));
        $this->assertEquals('abc', $o->a);
        $this->assertEquals(123, $o->b);
    }
    
    public function testDecodeException()
    {
        $this->setExpectedException("Commons\\Json\\Exception");
        $decoder = new Decoder();
        $x = $decoder->decode('"xxx');
    }
    
}
