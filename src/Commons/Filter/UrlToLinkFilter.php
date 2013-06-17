<?php

/**
 * =============================================================================
 * @file       Commons/Filter/UrlToLinkFilter.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Filter;

class UrlToLinkFilter implements FilterInterface
{

    protected $_search1 = 
        '#((www\.|(http|https|ftp|ftps)\:\/\/)[^\<\>\n\t\r\ ]+)#';
    
    protected $_search2 = array(
        '#^(http|https|ftp|ftps)\:\/\/(.*)#',
        '#^www\.(.*)#'
    );
    
    protected $_replace = array(
        '<a target="_blank" href="$1://$2">$2</a>',
        '<a target="_blank" href="http://www.$1">www.$1</a>'
    );
    
    /**
     * Auto detect all urls and make them clickable.
     * @see Commons\Filter\FilterInterface::filter()
     */
    public function filter($text)
    {
        return preg_replace_callback($this->_search1, array($this, '_callback'), $text);
    }
    
    protected function _callback(&$matches)
    {
        return preg_replace($this->_search2, $this->_replace, $matches[0]);
    }
    
}
