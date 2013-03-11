<?php

/**
 * =============================================================================
 * @file        Commons/Filter/ToLowerFilter.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Filter;

class ToLowerFilter implements FilterInterface
{

    /**
     * Convert all characters to lowercase.
     * @see Commons\Filter\FilterInterface::filter()
     */
    public function filter($text)
    {
        return strtolower($text);
    }
    
}
