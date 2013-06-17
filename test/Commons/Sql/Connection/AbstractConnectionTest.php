<?php

/**
 * =============================================================================
 * @file       Commons/Sql/Connection/AbstractConnectionTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Sql\Connection;

use Commons\Sql\Statement\StatementInterface;
use Commons\Sql\Query;
use Mock\Sql\Connection as MockConnection;

class AbstractConnectionTest extends \PHPUnit_Framework_TestCase
{
        
    public function testCreateQuery()
    {
        $connection = new MockConnection();
        $query = $connection->createQuery();
        $this->assertTrue($query instanceof Query);
        $this->assertTrue($query->getConnection() instanceof ConnectionInterface);
    }
        
}
