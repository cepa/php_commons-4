<?php

/**
 * =============================================================================
 * @file       Commons/Migration/MigrationInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Migration;

interface MigrationInterface
{

    /**
     * Execute migration.
     */
    public function upgrade();

    /**
     * Rollback migration.
     */
    public function downgrade();
    
}
