<?php

/**
 * =============================================================================
 * @file       Commons/Filter/BeautifyFilter.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Filter;

class BeautifyFilter implements FilterInterface
{

    public function filter($text)
    {
        return \beautify($text);
    }
    
}
