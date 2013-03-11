<?php

/**
 * =============================================================================
 * @file        Commons/Light/Application/AbstractModule.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Light\Module;

use Commons\Exception\NotImplementedException;

abstract class AbstractModule
{

    protected $_application;
    
    /**
     * Set application.
     * @param mixed $application
     * @return \Commons\Light\Module
     */
    public function setApplication($application)
    {
        $this->_application = $application;
        return $this;
    }
    
    /**
     * Get application.
     * @return mixed
     */
    public function getApplication()
    {
        return $this->_application;
    }
    
    /**
     * Init module.
     * @throws NotImplementedException
     */
    public function bootstrap()
    {
        throw new NotImplementedException();
    }
    
    /**
     * Convert module name to class name.
     * @param string $name
     * @return string
     */
    public static function moduleNameToClassName($name)
    {
        $name = str_replace('-', ' ', $name);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);
        return $name;
    }
    
    
}
