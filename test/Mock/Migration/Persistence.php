<?php

/**
 * =============================================================================
 * @file        Mock/Migration/Persistence.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Mock\Migration;

class Persistence
{
    
    public static $version = array();
    public static $counter = 0;
    
    protected function __construct() {}
    
}
