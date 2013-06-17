<?php

/**
 * =============================================================================
 * @file       Commons/Http/ResponseTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Http;

use Commons\Buffer\OutputBuffer;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    
    public function testAppendGetClearBody()
    {
        $response = new Response();
        $this->assertEquals('', $response->getBody());
        $r = $response->appendBody('xxx');
        $this->assertTrue($r instanceof Response);
        $r = $response->appendBody('yyy');
        $this->assertEquals('xxxyyy', $response->getBody());
        $r = $response->clearBody();
        $this->assertTrue($r instanceof Response);
        $this->assertEquals('', $response->getBody());
    }
    
    public function testSetGetHeaders()
    {
        $response = new Response();
        $this->assertEquals(0, count($response->getHeaders()));
        $r = $response->setHeaders(array('Location' => 'http://onet.pl', 'Content-Length' => 456));
        $this->assertTrue($r instanceof Response);
        $this->assertEquals(2, count($response->getHeaders()));
        $this->assertTrue($response->hasHeader('Content-Length'));
        $this->assertEquals('http://onet.pl', $response->getHeader('Location'));
        $r = $response->clearHeaders();
        $this->assertTrue($r instanceof Response);
        $this->assertEquals(0, count($response->getHeaders()));
    }
    
    public function testSetGetHasRemoveHeader()
    {
        $response = new Response();
        $this->assertFalse($response->hasHeader('X-Header'));
        $r = $response->setHeader('X-Header', 'xxx');
        $this->assertTrue($r instanceof Response);
        $this->assertTrue($response->hasHeader('X-Header'));
        $this->assertEquals('xxx', $response->getHeader('X-Header'));
        $r = $response->removeHeader('X-Header');
        $this->assertTrue($r instanceof Response);
        $this->assertFalse($response->hasHeader('X-Header'));
    }
    
    public function testGetHeaderException()
    {
        $this->setExpectedException('\\Commons\\Http\\Exception');
        $response = new Response();
        $response->getHeader('test');
    }
    
    public function testSetGetStatus()
    {
        $response = new Response();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('OK', $response->getStatusMessage());
        
        $r = $response->setStatus(StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        $this->assertTrue($r instanceof Response);
        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals('Internal Server Error', $response->getStatusMessage());
        
        $r = $response->setStatus(StatusCode::HTTP_ACCEPTED, 'foo');
        $this->assertTrue($r instanceof Response);
        $this->assertEquals(202, $response->getStatusCode());
        $this->assertEquals('foo', $response->getStatusMessage());
    }
    
    public function testSend()
    {
        OutputBuffer::start();
        $response = new Response();
        $response->appendBody('test');
        $response->send();
        $this->assertEquals('test', OutputBuffer::end());
    }
    
}
