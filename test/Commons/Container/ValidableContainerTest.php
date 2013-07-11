<?php

/**
 * =============================================================================
 * @file       Commons/Container/ValidableContainerTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Container;

use Commons\Callback\Callback;
use Mock\Object as MockObject;

class ValidableContainerTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $coll = new ValidableContainer();
        $this->assertEquals(0, count($coll));
    }
    
    public function testConstructWithArray()
    {
        $coll = new ValidableContainer(array(1, 2, 3));
        $this->assertEquals(3, count($coll));
    }
    
    public function testSetGetValidator()
    {
        $coll = new ValidableContainer();
        $this->assertNull($coll->getValidator());
        $c = $coll->setValidator(function($value){ return true; });
        $this->assertTrue($c instanceof ValidableContainer);
        $this->assertTrue($coll->getValidator() instanceof Callback);
    }
    
    public function testEmptyValidate()
    {
        $coll = new ValidableContainer();
        $coll->set('xxx', 'yyy');
        $this->assertEquals('yyy', $coll->get('xxx'));
    }
           
    public function testNumericValidate()
    {
        $coll = new ValidableContainer();
        $coll->setValidator(function($value){ return is_numeric($value); });
        $coll->set('xxx', 123);
        $this->assertEquals(123, $coll->get('xxx'));
    }
           
    public function testNumericValidateException()
    {
        $this->setExpectedException('\Commons\Container\Exception');
        $coll = new ValidableContainer();
        $coll->setValidator(function($value){ return is_numeric($value); });
        $coll->set('xxx', 'yyy');
    }
           
    public function testObjectValidate()
    {
        $coll = new ValidableContainer();
        $coll->setValidator(function($value){ return $value instanceof MockObject; });
        $coll->set('xxx', new MockObject());
        $this->assertTrue($coll->get('xxx') instanceof MockObject);
    }
           
    public function testObjectValidateException()
    {
        $this->setExpectedException('\Commons\Container\Exception');
        $coll = new ValidableContainer();
        $coll->setValidator(function($value){ return $value instanceof MockObject; });
        $coll->set('xxx', 123);
    }
           
}
