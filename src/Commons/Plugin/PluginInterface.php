<?php

/**
 * =============================================================================
 * @file       Commons/Plugin/PluginInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Plugin;

interface PluginInterface
{

    /**
     * Set invoker.
     * @param InvokerInterface $invoker
     * @return PluginInterface
     */
    public function setInvoker(InvokerInterface $invoker);
    
    /**
     * Get invoker.
     * @return InvokerInterface
     */
    public function getInvoker();
    
}
