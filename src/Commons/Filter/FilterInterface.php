<?php

/**
 * =============================================================================
 * @file       Commons/Filter/FilterInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Filter;

interface FilterInterface
{
    
    /**
     * Filter.
     * @param mixed $value
     * @return mixed
     */
    public function filter($value);
    
}

