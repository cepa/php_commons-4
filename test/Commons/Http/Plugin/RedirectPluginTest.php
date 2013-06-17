<?php

/**
 * =============================================================================
 * @file       Commons/Http/Plugin/RedirectPluginTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Http\Plugin;

use Commons\Moo\Moo;

class RedirectPluginTest extends \PHPUnit_Framework_TestCase
{
    
    public function testRedirect()
    {
        $_SERVER = array(
            'HTTP_HOST' => 'example.com',
            'SCRIPT_NAME' => '/some/app/index.php'
        );
        $moo = new Moo();
        $plugin = new RedirectPlugin();
        $plugin->enableExit(false);
        $plugin->setInvoker($moo);
        $plugin->redirect('xxx');
        $this->assertEquals('http://example.com/some/app/xxx', $moo->getResponse()->getHeader('Location'));
    }
    
    public function testRedirectToUrl()
    {
        $moo = new Moo();
        $plugin = new RedirectPlugin();
        $plugin->enableExit(false);
        $plugin->setInvoker($moo);
        $plugin->redirect('http://google.com');
        $this->assertEquals('http://google.com', $moo->getResponse()->getHeader('Location'));
    }
    
}
