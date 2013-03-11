<?php

/**
 * =============================================================================
 * @file        Commons/Callback/CallbackTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Callback;

function mock_callable_function()
{
    return 'ok';
}

class CallbackTest extends \PHPUnit_Framework_TestCase
{

    public function testCallback_MissingArgument()
    {
        $this->setExpectedException('Commons\\Exception\\Exception');
        $callable = new Callback();
    }
    
    public function testCallback_TooMuchArguments()
    {
        $this->setExpectedException('Commons\\Exception\\Exception');
        $callable = new Callback(1, 2, 3);
    }
    
    public function testCallback_InvalidArgument()
    {
        $this->setExpectedException('Commons\\Exception\\Exception');
        $callable = new Callback('NonExistingClass::unknownMethod');
    }
    
    public function testCallback_Function()
    {
        $callable = new Callback('Commons\\Callback\\mock_callable_function');
        $this->assertEquals('Commons\\Callback\\mock_callable_function', $callable->getCallback());
        $this->assertEquals('ok', $callable->call());
    }
    
    public function testCallback_Method()
    {
        $callable = new Callback(new \Mock\Callback\Object(), 'method');
        $this->assertTrue(is_array($callable->getCallback()));
        $this->assertEquals('ok', $callable->call(array('test' => 'ok')));
    }
    
}
