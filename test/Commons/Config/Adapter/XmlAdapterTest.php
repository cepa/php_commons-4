<?php

/**
 * =============================================================================
 * @file        Commons/Config/Adapter/XmlAdapterTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Config\Adapter;

use Commons\Xml\Xml;
use Commons\Config\XmlConfig;

class XmlAdapterTest extends \PHPUnit_Framework_TestCase
{
    
    const FIXTURE1 = 
    "<config><a>123</a><b>456</b><c/></config>";

    public function testLoadString()
    {
        $config = new XmlConfig();
        $config->load(self::FIXTURE1);
        $this->assertTrue(isset($config->a));
        $this->assertTrue(isset($config->b));
        $this->assertTrue(isset($config->c));
        $this->assertEquals(123, (int) (string) $config->a);
        $this->assertEquals(456, (int) (string) $config->b);
    }
    
    public function testLoadXml()
    {
        $xml = Xml::createFromString(self::FIXTURE1);
        $config = new XmlConfig();
        $config->load($xml);
        $this->assertTrue(isset($config->a));
        $this->assertTrue(isset($config->b));
        $this->assertTrue(isset($config->c));
        $this->assertEquals(123, (int) (string) $config->a);
        $this->assertEquals(456, (int) (string) $config->b);
    }
    
    public function testLoadInvalidArgument()
    {
        $this->setExpectedException('Commons\\Config\\Adapter\\Exception');
        $config = new XmlConfig();
        $config->load(new \stdClass);
    }
    
    public function testLoadFromFile()
    {
        $config = new XmlConfig();
        $config->loadFromFile(ROOT_PATH.'/test/fixtures/test_config_adapter_xml.xml');
        
        $this->assertTrue(isset($config->application));
        $this->assertEquals('http://localhost', (string) $config->application->host);
        $this->assertEquals('/php_commons/', (string) $config->application->uri);
        
        $this->assertTrue(isset($config->database));
        $this->assertEquals('localhost', (string) $config->database->host);
        $this->assertEquals('1234', (string) $config->database->port);
        $this->assertEquals('php_commons', (string) $config->database->dbname);
        $this->assertEquals('root', (string) $config->database->username);
        $this->assertEquals('secret', (string) $config->database->password);
    }
    
    public function testLoadFromFileWithEnv()
    {
        $config = new XmlConfig();
        $config
            ->setEnvironment('testing')
            ->loadFromFile(ROOT_PATH.'/test/fixtures/test_config_adapter_xml_env.xml');

        $this->assertTrue(isset($config->application));
        $this->assertEquals('12', (string) $config->application->test1);
        $this->assertEquals('34', (string) $config->application->test2);
        
        $this->assertTrue(isset($config->database));
        $this->assertEquals('56', (string) $config->database->test1);
        $this->assertEquals('78', (string) $config->database->test2);
    }
    
    public function testLoadFromFileWithExtends()
    {
        $config = new XmlConfig();
        $config
            ->setEnvironment('testing')
            ->loadFromFile(ROOT_PATH.'/test/fixtures/test_config_adapter_xml_ext.xml');
        
        $this->assertTrue(isset($config->api));
        $this->assertEquals('http://localhost/testing_php_commons/', $config->api->url);
        $this->assertEquals('1234', $config->api->id);
        
        $this->assertTrue(isset($config->application));
        $this->assertEquals('http://localhost', $config->application->host);
        $this->assertEquals('/testing_php_commons/', $config->application->uri);
        
        $this->assertTrue(isset($config->database));
        $this->assertEquals('localhost', $config->database->host);
        $this->assertEquals('1234', $config->database->port);
        $this->assertEquals('php_commons', $config->database->dbname);
        $this->assertEquals('root', $config->database->username);
        $this->assertEquals('secret', $config->database->password);
    }
    
}
