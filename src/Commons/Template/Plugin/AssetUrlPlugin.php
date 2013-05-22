<?php

/**
 * =============================================================================
 * @file        Commons/Template/Plugin/AssetUrlPlugin.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Template\Plugin;

use Commons\Plugin\ExtendableInterface;
use Commons\Plugin\PluginInterface;

class AssetUrlPlugin implements PluginInterface
{
    
    public function invoke(ExtendableInterface $invoker, array $args = array())
    {
        if (!isset($args[0])) {
            throw new Exception("Missing argument");
        }
        return $invoker->baseUrl().'/'.ltrim($args[0], '/');
    }
    
}

