<?php

/**
 * =============================================================================
 * @file       Commons/Moo/Moo.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Moo;

use Commons\Service\ServiceManagerAwareInterface;
use Commons\Service\ServiceManagerInterface;

class Moo extends AbstractMoo implements ServiceManagerAwareInterface
{
    
    protected $_serviceManager;
    
    /**
     * Set service manager.
     * @see \Commons\Service\ServiceManagerAwareInterface::setServiceManager()
     */
    public function setServiceManager(ServiceManagerInterface $serviceManager)
    {
        $this->_serviceManager = $serviceManager;
        return $this;
    }

    /**
     * Get service manager.
     * @see \Commons\Service\ServiceManagerAwareInterface::getServiceManager()
     */
    public function getServiceManager()
    {
        if (!isset($this->_serviceManager)) {
            throw new Exception("Missing service manager instance");
        }
        return $this->_serviceManager;
    }
        
}
