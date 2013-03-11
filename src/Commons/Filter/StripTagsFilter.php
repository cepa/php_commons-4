<?php

/**
 * =============================================================================
 * @file        Commons/Filter/StripTagsFilter.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Filter;

class StripTagsFilter implements FilterInterface
{

    /**
     * Convert \n to <br />.
     * @see Commons\Filter\FilterInterface::filter()
     */
    public function filter($text)
    {
        return strip_tags($text);
    }
    
}
