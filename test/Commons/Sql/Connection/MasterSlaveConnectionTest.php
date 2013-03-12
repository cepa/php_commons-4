<?php

/**
 * =============================================================================
 * @file        Commons/Sql/Connection/MasterSlaveConnectionTest.php
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

class MasterSlaveConnectionTest extends \PHPUnit_Framework_TestCase
{
    
    public function testConnectionDriverLazyLoad()
    {
        $connection = new MasterSlaveConnection();
        $this->assertTrue($connection->getMasterDriver() instanceof PdoDriver);
        $this->assertTrue($connection->getSlaveDriver() instanceof PdoDriver);
    }
    
    public function testConnection()
    {
        $connection = new MasterSlaveConnection();
        $c = $connection
            ->setMasterDriver(new MockDriver())
            ->setSlaveDriver(new MockDriver())
            ->connect(array('master' => array(), 'slave' => array()));
        $this->assertTrue($c instanceof ConnectionInterface);
        $this->assertTrue($c->getMasterDriver() instanceof DriverInterface);
        $this->assertTrue($c->hasMasterDriver());
        $this->assertTrue($c->getSlaveDriver() instanceof DriverInterface);
        $this->assertTrue($c->hasSlaveDriver());
        $this->assertTrue($c->isConnected());
        
        $c = $connection->connect();
        $this->assertTrue($c instanceof ConnectionInterface);
        
        $c = $connection->disconnect();
        $this->assertTrue($c instanceof ConnectionInterface);
    }
    
    public function testStatement()
    {
        $connection = new MasterSlaveConnection(new MockDriver(), new MockDriver());
        $statement = $connection->prepareStatement('test');
        $this->assertTrue($statement instanceof StatementInterface);
    }
    
    public function testBeginCommit()
    {
        $connection = new MasterSlaveConnection(new MockDriver(), new MockDriver());
        $c = $connection->begin();
        $this->assertTrue($c instanceof ConnectionInterface);
        $this->assertTrue($c->inTransaction());
        $c = $connection->commit();
        $this->assertTrue($c instanceof ConnectionInterface);
        $this->assertFalse($c->inTransaction());
    }
    
    public function testBeginRollback()
    {
        $connection = new MasterSlaveConnection(new MockDriver(), new MockDriver());
        $c = $connection->begin();
        $this->assertTrue($c instanceof ConnectionInterface);
        $this->assertTrue($c->inTransaction());
        $c = $connection->rollback();
        $this->assertTrue($c instanceof ConnectionInterface);
        $this->assertFalse($c->inTransaction());
    }
    
    public function testGetTable()
    {
        $connection = new MasterSlaveConnection(new MockDriver(), new MockDriver());
        $table = $connection->getTable('SomeRecord');
        $this->assertTrue($table instanceof RecordTable);
        $this->assertNull($table->getTableName());
        $this->assertEquals('\\Commons\\Sql\\Record', $table->getModelName());
        $this->assertTrue($table->getConnection() instanceof ConnectionInterface);
    }
        
    public function testGetTable_Custom()
    {
        $connection = new MasterSlaveConnection(new MockDriver(), new MockDriver());
        $table = $connection->getTable('\\Mock\\Sql\\Record');
        $this->assertTrue($table instanceof MockRecordTable);
        $this->assertTrue($table instanceof RecordTable);
        $this->assertEquals('mock_record', $table->getTableName());
        $this->assertEquals('\\Mock\\Sql\\Record', $table->getModelName());
        $this->assertTrue($table->getConnection() instanceof ConnectionInterface);
    }
    
    public function testSetGetTable()
    {
        $connection = new MasterSlaveConnection(new MockDriver(), new MockDriver());
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
    
    public function testScenario_SimpleSelect()
    {
        $connection = new MasterSlaveConnection(new MockDriver(), new MockDriver());
        
        $connection->createQuery()
            ->select('*')
            ->from('foo')
            ->execute();
        
        $this->assertEquals(0, $connection->getMasterDriver()->_getNumQueries());
        $this->assertEquals(1, $connection->getSlaveDriver()->_getNumQueries());
    }
    
    public function testScenario_SimpleSelectExplicitlyOnMaster()
    {
        $connection = new MasterSlaveConnection(new MockDriver(), new MockDriver());
        
        $connection->createQuery()
            ->select('*')
            ->from('foo')
            ->execute(array('driver' => 'master'));
        
        $this->assertEquals(1, $connection->getMasterDriver()->_getNumQueries());
        $this->assertEquals(0, $connection->getSlaveDriver()->_getNumQueries());
    }
    
    public function testScenario_SimpleInsertUpdateDelete()
    {
        $connection = new MasterSlaveConnection(new MockDriver(), new MockDriver());
        
        $connection->createQuery()
            ->insertInto('foo')
            ->set('x', 123)
            ->execute();
        
        $connection->createQuery()
            ->update('foo')
            ->set('x', 666)
            ->execute();
        
        $connection->createQuery()
            ->delete('foo')
            ->execute();
        
        $connection->createQuery()
            ->select('*')
            ->from('foo')
            ->execute();
        
        $this->assertEquals(3, $connection->getMasterDriver()->_getNumQueries());
        $this->assertEquals(1, $connection->getSlaveDriver()->_getNumQueries());
    }
        
    public function testScenario_Transaction()
    {
        $connection = new MasterSlaveConnection(new MockDriver(), new MockDriver());
        
        $connection->begin();
        
        $connection->createQuery()
            ->insertInto('foo')
            ->set('x', 123)
            ->execute();
        
        $connection->createQuery()
            ->update('foo')
            ->set('x', 666)
            ->execute();
        
        $connection->createQuery()
            ->delete('foo')
            ->execute();
        
        $connection->createQuery()
            ->select('*')
            ->from('foo')
            ->execute();
        
        $connection->commit();
        
        $this->assertEquals(4, $connection->getMasterDriver()->_getNumQueries());
        $this->assertEquals(0, $connection->getSlaveDriver()->_getNumQueries());
    }
        
}
