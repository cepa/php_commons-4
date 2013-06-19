<?php

/**
 * =============================================================================
 * @file       Commons/Plugin/AbstractPlugin.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Plugin;

abstract class AbstractPlugin implements PluginInterface
{
    
    protected $_invoker;

    /**
     * Set invoker.
     * @param PluginAwareInterface $invoker
     * @return PluginInterface
     */
    public function setInvoker(PluginAwareInterface $invoker)
    {
        $this->_invoker = $invoker;
        return $this;
    }
    
    /**
     * Get invoker.
     * @return PluginAwareInterface
     */
    public function getInvoker()
    {
        return $this->_invoker;    
    }
    
}
