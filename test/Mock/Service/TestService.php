<?php

/**
 * =============================================================================
 * @file       Mock/Service/TestService.php
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

class TestService extends AbstractService
{
    
    protected $_name;
    
    public function __construct($name)
    {
        $this->_name = $name;
    }
    
    public function getName()
    {
        return $this->_name;
    }
    
}
