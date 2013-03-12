<?php

/**
 * =============================================================================
 * @file        Commons/Sql/RecordTableTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Sql;

use Commons\Exception\NotImplementedException;
use Commons\Sql\Driver\PdoDriver;
use Commons\Sql\Connection\ConnectionInterface;
use Commons\Sql\Connection\SingleConnection;

class RecordTableTest extends \PHPUnit_Framework_TestCase
{

    protected $_connection;
       
    public function setUp()
    {
        $this->_connection = new SingleConnection();
    }
    
    public function testTable()
    {
        try {
            $database = \Bootstrap::createDatabase();
            $this->_connection
                ->setDriver(new PdoDriver())
                ->connect(\Bootstrap::getDatabaseOptions($database));
            
            $databaseType = $this->_connection->getDatabaseType();
            if ($databaseType == Sql::TYPE_MYSQL) {
                $this->executeStatement("CREATE TABLE test ( id int primary key auto_increment, a int, b varchar(128) )");
            } else if ($databaseType == Sql::TYPE_POSTGRESQL) {
                $this->executeStatement("CREATE TABLE test ( id serial, a int, b varchar(128) )");
            } else {
                throw new NotImplementedException("Unsupported driver '{$databaseType}'!");
            }
        
            $this->executeStatement("INSERT INTO test(a, b) VALUES (123, 'abc')");
            $this->executeStatement("INSERT INTO test(a, b) VALUES (456, 'def')");
            $this->executeStatement("INSERT INTO test(a, b) VALUES (789, 'ghi')");
        
            $table = new RecordTable($this->_connection);
            $this->assertNull($table->getTableName());
            $t = $table->setTableName('test');
            $this->assertTrue($t instanceof RecordTable);
            $this->assertEquals('test', $table->getTableName());
            
            $this->assertEquals('\\Commons\\Sql\\Record', $table->getModelName());
            $t = $table->setModelName('xxx');
            $this->assertTrue($t instanceof RecordTable);
            $this->assertEquals('xxx', $table->getModelName());
            $table->setModelName('\\Commons\\Sql\\Record');
            
            $record = $table->find(1);
            $this->assertTrue($record instanceof Record);
            $this->assertEquals('1', $record->id);
            $this->assertEquals('123', $record->a);
            $this->assertEquals('abc', $record->b);
            
            $record->a = '666';
            $record->b = 'xxx';
            $t = $table->save($record);
            $this->assertTrue($t instanceof RecordTable);
            
            $record = $table->createRecord();
            $this->assertTrue($record instanceof Record);
            $this->assertTrue($record->getTable() instanceof RecordTable);
            $this->assertTrue($record->getConnection() instanceof ConnectionInterface);
            
            $record = $table->find(1);
            $this->assertTrue($record instanceof Record);
            $this->assertEquals('1', $record->id);
            $this->assertEquals('666', $record->a);
            $this->assertEquals('xxx', $record->b);
            
            $collection = $table->findAll();
            $this->assertEquals(3, count($collection));
            foreach ($collection as $r) {
                $this->assertTrue($r instanceof Record);
            }
            
            $t = $table->delete($record);
            $this->assertTrue($t instanceof RecordTable);
            
            $this->assertNull($table->find(1));
            
            $record = new Record();
            $record->a = '999';
            $record->b = 'yyy';
            $t = $table->save($record);
            $this->assertTrue($t instanceof RecordTable);
            $this->assertEquals('4', $record->id);
            
            $record->a = '888';
            $record->b = 'zzz';
            $table->save($record);
            
            $record = $table->find(4);
            $this->assertTrue($record instanceof Record);
            $this->assertEquals('888', $record->a);
            $this->assertEquals('zzz', $record->b);
            
            $records = $table->createQuery()
                ->select('*')
                ->from('test')
                ->orderBy('a ASC')
                ->execute()
                ->fetchAll();
            $this->assertEquals(3, count($records));
                    
            $this->_connection->disconnect();
            \Bootstrap::dropDatabase($database);
        
        } catch (Exception $e) {
            \Bootstrap::abort($e);
        }
    }
    
    public function testTable_CustomPrimaryKey()
    {
        try {
            $database = \Bootstrap::createDatabase();
            $this->_connection
                ->setDriver(new PdoDriver())
                ->connect(\Bootstrap::getDatabaseOptions($database));
            
            $databaseType = $this->_connection->getDatabaseType();
            if ($databaseType == Sql::TYPE_MYSQL) {
                $this->executeStatement("CREATE TABLE test2 ( test_id int primary key auto_increment, test_a int, test_b varchar(128) )");
            } else if ($databaseType == Sql::TYPE_POSTGRESQL) {
                $this->executeStatement("CREATE TABLE test2 ( test_id serial, test_a int, test_b varchar(128) )");
            } else {
                throw new NotImplementedException("Unsupported driver '{$databaseType}'!");
            }
        
            $this->executeStatement("INSERT INTO test2(test_a, test_b) VALUES (123, 'abc')");
            $this->executeStatement("INSERT INTO test2(test_a, test_b) VALUES (456, 'def')");
            $this->executeStatement("INSERT INTO test2(test_a, test_b) VALUES (789, 'ghi')");
        
            $table = new RecordTable($this->_connection);
            $table->setPrimaryKey('test_id');
            $this->assertNull($table->getTableName());
            $t = $table->setTableName('test2');
            $this->assertTrue($t instanceof RecordTable);
            $this->assertEquals('test2', $table->getTableName());
            
            $this->assertEquals('\\Commons\\Sql\\Record', $table->getModelName());
            $t = $table->setModelName('xxx');
            $this->assertTrue($t instanceof RecordTable);
            $this->assertEquals('xxx', $table->getModelName());
            $table->setModelName('\\Commons\\Sql\\Record');
            
            $record = $table->find(1);
            $this->assertTrue($record instanceof Record);
            $this->assertEquals('1', $record->test_id);
            $this->assertEquals('123', $record->test_a);
            $this->assertEquals('abc', $record->test_b);
            
            $record->test_a = '666';
            $record->test_b = 'xxx';
            $t = $table->save($record);
            $this->assertTrue($t instanceof RecordTable);
            
            $record = $table->createRecord();
            $this->assertTrue($record instanceof Record);
            $this->assertTrue($record->getTable() instanceof RecordTable);
            $this->assertTrue($record->getConnection() instanceof ConnectionInterface);
            
            $record = $table->find(1);
            $this->assertTrue($record instanceof Record);
            $this->assertEquals('1', $record->test_id);
            $this->assertEquals('666', $record->test_a);
            $this->assertEquals('xxx', $record->test_b);
            
            $collection = $table->findAll();
            $this->assertEquals(3, count($collection));
            foreach ($collection as $r) {
                $this->assertTrue($r instanceof Record);
            }
            
            $t = $table->delete($record);
            $this->assertTrue($t instanceof RecordTable);
            
            $this->assertNull($table->find(1));
            
            $record = new Record();
            $record->test_a = '999';
            $record->test_b = 'yyy';
            $t = $table->save($record);
            $this->assertTrue($t instanceof RecordTable);
            $this->assertEquals('4', $record->test_id);
            
            $record->test_a = '888';
            $record->test_b = 'zzz';
            $table->save($record);
            
            $record = $table->find(4);
            $this->assertTrue($record instanceof Record);
            $this->assertEquals('888', $record->test_a);
            $this->assertEquals('zzz', $record->test_b);
            
            $records = $table->createQuery()
                ->select('*')
                ->from('test2')
                ->orderBy('test_a ASC')
                ->execute()
                ->fetchAll();
            $this->assertEquals(3, count($records));
                    
            $this->_connection->disconnect();
            \Bootstrap::dropDatabase($database);
        
        } catch (Exception $e) {
            \Bootstrap::abort($e);
        }
    }
    
    public function executeStatement($rawSql)
    {
        $this->_connection
            ->prepareStatement($rawSql)
            ->execute();
    }
    
}
