<?php

/**
 * =============================================================================
 * @file        Commons/Sql/RecordTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Sql;

use Commons\Container\AssocContainer;
use Commons\Sql\Driver\PdoDriver;
use Commons\Sql\Connection\ConnectionInterface;
use Commons\Sql\Connection\SingleConnection;
use Mock\Sql\Connection as MockConnection;

class RecordTest extends \PHPUnit_Framework_TestCase
{

    public function testRecord()
    {
        $record = new Record();
        $this->assertTrue($record instanceof AssocContainer);
    }
    
    public function testSetGetConnection()
    {
        $record = new Record();
        $r = $record->setConnection(new MockConnection());
        $this->assertTrue($r instanceof Record);
        $this->assertTrue($r->getConnection() instanceof ConnectionInterface);
    }
    
    public function testGetConnection_Exception()
    {
        $this->setExpectedException('\\Commons\\Sql\\Exception');
        $record = new Record();
        $record->getConnection();
    }
    
    public function testCreateQuery()
    {
        $record = new Record();
        $record->setConnection(new MockConnection());
        $this->assertTrue($record->createQuery() instanceof Query);
    }
    
    public function testGetTable()
    {
        $record = new \Mock\Sql\Record();
        $record->setConnection(new MockConnection());
        $this->assertTrue($record->getTable() instanceof \Mock\Sql\RecordTable);
    }
    
    public function testRealSaveDelete()
    {
        try {
            $database = \Bootstrap::createDatabase();
            $connection = new SingleConnection();
            $connection
                ->setDriver(new PdoDriver())
                ->connect(\Bootstrap::getDatabaseOptions($database));
        
            if (DATABASE_DRIVER == 'mysql') {
                $connection->prepareStatement("CREATE TABLE mock_record ( id int primary key auto_increment, a int, b varchar(128) )")->execute();
            } else if (DATABASE_DRIVER == 'pgsql') {
                $connection->prepareStatement("CREATE TABLE mock_record ( id serial, a int, b varchar(128) )")->execute();
            }
        
            $record = new \Mock\Sql\Record;
            $record->setConnection($connection);
            $record->a = 123;
            $record->b = "abc";
            $record->save();
            
            $this->assertTrue($record->getTable() instanceof \Mock\Sql\RecordTable);
            
            $table = $connection->getTable('\\Mock\\Sql\\Record');
            $this->assertTrue($table instanceof \Mock\Sql\RecordTable);
            
            $record = $table->find(1);
            $this->assertTrue($record instanceof \Mock\Sql\Record);
            $this->assertEquals(1, $record->id);
            $this->assertEquals(123, $record->a);
            $this->assertEquals('abc', $record->b);
            
            $record->b = "xyz";
            $record->save();
            $this->assertEquals(1, $record->id);
            
            $record = $table->find(1);
            $this->assertTrue($record instanceof \Mock\Sql\Record);
            $this->assertEquals(1, $record->id);
            $this->assertEquals(123, $record->a);
            $this->assertEquals('xyz', $record->b);
                        
            $record->delete();
            $this->assertNull($table->find(1));
        
            $connection->disconnect();
            \Bootstrap::dropDatabase($database);
        
        } catch (Exception $e) {
            \Bootstrap::abort($e);
        }
    }
    
    public function testFindRelated()
    {
        try {
            $database = \Bootstrap::createDatabase();
            $connection = new SingleConnection();
            $connection
                ->setDriver(new PdoDriver())
                ->connect(\Bootstrap::getDatabaseOptions($database));
        
            if (DATABASE_DRIVER == 'mysql') {
                $connection->prepareStatement("CREATE TABLE mock_recordx ( id int primary key auto_increment, a int, b varchar(128) )")->execute();
                $connection->prepareStatement("CREATE TABLE mock_recordy ( id int primary key auto_increment, x_id int, v varchar(128) )")->execute();
            } else if (DATABASE_DRIVER == 'pgsql') {
                $connection->prepareStatement("CREATE TABLE mock_recordx ( id serial, a int, b varchar(128) )")->execute();
                $connection->prepareStatement("CREATE TABLE mock_recordy ( id serial, x_id int, v varchar(128) )")->execute();
            }
            
            $tableX = new RecordTable($connection);
            $tableX->setTableName('mock_recordx');
            
            $tableY = new RecordTable($connection);
            $tableY->setTableName('mock_recordy');
            
            $x = $tableX->createRecord();
            $x->a = 123;
            $x->b = 'xyz';
            $x->save();
            
            $y = $tableY->createRecord();
            $y->x_id = $x->id;
            $y->v = 'test 1';
            $y->save(); 
            
            unset($x);
            unset($y);
            
            $y = $tableY->find(1);
            $x = $y->findRelated('x_id', $tableX);
            $this->assertTrue($x instanceof Record);
            $this->assertEquals(123, $x->a);
            $this->assertEquals('xyz', $x->b);
            
            $z = $tableY->createRecord();
            $z->x_id = $x->id;
            $z->v = 'test 2';
            $z->save();
            
            unset($x);
            
            $records = $tableX->find(1)->findAllRelated('id', $tableY, 'x_id');
            $this->assertTrue(is_array($records));
            $this->assertEquals(2, count($records));
            
            $connection->disconnect();
            \Bootstrap::dropDatabase($database);
        
        } catch (Exception $e) {
            \Bootstrap::abort($e);
        }
    }

}
