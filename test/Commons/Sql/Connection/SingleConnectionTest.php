<?php

/**
 * =============================================================================
 * @file       Commons/Sql/Connection/SingleConnectionTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Sql\Connection;

use Commons\Sql\Driver\DriverInterface;
use Commons\Sql\Driver\PdoDriver;
use Commons\Sql\Statement\StatementInterface;
use Commons\Sql\Query;
use Mock\Sql\Driver as MockDriver;

class SingleConnectionTest extends \PHPUnit_Framework_TestCase
{
    
    public function testConnectionGetDriverLazyLoad()
    {
        $connection = new SingleConnection();
        $this->assertTrue($connection->getDriver() instanceof PdoDriver);
    }
    
    public function testConnection()
    {
        $connection = new SingleConnection();
        $c = $connection
            ->setDriver(new MockDriver())
            ->connect();
        $this->assertTrue($c instanceof ConnectionInterface);
        $this->assertTrue($c->getDriver() instanceof DriverInterface);
        $this->assertTrue($c->hasDriver());
        $this->assertTrue($c->isConnected());
        
        $c = $connection->connect();
        $this->assertTrue($c instanceof ConnectionInterface);
        
        $c = $connection->disconnect();
        $this->assertTrue($c instanceof ConnectionInterface);
    }
    
    public function testStatement()
    {
        $connection = new SingleConnection(new MockDriver());
        $statement = $connection->prepareStatement('test');
        $this->assertTrue($statement instanceof StatementInterface);
    }
    
    public function testBeginCommit()
    {
        $connection = new SingleConnection(new MockDriver());
        $c = $connection->begin();
        $this->assertTrue($c instanceof ConnectionInterface);
        $this->assertTrue($c->inTransaction());
        $c = $connection->commit();
        $this->assertTrue($c instanceof ConnectionInterface);
        $this->assertFalse($c->inTransaction());
    }
    
    public function testBeginRollback()
    {
        $connection = new SingleConnection(new MockDriver());
        $c = $connection->begin();
        $this->assertTrue($c instanceof ConnectionInterface);
        $this->assertTrue($c->inTransaction());
        $c = $connection->rollback();
        $this->assertTrue($c instanceof ConnectionInterface);
        $this->assertFalse($c->inTransaction());
    }
    
}
