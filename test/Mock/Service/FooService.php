<?php

/**
 * =============================================================================
 * @file       Mock/Service/FooService.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Mock\Service;

use Commons\Service\AbstractService;

class FooService extends AbstractService
{
    
    public function foo($str)
    {
        return $str;
    }
    
}
