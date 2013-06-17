<?php

/**
 * =============================================================================
 * @file       Commons/Filter/Nl2BrFilter.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
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
