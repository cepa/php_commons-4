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
     * @param InvokerInterface $invoker
     * @return PluginInterface
     */
    public function setInvoker(InvokerInterface $invoker)
    {
        $this->_invoker = $invoker;
        return $this;
    }
    
    /**
     * Get invoker.
     * @return InvokerInterface
     */
    public function getInvoker()
    {
        return $this->_invoker;    
    }
    
}
