<?php

/**
 * =============================================================================
 * @file       Commons/FileSystem/FileLocatorTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\FileSystem;

class FileLocatorTest extends \PHPUnit_Framework_TestCase
{
    
    public function testLocator()
    {
        $locator = new FileLocator();
        $this->assertEquals(0, count($locator->getLocations()));
        $this->assertFalse($locator->hasLocation('xxx'));
        $this->assertFalse($locator->locate('xxx'));
        
        $l = $locator->addLocation(ROOT_PATH.'/test/fixtures');
        $this->assertTrue($l instanceof FileLocator);
        $this->assertTrue($locator->hasLocation(ROOT_PATH.'/test/fixtures'));
        $this->assertEquals(1, count($locator->getLocations()));
        
        $path = ROOT_PATH.'/test/fixtures/test_script_view.phtml';
        $this->assertEquals($path, $locator->locate('test_script_view.phtml'));
        $this->assertFalse($locator->locate('xxx'));
        
        $l = $locator->setLocations(array('xxx', 'yyy', 'zzz'));
        $this->assertTrue($l instanceof FileLocator);
        $this->assertEquals(3, count($locator->getLocations()));
        $this->assertTrue($locator->hasLocation('xxx'));
        $this->assertFalse($locator->locate('xxx'));
        
        $l = $locator->removeLocation('xxx');
        $this->assertTrue($l instanceof FileLocator);
        $this->assertEquals(2, count($locator->getLocations()));
        $this->assertFalse($locator->hasLocation('xxx'));
    }
    
}
