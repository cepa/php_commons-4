<?php

/**
 * =============================================================================
 * @file       Commons/Filter/StripTagsFilter.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
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
