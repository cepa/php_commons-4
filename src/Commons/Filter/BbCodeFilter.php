<?php

/**
 * =============================================================================
 * @file        Commons/Filter/BbCodeFilter.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Filter;

class BbCodeFilter implements FilterInterface
{

    protected $_search1 = 
        '#((www\.|\[url\]|\[url\=|\]|(http|https|ftp|ftps)\:\/\/)[^\<\>\n\t\r\ ]+)#';
    
    protected $_search2 = array(
        '#^(http|https|ftp|ftps)\:\/\/(.*)#',
        '#^www\.(.*)#'
    );
    
    protected $_search3 = array(
        '/\[h1\](.*?)\[\/h1\]/is',          // Header 1
        '/\[h2\](.*?)\[\/h2\]/is',          // Header 2
        '/\[h3\](.*?)\[\/h3\]/is',          // Header 3
        '/\[b\](.*?)\[\/b\]/is',            // Bold
        '/\[i\](.*?)\[\/i\]/is',            // Italic
        '/\[u\](.*?)\[\/u\]/is',            // Underline
        '/\[quote\](.*?)\[\/quote\]/is',    // Quote
        '/\[code\](.*?)\[\/code\]/is',      // Code
        '/\[img\](.*?)\[\/img\]/is',        // Image
        '/\[url\](.*?)\[\/url\]/is',        // Url
        '/\[url\=(.*?)\](.*?)\[\/url\]/is'  // Url
    );
    
    protected $_replace1 = array(
        '[url]$1://$2[/url]',
        '[url]http://www.$1[/url]'
    );
    
    protected $_replace2 = array(
        '<h1>$1</h1>',
        '<h2>$1</h2>',
        '<h3>$1</h3>',
        '<strong>$1</strong>',
        '<i>$1</i>',
        '<u>$1</u>',
        '<q>$1</q>',
        '<pre><code>$1</code></pre>',
        '<img src="$1" alt="" />',
        '<a target="_blank" href="$1">$1</a>',
        '<a target="_blank" href="$1">$2</a>' 
    );
    
    /**
     * BBCode parser.
     * @see Commons\Filter\FilterInterface::filter()
     */
    public function filter($text)
    {
        $text = preg_replace_callback($this->_search1, array($this, '_callback'), $text);
        return  preg_replace($this->_search3, $this->_replace2, $text); 
    }
    
    protected function _callback(&$matches)
    {
        return preg_replace($this->_search2, $this->_replace1, $matches[0]);
    }
    
}
