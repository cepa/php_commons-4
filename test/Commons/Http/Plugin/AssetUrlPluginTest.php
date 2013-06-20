<?php

/**
 * =============================================================================
 * @file       Commons/Http/Plugin/AssetUrlPluginTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Http\Plugin;

use Commons\Light\View\Phtml\Script;

class AssetUrlPluginTest extends \PHPUnit_Framework_TestCase
{
    
    public function testInvokeHttp()
    {
        $_SERVER = array(
            'HTTP_HOST' => 'example.com',
            'SCRIPT_NAME' => '/some/app/index.php'
        );
        $plugin = new AssetUrlPlugin();
        $plugin->setInvoker(new Script());
        $this->assertEquals('http://example.com/some/app/xxx', $plugin->assetUrl('/xxx'));
    }
    
}
