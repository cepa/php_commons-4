<?php

/**
 * =============================================================================
 * @file       Mock/Light/Application.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Mock;

use Commons\Application\AbstractApplication;

class Application extends AbstractApplication
{
    
    public $test;
    
    public function init1()
    {
        $this->test .= '1';
    }
    
    public function init2()
    {
        $this->test .= '2';
    }
    
    public function init3()
    {
        $this->test .= '3';
    }
    
}
