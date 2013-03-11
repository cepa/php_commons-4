<?php

/**
 * =============================================================================
 * @file        Commons/Utils/StringUtilsTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Utils;

class StringUtilsTest extends \PHPUnit_Framework_TestCase
{
    
    public function testStartsWith()
    {
        $this->assertTrue(StringUtils::startsWith('xxxtest', 'xxx'));
        $this->assertTrue(StringUtils::startsWith('xXxtest', 'XxX', false));
        $this->assertFalse(StringUtils::startsWith('xyxtest', 'xxx'));
    }

    public function testEndsWith()
    {
        $this->assertTrue(StringUtils::endsWith('testxxx', 'xxx'));
        $this->assertTrue(StringUtils::endsWith('testxXx', 'XxX', false));
        $this->assertFalse(StringUtils::endsWith('testxyx', 'xxx'));
    }
    
    public function testNumberWithCommas()
    {
        $this->assertEquals('0', StringUtils::numberWithCommas(0));
        $this->assertEquals('1', StringUtils::numberWithCommas(1));
        $this->assertEquals('12', StringUtils::numberWithCommas(12));
        $this->assertEquals('123', StringUtils::numberWithCommas(123));
        $this->assertEquals('1,234', StringUtils::numberWithCommas(1234));
        $this->assertEquals('12,345', StringUtils::numberWithCommas(12345));
        $this->assertEquals('123,456', StringUtils::numberWithCommas(123456));
        $this->assertEquals('1,234,567', StringUtils::numberWithCommas(1234567));
        $this->assertEquals('12,345,678', StringUtils::numberWithCommas(12345678));
    }

    public function testGetFilenameBase()
    {
        $this->assertEquals(
            'file',
            StringUtils::getFilenameBase('file.jpg')
        );       
        $this->assertEquals(
            'some.file',
            StringUtils::getFilenameBase('some.file.jpg')
        );       
        $this->assertEquals(
            '.some.file',
            StringUtils::getFilenameBase('.some.file.jpg')
        );       
        $this->assertEquals(
            '',
            StringUtils::getFilenameBase('.jpg')
        );       
        $this->assertEquals(
            'jpg',
            StringUtils::getFilenameBase('jpg')
        );       
        $this->assertEquals(
            '',
            StringUtils::getFilenameBase('.')
        );       
        $this->assertEquals(
            '',
            StringUtils::getFilenameBase('')
        );       
    }
    
    public function testGetFilenameExtension()
    {
        $this->assertEquals(
            'jpg',
            StringUtils::getFilenameExtension('file.jpg')
        );       
        $this->assertEquals(
            'jpg',
            StringUtils::getFilenameExtension('file.jpg.jpg')
        );       
        $this->assertEquals(
            'x',
            StringUtils::getFilenameExtension('file.jpg.x')
        );       
        $this->assertEquals(
            '',
            StringUtils::getFilenameExtension('file')
        );       
        $this->assertEquals(
            'x',
            StringUtils::getFilenameExtension('.x')
        );       
        $this->assertEquals(
            '',
            StringUtils::getFilenameExtension('.')
        );       
        $this->assertEquals(
            '',
            StringUtils::getFilenameExtension('')
        );       
        $this->assertEquals(
            'yyy',
            StringUtils::getFilenameExtension('.xxx.yyy')
        );       
    }

    public function testFileSizeToText()
    {
        $this->assertEquals(
            "0 B",
            StringUtils::fileSizeToText(0)
        );

        $this->assertEquals(
            "666 B",
            StringUtils::fileSizeToText(666)
        );
        
        $this->assertEquals(
            "1 kB",
            StringUtils::fileSizeToText(1024)
        );
        
        $this->assertEquals(
            "1 MB",
            StringUtils::fileSizeToText(1024 * 1024)
        );

        $this->assertEquals(
            "120.56 kB",
            StringUtils::fileSizeToText(123456)
        );

        $this->assertEquals(
            "1 GB",
            StringUtils::fileSizeToText(1024 * 1024 * 1024)
        );
    }
    
    public function testRemoveWhitespaces()
    {
        $this->assertEquals(
            "someverylongstring",
            StringUtils::removeWhitespaces("some   very \n\n\n\t\t\r long string", '')
        );
        $this->assertEquals(
            "some very long string",
            StringUtils::removeWhitespaces("some   very \n\n\n\t\t\r long string")
        );
    }
    
    public function testTruncateWords()
    {
        $this->assertEquals(
            "some very long",
            StringUtils::truncateWords("some very long text", 3)
        );

        $this->assertEquals(
            "some very long text",
            StringUtils::truncateWords("some very long text", 10)
        );

        $this->assertEquals(
            "śćółka leśna jest",
            StringUtils::truncateWords("śćółka leśna jest strasznie nasączona wodą", 3)
        );

        $this->assertEquals(
            "ทดสอบ 这是一个测试-这是一个测试",
            StringUtils::truncateWords("ทดสอบ    这是一个测试-这是一个测试\n\n śćółka ", 2)
        );
    }
    
    public function testNormalize()
    {
        $this->assertEquals(
            "some-long-VERY-StRaNgE-link",
            StringUtils::normalize("some long VERY StRaNgE link")
        );
        
        $this->assertEquals(
            "Czasami-poprostu-pojęcia-nie-mam-co-mÓgłbym-wpisaĆ",
            StringUtils::normalize("Czasami poprostu pojęcia nie mam co mÓgłbym wpisaĆ")
        );
        
        $this->assertEquals(
            "x-O",
            StringUtils::normalize("@$%^*()---x)O")
        );
        
        $this->assertEquals(
            "这是一个测试",
            StringUtils::normalize("这是一个测试")
        );

        $this->assertEquals(
            "ทดสอบ",
            StringUtils::normalize("ทดสอบ")
        );

        $this->assertEquals(
            "这是一个测试-这是一个测试",
            StringUtils::normalize("这是一个测试-这是一个测试")
        );

        $this->assertEquals(
            "śćółka-leśna",
            StringUtils::normalize("śćółka leśna  ...")
        );
        
        $this->assertEquals("-", StringUtils::normalize(""));
    }
    
    public function testLatinNormalize()
    {
        $this->assertEquals(
            "some-long-very-strange-link",
            StringUtils::latinNormalize("some long VERY StRaNgE link")
        );
        
        $this->assertEquals(
            "czasami-poprostu-pojecia-nie-mam-co-moglbym-wpisac",
            StringUtils::latinNormalize("Czasami poprostu pojęcia nie mam co mÓgłbym wpisaĆ")
        );
        
        $this->assertEquals(
            "x-o",
            StringUtils::latinNormalize("@$%^*()---x)O")
        );
        
        $this->assertEquals("", StringUtils::latinNormalize(""));
    }
}
