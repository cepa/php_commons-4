<?php

/**
 * =============================================================================
 * @file       Commons/Xml/XmlTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Xml;

use Commons\Container\AssocContainer;

use Commons\Container\TraversableContainer;

class XmlTest extends \PHPUnit_Framework_TestCase
{

    public function testXml()
    {
        $xml = new Xml();
        $this->assertTrue($xml instanceof TraversableContainer);
        $this->assertEquals('', $xml->getName());
        $this->assertEquals('', (string) $xml);
        $this->assertEquals(0, count($xml));
    }
    
    public function testCreateFromString()
    {
        $str = "<test><a><b><c>xyz</c></b></a></test>";
        $xml = Xml::createFromString($str);
        $this->assertTrue($xml instanceof Xml);
        $this->assertEquals('xyz', (string) $xml->a->b->c);
    }
    
    public function testXpath()
    {
        $str = "<test><a><b><c>xyz</c></b></a></test>";
        $xml = Xml::createFromString($str)
            ->xpath('/a/b/c');
        $this->assertTrue($xml instanceof Xml);
        $this->assertEquals('c', $xml->getName());
        $this->assertEquals('xyz', (string) $xml);
    }
    
    public function testSetGetText()
    {
        $xml = new Xml();
        $this->assertEquals('', $xml->getText());
        $t = $xml->setText('xxx');
        $this->assertTrue($t instanceof TraversableContainer);
        $this->assertEquals('xxx', $xml->getText());
    }
    
    public function testSetGetAttributes()
    {
        $xml = new Xml();
        $this->assertTrue($xml->getAttributes() instanceof AssocContainer);
        $t = $xml->setAttributes(new AssocContainer(array('x' => 'y')));
        $this->assertTrue($t instanceof Xml);
        $this->assertEquals('y', $xml->getAttributes()->x);
        $this->assertEquals('y', $xml->getAttribute('x'));
    }
    
    public function testSetGetHasRemoveAttribute()
    {
        $xml = new Xml();
        $this->assertFalse($xml->hasAttribute('x'));
        
        $t = $xml->setAttribute('x', 123);
        $this->assertTrue($t instanceof Xml);
        $this->assertTrue($xml->hasAttribute('x'));
        $this->assertEquals(123, $xml->getAttribute('x'));
        
        $t = $xml->removeAttribute('x');
        $this->assertTrue($t instanceof Xml);
        $this->assertFalse($xml->hasAttribute('x'));
    }
    
    public function testToFile()
    {
        $xml = Xml::createFromString(\Mock\Xml\Fixtures::FIXTURE7);
        $filename = ROOT_PATH.'/test/tmp/test_xml_to_file.xml';
        $xml->toFile($filename);
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
    
    public function testSerializeUnserialize()
    {
        $xml = Xml::createFromString(\Mock\Xml\Fixtures::FIXTURE5);
        
        $str = $xml->serialize();
        $this->assertTrue(is_string($str));
        
        $xml = new Xml();
        $this->assertTrue($xml->unserialize($str) instanceof Xml);

        $result = 0;
        foreach ($xml as $node) {
            foreach ($node as $number) {
                $result += (int) (string) $number;
            }
        }
        $this->assertEquals(45, $result);
    }
    
    public function testSerializeUnserializeWithAttributes()
    {
        $xml = Xml::createFromString(\Mock\Xml\Fixtures::FIXTURE7);
        
        $str = $xml->serialize();
        $this->assertTrue(is_string($str));
        
        $xml = new Xml();
        $this->assertTrue($xml->unserialize($str) instanceof Xml);
        
        $this->assertEquals(1, count($xml));
        $this->assertEquals('tests', $xml->getName());
        
        $this->assertEquals(123, $xml->getAttribute('a'));
        $this->assertEquals(456, $xml->getAttribute('b'));
        $this->assertEquals(789, $xml->getAttribute('c'));
        
        $this->assertEquals('xyz', $xml->test->getAttribute('a'));
        $this->assertEquals('zyx', $xml->test->getAttribute('b'));
    }
    
    public function testCreateXmlObject()
    {
        $xml = new Xml('test');
        $xml->x = 123;
        $xml->y = 456;
        $xml->z->a = 'abc';
        $xml->z->b = 'xyz';
        
        $this->assertEquals('test', $xml->getName());
        
        $this->assertTrue($xml->x instanceof Xml);
        $this->assertEquals('x', $xml->x->getName());
        $this->assertEquals(123, $xml->x->getText());
        
        $this->assertTrue($xml->y instanceof Xml);
        $this->assertEquals('y', $xml->y->getName());
        $this->assertEquals(456, $xml->y->getText());
        
        $this->assertTrue($xml->z instanceof Xml);
        $this->assertEquals('z', $xml->z->getName());
        
        $this->assertTrue($xml->z->a instanceof Xml);
        $this->assertEquals('a', $xml->z->a->getName());
        $this->assertEquals('abc', $xml->z->a->getText());
        
        $this->assertTrue($xml->z->b instanceof Xml);
        $this->assertEquals('b', $xml->z->b->getName());
        $this->assertEquals('xyz', $xml->z->b->getText());
    }
    
}
