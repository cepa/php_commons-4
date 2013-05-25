<?php

/**
 * =============================================================================
 * @file        Commons/Http/Plugin/AssetUrlPluginTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Http\Plugin;

use Commons\Template\PhpTemplate;

class AssetUrlPluginTest extends \PHPUnit_Framework_TestCase
{
    
    public function testInvokeHttp()
    {
        $_SERVER = array(
            'HTTP_HOST' => 'example.com',
            'SCRIPT_NAME' => '/some/app/index.php'
        );
        $plugin = new AssetUrlPlugin();
        $plugin->setInvoker(new PhpTemplate());
        $this->assertEquals('http://example.com/some/app/xxx', $plugin->assetUrl('/xxx'));
    }
    
}
