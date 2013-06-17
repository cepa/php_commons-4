<?php

/**
 * =============================================================================
 * @file       Commons/Filter/UrlToLinkFilterTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Filter;

class UrlToLinkFilterTest extends \PHPUnit_Framework_TestCase
{
    
    public function testFilter()
    {
        $filter = new UrlToLinkFilter();
        
        $this->assertEquals(
                '<a target="_blank" href="http://www.hellworx.com">www.hellworx.com</a>',
                $filter->filter("http://www.hellworx.com"));
        
        $this->assertEquals(
                '<a target="_blank" href="http://www.youtube.com">www.youtube.com</a> '.
                '<a target="_blank" href="http://www.redtube.com">www.redtube.com</a>', 
                $filter->filter('http://www.youtube.com http://www.redtube.com'));
        
        $this->assertEquals(
                '<a target="_blank" href="ftp://ftp.hellworx.com">ftp.hellworx.com</a>', 
                $filter->filter('ftp://ftp.hellworx.com'));
        
        $this->assertEquals(
                '<a target="_blank" href="https://www.hellworx.com">www.hellworx.com</a>', 
                $filter->filter('https://www.hellworx.com'));
        
        $this->assertEquals(
                '<a target="_blank" href="http://www.google.com">www.google.com</a>', 
                $filter->filter('www.google.com'));
        
        $this->assertEquals(
                '<a target="_blank" href="http://www.google.com">www.google.com</a> '.
                '<a target="_blank" href="http://www.hellworx.com">www.hellworx.com</a> '.
                '<a target="_blank" href="http://vermis.hellworx.com">vermis.hellworx.com</a>',
                $filter->filter('www.google.com www.hellworx.com http://vermis.hellworx.com'));
        
        $this->assertEquals(
                '<a target="_blank" href="http://www.xxx.com,blabla">www.xxx.com,blabla</a>',
                $filter->filter('www.xxx.com,blabla'));

        $this->assertEquals(
                "<a target=\"_blank\" href=\"http://www.xxx.com\">www.xxx.com</a>\nxxx",
                $filter->filter("www.xxx.com\nxxx"));

        $this->assertEquals(
                "<a target=\"_blank\" href=\"http://www.xxx.com\">www.xxx.com</a><br />\nxxx",
                $filter->filter("www.xxx.com<br />\nxxx"));

        $this->assertEquals(
                "<a target=\"_blank\" href=\"http://www.xxx.com/fuck/yeah,hohoho,hohoho\">www.xxx.com/fuck/yeah,hohoho,hohoho</a><br />\nxxx",
                $filter->filter("www.xxx.com/fuck/yeah,hohoho,hohoho<br />\nxxx"));
    }
    
}
