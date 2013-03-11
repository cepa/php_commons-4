<?php

/**
 * =============================================================================
 * @file        Commons/Filter/BbCodeFilterTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Filter;

class BbCodeFilterTest extends \PHPUnit_Framework_TestCase
{
    
    public function testFilter()
    {
        $filter = new BbCodeFilter();
        
        $this->assertEquals(
                '',
                $filter->filter(''));
        
        $this->assertEquals(
                '<strong>this text is bold</strong>',
                $filter->filter('[b]this text is bold[/b]'));
        
        $this->assertEquals(
                '<i>this text is italic</i>',
                $filter->filter('[i]this text is italic[/i]'));
        
        $this->assertEquals(
                '<u>this text is underline</u>',
                $filter->filter('[u]this text is underline[/u]'));
        
        $this->assertEquals(
                '<q>this text is quote</q>',
                $filter->filter('[quote]this text is quote[/quote]'));
        
        $this->assertEquals(
                '<pre><code>this text is code</code></pre>',
                $filter->filter('[code]this text is code[/code]'));
        
        $this->assertEquals(
                '<img src="aaa.png" alt="" />',
                $filter->filter('[img]aaa.png[/img]'));
    }
    
    public function testMoreComplex()
    {
        $filter = new BbCodeFilter();
        
        $this->assertEquals(
                '<a target="_blank" href="http://www.xxx.com">http://www.xxx.com</a> <a target="_blank" href="http://google.com">gOOgle</a> <a target="_blank" href="http://xxx.com">http://xxx.com</a>',
                $filter->filter('www.xxx.com [url=http://google.com]gOOgle[/url] http://xxx.com'));
        
        $this->assertEquals(
                '<a target="_blank" href="http://aaa.com">http://bbb.com</a>',
                $filter->filter('[url=http://aaa.com]http://bbb.com[/url]'));
    }
    
}
