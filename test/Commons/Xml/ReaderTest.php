<?php

/**
 * =============================================================================
 * @file        Commons/Xml/ReaderTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Xml;

class ReaderTest extends \PHPUnit_Framework_TestCase
{
	
	public function testSetGetClearProperties()
	{
		$reader = new Reader();
		$this->assertEquals(0, count($reader->getProperties()));
		$r = $reader->setProperties(array('a' => 123, 'b' => 456));
		$this->assertTrue($r instanceof Reader);
		$p = $reader->getProperties();
		$this->assertEquals(2, count($p));
		$this->assertEquals(123, $p['a']);
		$this->assertEquals(456, $p['b']);
		$r = $reader->clearProperties();
		$this->assertTrue($r instanceof Reader);
		$this->assertEquals(0, count($reader->getProperties()));
	}
	
	public function testSetGetHasRemoveProperty()
	{
		$reader = new Reader();
		$this->assertFalse($reader->hasProperty('x'));
		$r = $reader->setProperty('x', 666);
		$this->assertTrue($r instanceof Reader);
		$this->assertTrue($reader->hasProperty('x'));
		$this->assertEquals(666, $reader->getProperty('x'));
		$this->assertEquals(1, count($reader->getProperties()));
		$r = $reader->removeProperty('x');
		$this->assertTrue($r instanceof Reader);
		$this->assertFalse($reader->hasProperty('x'));
		$this->assertEquals(0, count($reader->getProperties()));
	}
    
    public function testReader1()
    {
    	$reader = new Reader();
        $xml = $reader->readFromString(\Mock\Xml\Fixtures::FIXTURE1);
        $this->assertTrue($xml instanceof Xml);
        $this->assertEquals('test', $xml->getName());
    }
    
    public function testReader2()
    {
        $reader = new Reader();
        $xml = $reader->readFromString(\Mock\Xml\Fixtures::FIXTURE2);
        $this->assertTrue($xml instanceof Xml);
        $this->assertEquals('test', $xml->getName());
        $this->assertEquals('some data', $xml->getText());
        $this->assertEquals(0, count($xml));
    }
    
    public function testReader3()
    {
        $reader = new Reader();
        $xml = $reader->readFromString(\Mock\Xml\Fixtures::FIXTURE3);
        $this->assertTrue($xml instanceof Xml);
        $this->assertEquals('tests', $xml->getName());
        $this->assertEquals(3, count($xml));
        $this->assertEquals('a', (string) $xml[0]);
        $this->assertEquals('b', (string) $xml[1]);
        $this->assertEquals('c', (string) $xml[2]);
        $this->assertEquals('a', (string) $xml->test);
    }
    
    public function testReader4()
    {
        $reader = new Reader();
        $xml = $reader->readFromString(\Mock\Xml\Fixtures::FIXTURE4);
        $this->assertTrue($xml instanceof Xml);
        $this->assertEquals('tests', $xml->getName());
        $this->assertEquals(3, count($xml));
        
        $this->assertEquals(123, (int) (string) $xml->a);
        $this->assertEquals(456, (int) (string) $xml->b);
        $this->assertEquals(789, (int) (string) $xml->c);
        
        $this->assertEquals(123, (int) (string) $xml[0]);
        $this->assertEquals(456, (int) (string) $xml[1]);
        $this->assertEquals(789, (int) (string) $xml[2]);
    }
    
    public function testReader5()
    {
        $reader = new Reader();
        $xml = $reader->readFromString(\Mock\Xml\Fixtures::FIXTURE5);
        $this->assertTrue($xml instanceof Xml);
        $this->assertEquals('tests', $xml->getName());
        $this->assertEquals(3, count($xml));

        $result = 0;
        foreach ($xml as $set) {
            foreach ($set as $number) {
                $result += (int) (string) $number;
            }
        }
        $this->assertEquals(45, $result);
    }
    
    public function testReader6()
    {
        $reader = new Reader();
        $xml = $reader->readFromString(\Mock\Xml\Fixtures::FIXTURE6);
        $this->assertTrue($xml instanceof Xml);
        $this->assertEquals('tests', $xml->getName());
        $this->assertEquals(1, count($xml));
        $this->assertEquals(666, (int) (string) $xml->a->b->c);
    }
    
    public function testReader7()
    {
        $reader = new Reader();
        $xml = $reader->readFromString(\Mock\Xml\Fixtures::FIXTURE7);
        $this->assertTrue($xml instanceof Xml);
        $this->assertEquals('tests', $xml->getName());
        $this->assertEquals(1, count($xml));
        
        $this->assertEquals(123, $xml->getAttribute('a'));
        $this->assertEquals(456, $xml->getAttribute('b'));
        $this->assertEquals(789, $xml->getAttribute('c'));
        
        $this->assertEquals('xyz', $xml->test->getAttribute('a'));
        $this->assertEquals('zyx', $xml->test->getAttribute('b'));
    }
    
    public function testReader8()
    {
        $reader = new Reader();
        $reader->setProperties(array(
            'a' => 123,
            'b' => 456,
            'x' => 'XXX',
            'y' => 'YYY'
        ));
        
        $xml = $reader->readFromString(\Mock\Xml\Fixtures::FIXTURE8);
        $this->assertTrue($xml instanceof Xml);
        $this->assertEquals('tests', $xml->getName());
        $this->assertEquals(1, count($xml));
        
        $this->assertEquals('XXX', $xml->getAttribute('a'));
        $this->assertEquals('YYY', $xml->getAttribute('b'));
        
        $this->assertEquals(123, $xml->test->getAttribute('a'));
        $this->assertEquals(456, $xml->test->getAttribute('b'));
    }
    
    public function testReadFromFile()
    {
        $filename = ROOT_PATH.'/test/fixtures/test_xml_reader.xml';
        $reader = new Reader();
        $xml = $reader->readFromFile($filename);
        $this->assertEquals('note', $xml->getName());
        $this->assertEquals('Tove', (string) $xml->to);
        $this->assertEquals('Jani', (string) $xml->from);
        $this->assertEquals('Reminder', (string) $xml->heading);
        $this->assertEquals("Don't forget me this weekend!", (string) $xml->body);
    }
    
    public function testReadFromFileInvalid()
    {
        $this->setExpectedException('Commons\\Xml\\Exception');
        $filename = ROOT_PATH.'/test/fixtures/test_xml_reader_invalid.xml';
        $reader = new Reader();
        $xml = $reader->readFromFile($filename);
    }
    
    public function testReadFromUrl()
    {
        $url = 'http://test/example.xml';
        $reader = new Reader();
        $xml = $reader->readFromUrl($url);
        $this->assertEquals('note', $xml->getName());
        $this->assertEquals('Tove', (string) $xml->to);
        $this->assertEquals('Jani', (string) $xml->from);
        $this->assertEquals('Reminder', (string) $xml->heading);
        $this->assertEquals("Don't forget me this weekend!", (string) $xml->body);
    }
    
}
