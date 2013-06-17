<?php

/**
 * =============================================================================
 * @file       Commons/Xml/WriterTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Xml;

class WriterTest extends \PHPUnit_Framework_TestCase
{
    
    public function testWriter1()
    {
        $xml = $this->parse(\Mock\Xml\Fixtures::FIXTURE1);
        $this->assertEquals(0, count($xml));
        $this->assertEquals('test', $xml->getName());
        $this->assertEquals("\n", $xml->getText());
    }
    
    public function testWriter2()
    {
        $xml = $this->parse(\Mock\Xml\Fixtures::FIXTURE2);
        $this->assertEquals(0, count($xml));
        $this->assertEquals('test', $xml->getName());
        $this->assertEquals("some data", $xml->getText());
    }
    
    public function testWriter3()
    {
        $xml = $this->parse(\Mock\Xml\Fixtures::FIXTURE3);
        $this->assertEquals(3, count($xml));
        $this->assertEquals('tests', $xml->getName());
        $this->assertEquals('a', $xml[0]);
        $this->assertEquals('b', $xml[1]);
        $this->assertEquals('c', $xml[2]);
    }
    
    public function testWriter4()
    {
        $xml = $this->parse(\Mock\Xml\Fixtures::FIXTURE4);
        $this->assertEquals(3, count($xml));
        $this->assertEquals('tests', $xml->getName());
        $this->assertEquals(123, (int) (string) $xml->a);
        $this->assertEquals(456, (int) (string) $xml->b);
        $this->assertEquals(789, (int) (string) $xml->c);
    }
    
    public function testWriter5()
    {
        $xml = $this->parse(\Mock\Xml\Fixtures::FIXTURE5);
        $this->assertEquals(3, count($xml));
        $this->assertEquals('tests', $xml->getName());
        $result = 0;
        foreach ($xml as $node) {
            foreach ($node as $number) {
                $result += (int) (string) $number;
            }
        }
        $this->assertEquals(45, $result);
    }
    
    public function testWriter6()
    {
        $xml = $this->parse(\Mock\Xml\Fixtures::FIXTURE6);
        $this->assertEquals(1, count($xml));
        $this->assertEquals('tests', $xml->getName());
        $this->assertEquals(666, (int) (string) $xml->a->b->c);
    }
    
    public function testWriter7()
    {
        $xml = $this->parse(\Mock\Xml\Fixtures::FIXTURE7);
        $this->assertEquals(1, count($xml));
        $this->assertEquals('tests', $xml->getName());
        
        $this->assertEquals(123, $xml->getAttribute('a'));
        $this->assertEquals(456, $xml->getAttribute('b'));
        $this->assertEquals(789, $xml->getAttribute('c'));
        
        $this->assertEquals('xyz', $xml->test->getAttribute('a'));
        $this->assertEquals('zyx', $xml->test->getAttribute('b'));
    }
    
    public function testWriteToFile()
    {
        $xml = Xml::createFromString(\Mock\Xml\Fixtures::FIXTURE7);
        $filename = ROOT_PATH.'/test/tmp/test_xml_writer.xml';
        $writer = new Writer();
        $writer->writeToFile($xml, $filename);
        $this->assertTrue(file_exists($filename));
        
        $xml = Xml::createFromFile($filename);
        $this->assertEquals(1, count($xml));
        $this->assertEquals('tests', $xml->getName());
        
        $this->assertEquals(123, $xml->getAttribute('a'));
        $this->assertEquals(456, $xml->getAttribute('b'));
        $this->assertEquals(789, $xml->getAttribute('c'));
        
        $this->assertEquals('xyz', $xml->test->getAttribute('a'));
        $this->assertEquals('zyx', $xml->test->getAttribute('b'));
    }
    
    public function parse($str)
    {
        $xml = Xml::createFromString($str);
        $writer = new Writer();
        $str = $writer->writeToString($xml);
        $xml = Xml::createFromString($str);
        $this->assertTrue($xml instanceof Xml);
        return $xml;
    }
    
}
