<?php

/**
 * =============================================================================
 * @file        Commons/Config/ConfigTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructWithEnvAndAdapter()
    {
        $config = new Config('testing', new \Mock\Config\Adapter());
        $this->assertEquals('testing', $config->getEnvironment());
        $this->assertTrue($config->getAdapter() instanceof \Mock\Config\Adapter);
    }
    
    public function testSetGetEnvironment()
    {
        $config = new Config();
        $this->assertNull($config->getEnvironment());
        $c = $config->setEnvironment('testing');
        $this->assertTrue($c instanceof Config);
        $this->assertEquals('testing', $config->getEnvironment());
    }
    
    public function testSetGetAdapter()
    {
        $config = new Config();
        $c = $config->setAdapter(new \Mock\Config\Adapter());
        $this->assertTrue($c instanceof Config);
        $this->assertTrue($config->getAdapter() instanceof \Mock\Config\Adapter);
    }
    
    public function testGetAdapterException()
    {
        $this->setExpectedException('Commons\\Exception\\NotFoundException');
        $config = new Config();
        $config->getAdapter();
    }
    
    public function testLoad()
    {
        $config = new Config('testing', new \Mock\Config\Adapter());
        $config->load('test');
        $this->assertEquals('test', $config->loadable);
    }
    
    public function testLoadFromFile()
    {
        $config = new Config('testing', new \Mock\Config\Adapter());
        $config->loadFromFile('test');
        $this->assertEquals('test', $config->filename);
    }
    
}
