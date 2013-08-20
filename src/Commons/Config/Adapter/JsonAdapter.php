<?php

/**
 * =============================================================================
 * @file       Commons/Config/Adapter/JsonAdapter.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Config\Adapter;

use Commons\Config\Config;
use Commons\Json\Decoder as JsonDecoder;

class JsonAdapter extends AbstractAdapter
{

    /**
     * Load.
     * @see \Commons\Config\Adapter\AdapterInterface::load()
     */
    public function load($loadable)
    {
        $decoder = new JsonDecoder();
        $this->getConfig()->populate($decoder->decode((string) $loadable));
        return $this;
    }
    
    /**
     * Load from file.
     * @see \Commons\Config\Adapter\AdapterInterface::loadFromFile()
     */
    public function loadFromFile($filename)
    {
        $loadable = @file_get_contents($filename);
        if ($loadable === false) {
            throw new Exception("file_get_contents failed on {$filename}");
        }
        return $this->load($loadable);
    }
    
}
