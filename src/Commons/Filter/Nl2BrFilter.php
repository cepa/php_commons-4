<?php

/**
 * =============================================================================
 * @file        Commons/Filter/Nl2BrFilter.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Filter;

class Nl2BrFilter implements FilterInterface
{

    /**
     * Convert \n to <br />.
     * @see Commons\Filter\FilterInterface::filter()
     */
    public function filter($text)
    {
        return nl2br($text);
    }
    
}
