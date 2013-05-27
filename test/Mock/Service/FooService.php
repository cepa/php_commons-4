<?php

/**
 * =============================================================================
 * @file        Mock/Service/FooService.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
