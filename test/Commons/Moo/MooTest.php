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

use Commons\Buffer\OutputBuffer;
use Commons\Callback\Callback;
use Commons\Http\Response;
use Commons\Http\Request;
use Commons\Light\Route\StaticRoute;
use Commons\Light\Route\RouteInterface;
use Commons\Plugin\PluginBroker;
use Commons\Service\ServiceManager;
use Commons\Service\ServiceManagerInterface;

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
        $this->assertFalse($moo->hasCallback('action HEAD xxx'));
        $this->assertFalse($moo->hasRoute('action HEAD xxx'));
        $moo->action('HEAD', '/xxx', function($moo){});
        $this->assertTrue($moo->hasCallback('action HEAD xxx'));
        $this->assertTrue($moo->hasRoute('action HEAD xxx'));
    }

    public function testRoute()
    {
        $moo = new Moo();
        $this->assertFalse($moo->hasCallback('action xxx'));
        $this->assertFalse($moo->hasRoute('action xxx'));
        $moo->route('/xxx', function($moo){});
        $this->assertTrue($moo->hasCallback('action xxx'));
        $this->assertTrue($moo->hasRoute('action xxx'));
    }

    public function testHead()
    {
        $moo = new Moo();
        $this->assertFalse($moo->hasCallback('action HEAD xxx'));
        $this->assertFalse($moo->hasRoute('action HEAD xxx'));
        $moo->head('/xxx', function($moo){});
        $this->assertTrue($moo->hasCallback('action HEAD xxx'));
        $this->assertTrue($moo->hasRoute('action HEAD xxx'));
    }

    public function testGet()
    {
        $moo = new Moo();
        $this->assertFalse($moo->hasCallback('action GET xxx'));
        $this->assertFalse($moo->hasRoute('action GET xxx'));
        $moo->get('/xxx', function($moo){});
        $this->assertTrue($moo->hasCallback('action GET xxx'));
        $this->assertTrue($moo->hasRoute('action GET xxx'));
    }

    public function testPost()
    {
        $moo = new Moo();
        $this->assertFalse($moo->hasCallback('action POST xxx'));
        $this->assertFalse($moo->hasRoute('action POST xxx'));
        $moo->post('/xxx', function($moo){});
        $this->assertTrue($moo->hasCallback('action POST xxx'));
        $this->assertTrue($moo->hasRoute('action POST xxx'));
    }

    public function testPut()
    {
        $moo = new Moo();
        $this->assertFalse($moo->hasCallback('action PUT xxx'));
        $this->assertFalse($moo->hasRoute('action PUT xxx'));
        $moo->put('/xxx', function($moo){});
        $this->assertTrue($moo->hasCallback('action PUT xxx'));
        $this->assertTrue($moo->hasRoute('action PUT xxx'));
    }

    public function testDelete()
    {
        $moo = new Moo();
        $this->assertFalse($moo->hasCallback('action DELETE xxx'));
        $this->assertFalse($moo->hasRoute('action DELETE xxx'));
        $moo->delete('/xxx', function($moo){});
        $this->assertTrue($moo->hasCallback('action DELETE xxx'));
        $this->assertTrue($moo->hasRoute('action DELETE xxx'));
    }

    public function testTrace()
    {
        $moo = new Moo();
        $this->assertFalse($moo->hasCallback('action TRACE xxx'));
        $this->assertFalse($moo->hasRoute('action TRACE xxx'));
        $moo->trace('/xxx', function($moo){});
        $this->assertTrue($moo->hasCallback('action TRACE xxx'));
        $this->assertTrue($moo->hasRoute('action TRACE xxx'));
    }

    public function testOptions()
    {
        $moo = new Moo();
        $this->assertFalse($moo->hasCallback('action OPTIONS xxx'));
        $this->assertFalse($moo->hasRoute('action OPTIONS xxx'));
        $moo->options('/xxx', function($moo){});
        $this->assertTrue($moo->hasCallback('action OPTIONS xxx'));
        $this->assertTrue($moo->hasRoute('action OPTIONS xxx'));
    }

    public function testConnect()
    {
        $moo = new Moo();
        $this->assertFalse($moo->hasCallback('action CONNECT xxx'));
        $this->assertFalse($moo->hasRoute('action CONNECT xxx'));
        $moo->connect('/xxx', function($moo){});
        $this->assertTrue($moo->hasCallback('action CONNECT xxx'));
        $this->assertTrue($moo->hasRoute('action CONNECT xxx'));
    }

    public function testMooIndex()
    {
        OutputBuffer::start();
        $moo = new Moo();
        $response = $moo
            ->get('/', function($moo){ echo "index"; })
            ->moo();
        $response->send();
        $content = OutputBuffer::end();
        $this->assertEquals('index', $content);
        $this->assertTrue($response instanceof Response);
        $this->assertEquals('index', $response->getBody());
    }

    public function testMooRouteAny()
    {
        OutputBuffer::start();
        $moo = new Moo();
        $moo->getRequest()->setMethod('HEAD');
        $response = $moo
            ->route('/', function($moo){ echo "ok"; })
            ->head('/', function($moo){ echo "fail"; })
            ->moo();
        $response->send();
        $content = OutputBuffer::end();
        $this->assertEquals('ok', $content);
        $this->assertTrue($response instanceof Response);
        $this->assertEquals('ok', $response->getBody());
    }

    public function testMooClosures()
    {
        $moo = new Moo();
        $x = $moo
            ->closure('xxx', function($moo, $x){ return $x; })
            ->xxx(666);
        $this->assertEquals(666, $x);
    }

    public function testMooPluginAlias()
    {
        $moo = new Moo();
        $x = $moo
            ->plugin('xxx', function($moo, $x){ return $x; })
            ->xxx(666);
        $this->assertEquals(666, $x);
        $this->assertTrue($moo->hasPlugin('xxx'));
        $this->assertFalse($moo->hasPlugin('yyy'));
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

    public function testRequestFactory()
    {
        $moo = new Moo();
        $moo->setRequestFactory(function(){
            $request = new Request();
            $request->setUri('test');
            return $request;
        });
        $this->assertEquals('test', $moo->getRequest()->getUri());
    }

    public function testMooPreDispatch()
    {
        $moo = new Moo();
        $moo
            ->preDispatch(function (Moo $moo) {
                $moo->getResponse()->appendBody('pre ');
            })
            ->get('/', function (Moo $moo) {
                return 'index';
            })
            ;
        $this->assertEquals('pre index', $moo->dispatch()->getBody());
    }

    public function testMooPostDispatch()
    {
        $moo = new Moo();
        $moo
            ->postDispatch(function (Moo $moo) {
                $moo->getResponse()->appendBody(' post');
            })
            ->get('/', function (Moo $moo) {
                return 'index';
            })
            ;
        $this->assertEquals('index post', $moo->dispatch()->getBody());
    }

    public function testNestedRouterIndex()
    {
        $request = new Request();
        $request->setUri('/');
        $response = $this->createNestedRouting()
            ->setRequest($request)
            ->dispatch();
        $this->assertEquals('index', $response->getBody());
    }

    public function testNestedRouterGetNewsList()
    {
        $request = new Request();
        $request->setUri('/news');
        $response = $this->createNestedRouting()
            ->setRequest($request)
            ->dispatch();
        $this->assertEquals('get news list', $response->getBody());
    }

    public function testNestedRouterGetNewsById()
    {
        $request = new Request();
        $request->setUri('/news/123');
        $response = $this->createNestedRouting()
            ->setRequest($request)
            ->dispatch();
        $this->assertEquals('get news 123', $response->getBody());
    }

    public function testNestedRouterPutNewsById()
    {
        $request = new Request();
        $request
            ->setUri('/news/123')
            ->setMethod('PUT')
            ->setBody('xxx');
        $response = $this->createNestedRouting()
            ->setRequest($request)
            ->dispatch();
        $this->assertEquals('put news 123 xxx', $response->getBody());
    }

    public function testNestedRouterGetCommentsList()
    {
        $request = new Request();
        $request->setUri('/comments');
        $response = $this->createNestedRouting()
            ->setRequest($request)
            ->dispatch();
        $this->assertEquals('get comments list', $response->getBody());
    }

    public function testNestedRouterPostComment()
    {
        $request = new Request();
        $request
            ->setUri('/comments')
            ->setMethod('POST')
            ->setBody('foo');
        $response = $this->createNestedRouting()
            ->setRequest($request)
            ->dispatch();
        $this->assertEquals('post comment foo', $response->getBody());
    }

    public function testNestedRouterRewind()
    {
        $request = new Request();
        $request->setUri('/foo/hoo');
        $response = $this->createNestedRouting()
            ->setRequest($request)
            ->dispatch();
        $this->assertEquals('get news 666', $response->getBody());
    }

    public function createNestedRouting()
    {
        $moo = new Moo();
        $moo

            ->plugin('getBody', function (Moo $moo) {
                return $moo->getRequest()->getBody();
            })

            ->get('/', function (Moo $moo) {
                return 'index';
            })

            ->route('/news(.*)', function (Moo $moo) {
                return $moo

                    ->get('/news', function (Moo $moo) {
                        return 'get news list';
                    })

                    ->route('/news/(.*)', function (Moo $moo) {
                        return $moo

                            ->get('/news/(.*)', function (Moo $moo, $id) {
                                return 'get news '.$id;
                            })

                            ->put('/news/(.*)', function (Moo $moo, $id) {
                                return 'put news '.$id.' '.$moo->getBody();
                            })

                            ->dispatch();
                    })

                    ->dispatch();
            })

            ->route('/comments(.*)', function (Moo $moo) {
                return $moo

                    ->get('/comments', function (Moo $moo) {
                        return 'get comments list';
                    })

                    ->post('/comments', function (Moo $moo) {
                        return 'post comment '.$moo->getBody();
                    })

                    ->dispatch();
            })

            ->route('/foo(.*)', function (Moo $moo) {
                return $moo

                    ->route('/foo/hoo(.*)', function (Moo $moo) {
                        $request = clone $moo->getRequest();
                        $request->setUri('/news/666');
                        return $moo->setRequest($request)->rewind()->dispatch();
                    })

                    ->dispatch();
            })

            ;

        return $moo;
    }

}
