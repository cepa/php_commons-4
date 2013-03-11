<?php

/**
 * =============================================================================
 * @file        Mock/Sql/RecordTable.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Mock\Sql;

use Commons\Sql\Connection;

class RecordTable extends \Commons\Sql\RecordTable
{
    
    public function __construct(Connection $connection)
    {
        parent::__construct($connection);
        $this->setTableName('mock_record');
        $this->setModelName('\\Mock\\Sql\\Record');
    }
    
}
