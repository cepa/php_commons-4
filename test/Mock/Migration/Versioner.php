<?php

/**
 * =============================================================================
 * @file       Mock/Migration/Versioner.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Mock\Migration;

use Commons\Migration\Versioner\VersionerInterface;

class Versioner implements VersionerInterface
{
    
    public function setVersion($name, $version)
    {
        Persistence::$version[$name] = $version;
        return $this;
    }
    
    public function getVersion($name)
    {
        return (isset(Persistence::$version[$name]) ? Persistence::$version[$name] : 0);
    }
    
}
