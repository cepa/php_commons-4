<?php

/**
 * =============================================================================
 * @file        Commons/Config/Adapter/AbstractAdapterTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Config\Adapter;

use Commons\Config\Config;

class AbstractAdapterTest extends \PHPUnit_Framework_TestCase
{

    public function testSetGetConfig()
    {
        $adapter = new \Mock\Config\Adapter();
        $a = $adapter->setConfig(new Config);
        $this->assertTrue($a instanceof AbstractAdapter);
        $this->assertTrue($adapter->getConfig() instanceof Config);
    }
    
    public function testGetConfigException()
    {
        $this->setExpectedException('Commons\\Exception\\NotFoundException');
        $adapter = new \Mock\Config\Adapter();
        $adapter->getConfig();
    }
    
}
