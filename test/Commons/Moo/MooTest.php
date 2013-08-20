<?php

/**
 * =============================================================================
 * @file       Commons/Moo/MooTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Moo;

use Commons\Service\ServiceManagerInterface;

use Commons\Service\ServiceManager;

use Commons\Callback\Callback;
use Commons\Http\Response;
use Commons\Http\Request;
use Commons\Light\Route\StaticRoute;
use Commons\Light\Route\RouteInterface;
use Commons\Plugin\PluginBroker;

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
    
    public function testSetGetPluginBroker()
    {
        $moo = new Moo();
        $this->assertTrue($moo->getPluginBroker() instanceof PluginBroker);
        $m = $moo->setPluginBroker(new PluginBroker());
        $this->assertTrue($m instanceof Moo);
        $this->assertTrue($moo->getPluginBroker() instanceof PluginBroker);
    }
    
    public function testSetGetServiceManager()
    {
        $moo = new Moo();
        $m = $moo->setServiceManager(new ServiceManager());
        $this->assertTrue($m instanceof Moo);
        $this->assertTrue($moo->getServiceManager() instanceof ServiceManagerInterface);
    }
    
    public function testGetServiceManagerException()
    {
        $this->setExpectedException('\Commons\Moo\Exception');
        $moo = new Moo();
        $moo->getServiceManager();
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
    
    public function testHead()
    {
        $moo = new Moo();
        $this->assertFalse($moo->hasCallback('HEAD xxx'));
        $this->assertFalse($moo->hasRoute('HEAD xxx'));
        $moo->head('/xxx', function($moo){});
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
    
    public function testTrace()
    {
        $moo = new Moo();
        $this->assertFalse($moo->hasCallback('TRACE xxx'));
        $this->assertFalse($moo->hasRoute('TRACE xxx'));
        $moo->trace('/xxx', function($moo){});
        $this->assertTrue($moo->hasCallback('TRACE xxx'));
        $this->assertTrue($moo->hasRoute('TRACE xxx'));
    }
    
    public function testOptions()
    {
        $moo = new Moo();
        $this->assertFalse($moo->hasCallback('OPTIONS xxx'));
        $this->assertFalse($moo->hasRoute('OPTIONS xxx'));
        $moo->options('/xxx', function($moo){});
        $this->assertTrue($moo->hasCallback('OPTIONS xxx'));
        $this->assertTrue($moo->hasRoute('OPTIONS xxx'));
    }
    
    public function testConnect()
    {
        $moo = new Moo();
        $this->assertFalse($moo->hasCallback('CONNECT xxx'));
        $this->assertFalse($moo->hasRoute('CONNECT xxx'));
        $moo->connect('/xxx', function($moo){});
        $this->assertTrue($moo->hasCallback('CONNECT xxx'));
        $this->assertTrue($moo->hasRoute('CONNECT xxx'));
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
    
    public function testMooPlugin()
    {
        $_SERVER = array(
            'HTTP_HOST' => 'example.com',
            'SCRIPT_NAME' => '/some/app/index.php'
        );
        $moo = new Moo();
        $this->assertEquals('http://example.com/some/app/xxx', $moo->assetUrl('/xxx'));
    }
    
}
