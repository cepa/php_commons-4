<?php

/**
 * =============================================================================
 * @file        Commons/Template/Plugin/BaseUrlPluginTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Template\Plugin;

class BaseUrlPluginTest extends \PHPUnit_Framework_TestCase
{
    
    public function testInvokeHttp()
    {
        $_SERVER = array(
            'HTTP_HOST' => 'example.com',
            'SCRIPT_NAME' => '/some/app/index.php'
        );
        $plugin = new BaseUrlPlugin();
        $this->assertEquals('http://example.com/some/app', $plugin->baseUrl());
    }
    
    public function testInvokeHttps()
    {
        $_SERVER = array(
            'HTTP_HOST' => 'example.com',
            'SCRIPT_NAME' => '/some/app/index.php',
            'HTTPS' => 'on'
        );
        $plugin = new BaseUrlPlugin();
        $this->assertEquals('https://example.com/some/app', $plugin->baseUrl());
    }
    
}
