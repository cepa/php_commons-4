<?php

/**
 * =============================================================================
 * @file        Commons/Moo/MooTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Moo;

use Commons\Callback\Callback;
use Commons\Http\Response;
use Commons\Http\Request;
use Commons\Light\Route\StaticRoute;
use Commons\Light\Route\RouteInterface;

class MooTest extends \PHPUnit_Framework_TestCase
{
    
    public function testSetGetBaseUri()
    {
        $_SERVER['SCRIPT_NAME'] = '/php_commons-4-feature-moo/examples/moo/index.php';
        $moo = new Moo();
        $this->assertEquals('/php_commons-4-feature-moo/examples/moo', $moo->getBaseUri());
        $m = $moo->setBaseUri('xxx');
        $this->assertTrue($m instanceof Moo);
        $this->assertEquals('xxx', $moo->getBaseUri());
    }
    
    public function testSetGetRequest()
    {
        $moo = new Moo();
        $this->assertTrue($moo->getRequest() instanceof Request);
        $m = $moo->setRequest(new Request());
        $this->assertTrue($m instanceof Moo);
        $this->assertTrue($moo->getRequest() instanceof Request);
    }

    public function testSetGetResponse()
    {
        $moo = new Moo();
        $this->assertTrue($moo->getResponse() instanceof Response);
        $m = $moo->setResponse(new Response());
        $this->assertTrue($m instanceof Moo);
        $this->assertTrue($moo->getResponse() instanceof Response);
    }

    public function testSetGetHasRemoveCallback()
    {
        $moo = new Moo();
        $this->assertFalse($moo->hasCallback('xxx'));
        $m = $moo->setCallback('xxx', function($moo){});
        $this->assertTrue($m instanceof Moo);
        $this->assertTrue($moo->hasCallback('xxx'));
        $this->assertTrue($moo->getCallback('xxx') instanceof Callback);
        $m = $moo->removeCallback('xxx');
        $this->assertTrue($m instanceof Moo);
        $this->assertFalse($moo->hasCallback('xxx'));
    }
    
    public function testGetCallbackException()
    {
        $this->setExpectedException('\Commons\Moo\Exception');
        $moo = new Moo();
        $moo->getCallback('xxx');
    }
    
    public function testSetGetCallbacks()
    {
        $moo = new Moo();
        $this->assertEquals(0, count($moo->getCallbacks()));
        $m = $moo->setCallbacks(array(
            'xxx' => function($moo){},
            'yyy' => function($moo){}
        ));
        $this->assertTrue($m instanceof Moo);
        $this->assertEquals(2, count($moo->getCallbacks()));
        $this->assertTrue($moo->hasCallback('xxx'));
    }
    
    public function testSetGetHasRemoveRoute()
    {
        $moo = new Moo();
        $this->assertFalse($moo->hasRoute('xxx'));
        $m = $moo->setRoute('xxx', new StaticRoute('xxx'));
        $this->assertTrue($m instanceof Moo);
        $this->assertTrue($moo->hasRoute('xxx'));
        $this->assertTrue($moo->getRoute('xxx') instanceof RouteInterface);
        $m = $moo->removeRoute('xxx');
        $this->assertTrue($m instanceof Moo);
        $this->assertFalse($moo->hasRoute('xxx'));
    }
    
    public function testGetRouteException()
    {
        $this->setExpectedException('\Commons\Moo\Exception');
        $moo = new Moo();
        $moo->getRoute('xxx');
    }
    
    public function testSetGetRoutes()
    {
        $moo = new Moo();
        $this->assertEquals(0, count($moo->getRoutes()));
        $m = $moo->setRoutes(array(
            'xxx' => new StaticRoute('xxx'),
            'yyy' => new StaticRoute('yyy')
        ));
        $this->assertTrue($m instanceof Moo);
        $this->assertEquals(2, count($moo->getRoutes()));
        $this->assertTrue($moo->hasRoute('xxx'));
    }
    
    public function testInit()
    {
        $moo = new Moo();
        $this->assertFalse($moo->hasCallback('init'));
        $moo->init(function($moo){});
        $this->assertTrue($moo->hasCallback('init'));
    }
    
    public function testError()
    {
        $moo = new Moo();
        $this->assertFalse($moo->hasCallback('error'));
        $moo->error(function($moo, $e){});
        $this->assertTrue($moo->hasCallback('error'));
    }
    
    public function testAction()
    {
        $moo = new Moo();
        $this->assertFalse($moo->hasCallback('HEAD xxx'));
        $this->assertFalse($moo->hasRoute('HEAD xxx'));
        $moo->action('HEAD', '/xxx', function($moo){});
        $this->assertTrue($moo->hasCallback('HEAD xxx'));
        $this->assertTrue($moo->hasRoute('HEAD xxx'));
    }
    
    public function testGet()
    {
        $moo = new Moo();
        $this->assertFalse($moo->hasCallback('GET xxx'));
        $this->assertFalse($moo->hasRoute('GET xxx'));
        $moo->get('/xxx', function($moo){});
        $this->assertTrue($moo->hasCallback('GET xxx'));
        $this->assertTrue($moo->hasRoute('GET xxx'));
    }
    
    public function testPost()
    {
        $moo = new Moo();
        $this->assertFalse($moo->hasCallback('POST xxx'));
        $this->assertFalse($moo->hasRoute('POST xxx'));
        $moo->post('/xxx', function($moo){});
        $this->assertTrue($moo->hasCallback('POST xxx'));
        $this->assertTrue($moo->hasRoute('POST xxx'));
    }
    
    public function testPut()
    {
        $moo = new Moo();
        $this->assertFalse($moo->hasCallback('PUT xxx'));
        $this->assertFalse($moo->hasRoute('PUT xxx'));
        $moo->put('/xxx', function($moo){});
        $this->assertTrue($moo->hasCallback('PUT xxx'));
        $this->assertTrue($moo->hasRoute('PUT xxx'));
    }
    
    public function testDelete()
    {
        $moo = new Moo();
        $this->assertFalse($moo->hasCallback('DELETE xxx'));
        $this->assertFalse($moo->hasRoute('DELETE xxx'));
        $moo->delete('/xxx', function($moo){});
        $this->assertTrue($moo->hasCallback('DELETE xxx'));
        $this->assertTrue($moo->hasRoute('DELETE xxx'));
    }
    
    public function testMooIndex()
    {
        $moo = new Moo();
        $moo
            ->get('/', function($moo){ echo "index"; })
            ->moo();
    }
    
    public function testMooClosures()
    {
        $moo = new Moo();
        $x = $moo
            ->closure('xxx', function($moo, $x){ return $x; })
            ->xxx(666);
        $this->assertEquals(666, $x);
    }
    
}
