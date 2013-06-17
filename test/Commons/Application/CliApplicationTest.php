<?php

/**
 * =============================================================================
 * @file       Commons/Application/CliApplicationTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Application;

use Commons\Config\Adapter\AbstractAdapterTest;

class CliApplicationTest extends \PHPUnit_Framework_TestCase
{
    
    public function testConstruct()
    {
        $app = new CliApplication();
        $this->assertEquals(0, $app->getArgc());
        $this->assertEquals(0, count($app->getArgv()));
    }
    
    public function testConstructWithArgcAndArgv()
    {
        $app = new CliApplication(array('test'));
        $this->assertEquals(1, $app->getArgc());
        $this->assertEquals(1, count($app->getArgv()));
    }
    
    public function testSetGetArgvAndArgc()
    {
        $app = new CliApplication();
        $a = $app->setArgv(array('a', 'b', 'c'));
        $this->assertTrue($a instanceof AbstractApplication);
        $this->assertEquals(3, $app->getArgc());
        $this->assertEquals(3, count($app->getArgv()));
    }

}
