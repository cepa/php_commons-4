<?php

/**
 * =============================================================================
 * @file        Commons/Filter/FilterInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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

