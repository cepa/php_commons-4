<?php

/**
 * =============================================================================
 * @file       Commons/Config/XmlConfigTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Config;

class XmlConfigTest extends \PHPUnit_Framework_TestCase
{

    public function testManyTimesExtendedXml()
    {
        $filename = ROOT_PATH.'/test/fixtures/test_config_xml.xml';

        $xml = new XmlConfig();
        $xml
            ->setEnvironment('a')
            ->loadFromFile($filename);
        $this->assertEquals('123', (string) $xml->x);
        $this->assertEquals('456', (string) $xml->y);
        $this->assertEquals('789', (string) $xml->z);

        $xml = new XmlConfig();
        $xml
            ->setEnvironment('b')
            ->loadFromFile($filename);
        $this->assertEquals('321', (string) $xml->x);
        $this->assertEquals('456', (string) $xml->y);
        $this->assertEquals('789', (string) $xml->z);

        $xml = new XmlConfig();
        $xml
            ->setEnvironment('c')
            ->loadFromFile($filename);
        $this->assertEquals('321', (string) $xml->x);
        $this->assertEquals('654', (string) $xml->y);
        $this->assertEquals('789', (string) $xml->z);

        $xml = new XmlConfig();
        $xml
            ->setEnvironment('d')
            ->loadFromFile($filename);
        $this->assertEquals('321', (string) $xml->x);
        $this->assertEquals('654', (string) $xml->y);
        $this->assertEquals('987', (string) $xml->z);

        $xml = new XmlConfig();
        $xml
            ->setEnvironment('e')
            ->loadFromFile($filename);
        $this->assertEquals('321', (string) $xml->x);
        $this->assertEquals('654', (string) $xml->y);
        $this->assertEquals('987', (string) $xml->z);
    }
        
}
