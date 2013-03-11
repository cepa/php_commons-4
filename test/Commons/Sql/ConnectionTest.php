<?php

/**
 * =============================================================================
 * @file        Commons/Sql/Sql.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Sql;

use Commons\Sql\Connection;
use Commons\Sql\Driver\DriverInterface;
use Commons\Sql\Statement\StatementInterface;

class ConnectionTest extends \PHPUnit_Framework_TestCase
{
    
    public function testConnection()
    {
        $connection = new Connection();
        $c = $connection
            ->setDriver(new \Mock\Sql\Driver())
            ->connect();
        $this->assertTrue($c instanceof Connection);
        $this->assertTrue($c->getDriver() instanceof DriverInterface);
        $this->assertTrue($c->hasDriver());
        $this->assertTrue($c->isConnected());
        
        $c = $connection->connect();
        $this->assertTrue($c instanceof Connection);
        
        $c = $connection->disconnect();
        $this->assertTrue($c instanceof Connection);
    }
    
    public function testStatement()
    {
        $connection = new Connection(new \Mock\Sql\Driver());
        $statement = $connection->prepareStatement('test');
        $this->assertTrue($statement instanceof StatementInterface);
    }
    
    public function testBeginCommit()
    {
        $connection = new Connection(new \Mock\Sql\Driver());
        $c = $connection->begin();
        $this->assertTrue($c instanceof Connection);
        $this->assertTrue($c->inTransaction());
        $c = $connection->commit();
        $this->assertTrue($c instanceof Connection);
        $this->assertFalse($c->inTransaction());
    }
    
    public function testBeginRollback()
    {
        $connection = new Connection(new \Mock\Sql\Driver());
        $c = $connection->begin();
        $this->assertTrue($c instanceof Connection);
        $this->assertTrue($c->inTransaction());
        $c = $connection->rollback();
        $this->assertTrue($c instanceof Connection);
        $this->assertFalse($c->inTransaction());
    }
    
    public function testCreateQuery()
    {
        $connection = new Connection(new \Mock\Sql\Driver());
        $query = $connection->createQuery();
        $this->assertTrue($query instanceof Query);
        $this->assertTrue($query->getConnection() instanceof Connection);
        $this->assertTrue($query->getConnection()->getDriver() instanceof \Mock\Sql\Driver);
    }
    
    public function testGetTable()
    {
        $connection = new Connection(new \Mock\Sql\Driver());
        $table = $connection->getTable('SomeRecord');
        $this->assertTrue($table instanceof RecordTable);
        $this->assertNull($table->getTableName());
        $this->assertEquals('\\Commons\\Sql\\Record', $table->getModelName());
        $this->assertTrue($table->getConnection() instanceof Connection);
    }
        
    public function testGetTable_Custom()
    {
        $connection = new Connection(new \Mock\Sql\Driver());
        $table = $connection->getTable('\\Mock\\Sql\\Record');
        $this->assertTrue($table instanceof \Mock\Sql\RecordTable);
        $this->assertTrue($table instanceof RecordTable);
        $this->assertEquals('mock_record', $table->getTableName());
        $this->assertEquals('\\Mock\\Sql\\Record', $table->getModelName());
        $this->assertTrue($table->getConnection() instanceof Connection);
    }
    
    public function testSetGetTable()
    {
        $connection = new Connection(new \Mock\Sql\Driver());
        $table = $connection->getTable('\\Mock\\Sql\\Record');
        $this->assertTrue($table instanceof \Mock\Sql\RecordTable);
        
        $table = new RecordTable($connection);
        $table
            ->setTableName('SomeTable')
            ->setModelName('SomeRecord');
        $c = $connection->setTable('\\Mock\\Sql\\Record', $table);
        $this->assertTrue($c instanceof Connection);
        
        $table = $connection->getTable('\\Mock\\Sql\\Record');
        $this->assertFalse($table instanceof \Mock\Sql\RecordTable);
        $this->assertTrue($table instanceof RecordTable);
        $this->assertEquals('SomeTable', $table->getTableName());
        $this->assertEquals('SomeRecord', $table->getModelName());
    }
        
}
