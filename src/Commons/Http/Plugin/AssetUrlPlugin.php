<?php

/**
 * =============================================================================
 * @file        Commons/Http/Plugin/AssetUrlPlugin.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Http\Plugin;

use Commons\Plugin\AbstractPlugin;

class AssetUrlPlugin extends AbstractPlugin
{
    
    public function assetUrl($asset)
    {
        return $this->getInvoker()->baseUrl().'/'.ltrim($asset, '/');
    }
    
}

