<?php

/**
 * =============================================================================
 * @file       Commons/Http/Plugin/RedirectPlugin.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Http\Plugin;

use Commons\Http\StatusCode;
use Commons\Plugin\AbstractPlugin;

class RedirectPlugin extends AbstractPlugin
{
    
    protected $_isExitEnabled = true;
    
    public function enableExit($bool = true)
    {
        $this->_isExitEnabled = $bool;
        return $this;
    }
    
    public function redirect($asset)
    {
        $invoker = $this->getInvoker();
        if (preg_match('#^[a-zA-Z]+\:\/\/#', $asset)) {
            $url = $asset;
        } else {
            $url = $invoker->assetUrl($asset);
        }
        $invoker->getResponse()
            ->setStatus(StatusCode::HTTP_FOUND)
            ->setHeader('Location', $url);
        if ($this->_isExitEnabled) {
            $invoker->getResponse()
                ->clearBody()
                ->send();
            exit;
        }
        return $invoker;
    }
    
}

