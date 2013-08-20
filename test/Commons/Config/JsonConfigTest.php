<?php

/**
 * =============================================================================
 * @file       Commons/Config/JsonConfigTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Config;

class JsonConfigTest extends \PHPUnit_Framework_TestCase
{

    public function testConfig()
    {
        $filename = ROOT_PATH.'/test/fixtures/test_config_json.json';

        $config = new JsonConfig();
        $config->loadFromFile($filename);

        $this->assertEquals('https://github.com/cepa/php_commons-4', (string) $config->homepage);
        $this->assertEquals('PHP Commons Contributors', (string) $config->authors[0]->name);
        $this->assertEquals('test/', (string) $config->autoload->{'psr-0'}->Mock);
        $this->assertEquals('src/', (string) $config->autoload->{'psr-0'}->Commons[0]);
    }
    
    public function testInvalidConfig()
    {
        $this->setExpectedException('\Commons\Json\Exception');
        $filename = ROOT_PATH.'/test/fixtures/test_config_xml.xml';
        $config = new JsonConfig();
        $config->loadFromFile($filename);
    }
        
}
