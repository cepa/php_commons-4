<?php

/**
 * =============================================================================
 * @file        Commons/Filter/ToUpperFilter.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Filter;

class ToUpperFilter implements FilterInterface
{

    /**
     * Convert all characters to uppercase.
     * @see Commons\Filter\FilterInterface::filter()
     */
    public function filter($text)
    {
        return strtoupper($text);
    }
    
}
