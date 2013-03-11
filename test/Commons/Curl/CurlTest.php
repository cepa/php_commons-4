<?php

/**
 * =============================================================================
 * @file        Commons/Curl/CurlTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Curl;

class CurlTest extends \PHPUnit_Framework_TestCase
{

    public function testCall()
    {
        $url = 'http://demo.hellworx.com/example.xml';
        $curl = new Curl($url);
        $response = $curl
            ->setReferer('http://localhost')
            ->setUserAgent('some useragent')
            ->setEncoding('gzip')
            ->setTimeout(10)
            ->execute()
            ->getResponse();
        $this->assertContains("Don't forget me this weekend!", $response);
        $this->assertEquals(200, $curl->getResponseCode());
        $this->assertEquals('application/xml', $curl->getResponseContentType());
        $this->assertEquals(strlen($response), $curl->getResponseContentLength());
    }
    
    public function testParseJson()
    {
        $url = 'http://demo.hellworx.com/example.json';
        $curl = new Curl($url);
        $json = $curl->execute()->parseJsonResponse();
        $this->assertEquals('Anna', $json['employees'][1]['firstName']);
    }
    
    public function testParseXml()
    {
        $url = 'http://demo.hellworx.com/example.xml';
        $curl = new Curl($url);
        $xml = $curl->execute()->parseXmlResponse();
        $this->assertEquals("Don't forget me this weekend!", (string) $xml->body);
    }
    
}
