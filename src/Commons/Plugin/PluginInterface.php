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
     * @param PluginAwareInterface $invoker
     * @return PluginInterface
     */
    public function setInvoker(PluginAwareInterface $invoker);
    
    /**
     * Get invoker.
     * @return PluginAwareInterface
     */
    public function getInvoker();
    
}
