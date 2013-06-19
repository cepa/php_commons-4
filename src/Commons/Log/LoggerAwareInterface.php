<?php

/**
 * =============================================================================
 * @file       Commons/Log/LoggerAwareInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Log;

interface LoggerAwareInterface extends \Psr\Log\LoggerAwareInterface
{
    
    /**
     * Get logger.
     * @return \Commons\Log\LoggerInterface
     */
    public function getLogger();
    
}