<?php

/**
 * =============================================================================
 * @file        Commons/Sql/Connection/SingleConnectionTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Sql\Connection;

use Commons\Sql\Driver\DriverInterface;
use Commons\Sql\Driver\PdoDriver;
use Commons\Sql\Statement\StatementInterface;
use Commons\Sql\Query;
use Commons\Sql\RecordTable;
use Mock\Sql\Driver as MockDriver;
use Mock\Sql\RecordTable as MockRecordTable;

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
    
    public function testGetTable()
    {
        $connection = new SingleConnection(new MockDriver());
        $table = $connection->getTable('SomeRecord');
        $this->assertTrue($table instanceof RecordTable);
        $this->assertNull($table->getTableName());
        $this->assertEquals('\\Commons\\Sql\\Record', $table->getModelName());
        $this->assertTrue($table->getConnection() instanceof ConnectionInterface);
    }
        
    public function testGetTable_Custom()
    {
        $connection = new SingleConnection(new MockDriver());
        $table = $connection->getTable('\\Mock\\Sql\\Record');
        $this->assertTrue($table instanceof MockRecordTable);
        $this->assertTrue($table instanceof RecordTable);
        $this->assertEquals('mock_record', $table->getTableName());
        $this->assertEquals('\\Mock\\Sql\\Record', $table->getModelName());
        $this->assertTrue($table->getConnection() instanceof ConnectionInterface);
    }
    
    public function testSetGetTable()
    {
        $connection = new SingleConnection(new MockDriver());
        $table = $connection->getTable('\\Mock\\Sql\\Record');
        $this->assertTrue($table instanceof MockRecordTable);
        
        $table = new RecordTable($connection);
        $table
            ->setTableName('SomeTable')
            ->setModelName('SomeRecord');
        $c = $connection->setTable('\\Mock\\Sql\\Record', $table);
        $this->assertTrue($c instanceof ConnectionInterface);
        
        $table = $connection->getTable('\\Mock\\Sql\\Record');
        $this->assertFalse($table instanceof MockRecordTable);
        $this->assertTrue($table instanceof RecordTable);
        $this->assertEquals('SomeTable', $table->getTableName());
        $this->assertEquals('SomeRecord', $table->getModelName());
    }
        
}
