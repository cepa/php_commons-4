<?php

/**
 * =============================================================================
 * @file        Commons/Template/Plugin/AssetUrlPluginTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Template\Plugin;

use Mock\Plugin\Extendable as MockExtendable;

class AssetUrlPluginTest extends \PHPUnit_Framework_TestCase
{
    
    public function testInvokeHttp()
    {
        $_SERVER = array(
            'HTTP_HOST' => 'example.com',
            'SCRIPT_NAME' => '/some/app/index.php'
        );
        $extendable = new MockExtendable();
        $extendable->getPluginBroker()->addNamespace('\\Commons\\Template\\Plugin');
        $this->assertEquals('http://example.com/some/app/xxx', $extendable->assetUrl('/xxx'));
    }
    
}
