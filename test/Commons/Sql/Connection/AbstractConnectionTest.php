<?php

/**
 * =============================================================================
 * @file        Commons/Sql/Connection/AbstractConnectionTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Sql\Connection;

use Commons\Sql\Statement\StatementInterface;
use Commons\Sql\RecordTable;
use Commons\Sql\Query;
use Mock\Sql\Connection as MockConnection;
use Mock\Sql\RecordTable as MockRecordTable;

class AbstractConnectionTest extends \PHPUnit_Framework_TestCase
{
        
    public function testCreateQuery()
    {
        $connection = new MockConnection();
        $query = $connection->createQuery();
        $this->assertTrue($query instanceof Query);
        $this->assertTrue($query->getConnection() instanceof ConnectionInterface);
    }
    
    public function testGetTable()
    {
        $connection = new MockConnection();
        $table = $connection->getTable('SomeRecord');
        $this->assertTrue($table instanceof RecordTable);
        $this->assertNull($table->getTableName());
        $this->assertEquals('\\Commons\\Sql\\Record', $table->getModelName());
        $this->assertTrue($table->getConnection() instanceof ConnectionInterface);
    }
        
    public function testGetTable_Custom()
    {
        $connection = new MockConnection();
        $table = $connection->getTable('\\Mock\\Sql\\Record');
        $this->assertTrue($table instanceof MockRecordTable);
        $this->assertTrue($table instanceof RecordTable);
        $this->assertEquals('mock_record', $table->getTableName());
        $this->assertEquals('\\Mock\\Sql\\Record', $table->getModelName());
        $this->assertTrue($table->getConnection() instanceof ConnectionInterface);
    }
    
    public function testSetGetTable()
    {
        $connection = new MockConnection();
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
