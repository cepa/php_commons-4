<?php

/**
 * =============================================================================
 * @file       Commons/Http/RequestTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Http;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    
    public function testSetGetClearParams()
    {
        $request = new Request();
        $this->assertEquals(0, count($request->getParams()));
        $r = $request->setParams(array('x' => 123, 'y' => 456));
        $this->assertTrue($r instanceof Request);
        $this->assertEquals(2, count($request->getParams()));
        $this->assertTrue($request->hasParam('x'));
        $this->assertEquals(456, $request->getParam('y'));
        $r = $request->clearParams();
        $this->assertTrue($r instanceof Request);
        $this->assertEquals(0, count($request->getParams()));
    }
    
    public function testSetGetHasRemoveParam()
    {
        $request = new Request();
        $this->assertFalse($request->hasParam('x'));
        $this->assertEquals(666, $request->getParam('x', 666));
    
        $r = $request->setParam('x', 123);
        $this->assertTrue($r instanceof Request);
        $this->assertEquals(1, count($request->getParams()));
        $this->assertTrue($request->hasParam('x'));
        $this->assertEquals(123, $request->getParam('x'));
    
        $this->assertFalse($request->hasParam('y'));
        $this->assertEquals(456, $request->getParam('y', 456));
    
        $r = $request->removeParam('x');
        $this->assertTrue($r instanceof Request);
        $this->assertFalse($request->hasParam('x'));
    }
    
    public function testSetGetClearPostParams()
    {
        $request = new Request();
        $this->assertEquals(0, count($request->getPostParams()));
        $r = $request->setPostParams(array('x' => 123, 'y' => 456));
        $this->assertTrue($r instanceof Request);
        $this->assertEquals(2, count($request->getPostParams()));
        $this->assertTrue($request->hasPostParam('x'));
        $this->assertEquals(456, $request->getPostParam('y'));
        $r = $request->clearPostParams();
        $this->assertTrue($r instanceof Request);
        $this->assertEquals(0, count($request->getPostParams()));
    }
    
    public function testSetGetHasRemovePostParam()
    {
        $request = new Request();
        $this->assertFalse($request->hasPostParam('x'));
        $this->assertEquals(666, $request->getPostParam('x', 666));
    
        $r = $request->setPostParam('x', 123);
        $this->assertTrue($r instanceof Request);
        $this->assertEquals(1, count($request->getPostParams()));
        $this->assertTrue($request->hasPostParam('x'));
        $this->assertEquals(123, $request->getPostParam('x'));
    
        $this->assertFalse($request->hasPostParam('y'));
        $this->assertEquals(456, $request->getPostParam('y', 456));
    
        $r = $request->removePostParam('x');
        $this->assertTrue($r instanceof Request);
        $this->assertFalse($request->hasPostParam('x'));
    }
    
    public function testSetGetHeaders()
    {
        $request = new Request();
        $this->assertEquals(0, count($request->getHeaders()));
        $r = $request->setHeaders(array('Location' => 'http://onet.pl', 'Content-Length' => 456));
        $this->assertTrue($r instanceof Request);
        $this->assertEquals(2, count($request->getHeaders()));
        $this->assertTrue($request->hasHeader('Content-Length'));
        $this->assertEquals('http://onet.pl', $request->getHeader('Location'));
        $r = $request->clearHeaders();
        $this->assertTrue($r instanceof Request);
        $this->assertEquals(0, count($request->getHeaders()));
    }
    
    public function testSetGetHasRemoveHeader()
    {
        $request = new Request();
        $this->assertFalse($request->hasHeader('X-Header'));
        $r = $request->setHeader('X-Header', 'xxx');
        $this->assertTrue($r instanceof Request);
        $this->assertTrue($request->hasHeader('X-Header'));
        $this->assertEquals('xxx', $request->getHeader('X-Header'));
        $r = $request->removeHeader('X-Header');
        $this->assertTrue($r instanceof Request);
        $this->assertFalse($request->hasHeader('X-Header'));
    }
    
    public function testGetHeaderException()
    {
        $this->setExpectedException('\\Commons\\Http\\Exception');
        $request = new Request();
        $request->getHeader('test');
    }
    
    public function testSetGetMethod()
    {
        $request = new Request();
        $this->assertEquals('GET', $request->getMethod());
        $r = $request->setMethod('post');
        $this->assertTrue($r instanceof Request);
        $this->assertEquals('POST', $request->getMethod());
    }
    
    public function testIsGetRequest()
    {
        $request = new Request();
        $this->assertTrue($request->isGetRequest());
        $request->setMethod('POST');
        $this->assertFalse($request->isGetRequest());
    }
    
    public function testIsPostRequest()
    {
        $request = new Request();
        $this->assertFalse($request->isPostRequest());
        $request->setMethod('POST');
        $this->assertTrue($request->isPostRequest());
    }
    
    public function testIsAjaxRequest()
    {
        $request = new Request();
        $this->assertFalse($request->isAjaxRequest());
        $request->setHeader('X_REQUESTED_WITH', 'XMLHttpRequest');
        $this->assertTrue($request->isAjaxRequest());
    }
    
    public function testSetGetUri()
    {
        $request = new Request();
        $this->assertNull($request->getUri());
        $r = $request->setUri('xxx');
        $this->assertTrue($r instanceof Request);
        $this->assertEquals('xxx', $request->getUri());
    }
    
    public function testSetGetBody()
    {
        $request = new Request();
        $this->assertEquals('', $request->getBody());
        $r = $request->setBody('xxx');
        $this->assertTrue($r instanceof Request);
        $this->assertEquals('xxx', $request->getBody());
    }
    
    public function testSetGetAuthUsername()
    {
        $request = new Request();
        $this->assertNull($request->getAuthUsername());
        $r = $request->setAuthUsername('xxx');
        $this->assertTrue($r instanceof Request);
        $this->assertEquals('xxx', $request->getAuthUsername());
    }
    
    public function testSetGetAuthPassword()
    {
        $request = new Request();
        $this->assertNull($request->getAuthPassword());
        $r = $request->setAuthPassword('xxx');
        $this->assertTrue($r instanceof Request);
        $this->assertEquals('xxx', $request->getAuthPassword());
    }
    
    public function testProcessHttpRequest()
    {
        $_SERVER['REQUEST_URI'] = '/test?xxx';
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['PHP_AUTH_USER'] = 'cepa';
        $_SERVER['PHP_AUTH_PW'] = 's3cret';
        $_GET = array('a' => 1, 'b' => 2, 'c' => 3);
        $_POST = array('x' => 123, 'y' => 456);
        
        $request = Request::processIncomingRequest();
        $this->assertEquals('test', $request->getUri());
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals(1, $request->getParam('a'));
        $this->assertTrue($request->hasParam('b'));
        $this->assertEquals(123, $request->getPostParam('x'));
        $this->assertTrue($request->hasPostParam('y'));
        $this->assertEquals('cepa', $request->getAuthUsername());
        $this->assertEquals('s3cret', $request->getAuthPassword());
    }
        
    public function testProcessHttpRequest2()
    {
        $_SERVER['REQUEST_URI'] = '/some/web/dir/test?xxx';
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['PHP_AUTH_USER'] = 'cepa';
        $_SERVER['PHP_AUTH_PW'] = 's3cret';
        $_GET = array('a' => 1, 'b' => 2, 'c' => 3);
        $_POST = array('x' => 123, 'y' => 456);
        
        $request = Request::processIncomingRequest('/some/web/dir/');
        $this->assertEquals('test', $request->getUri());
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals(1, $request->getParam('a'));
        $this->assertTrue($request->hasParam('b'));
        $this->assertEquals(123, $request->getPostParam('x'));
        $this->assertTrue($request->hasPostParam('y'));
        $this->assertEquals('cepa', $request->getAuthUsername());
        $this->assertEquals('s3cret', $request->getAuthPassword());
    }
    
    public function testExtractBaseUri()
    {
        $_SERVER['SCRIPT_NAME'] = '/php_commons-4-feature-moo/examples/moo/index.php';
        $baseUri = Request::extractBaseUri();
        $this->assertEquals('/php_commons-4-feature-moo/examples/moo', $baseUri);
    }
        
}
