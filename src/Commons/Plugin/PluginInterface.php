<?php

/**
 * =============================================================================
 * @file        Commons/Plugin/PluginInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Plugin;

interface PluginInterface
{
    
    /**
     * Invoke plugin.
     * @param ExtendableInterface $invoker
     * @param array $args
     * @return mixed
     */
    public function invoke(ExtendableInterface $invoker, array $args = array());
    
}
