<?php

/**
 * =============================================================================
 * @file        Commons/Sql/EntityRepositoryTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Sql;

use Commons\Entity\Collection;
use Commons\Entity\Entity;
use Commons\Entity\RepositoryInterface;
use Commons\Sql\Connection\ConnectionInterface;
use Commons\Sql\Connection\SingleConnection;
use Commons\Sql\Driver\PdoDriver;
use Commons\Utils\RandomUtils;
use Mock\Sql\Driver as MockDriver;
use Mock\Sql\Connection as MockConnection;

class EntityRepositoryTest extends \PHPUnit_Framework_TestCase
{
    
    protected $_connection;
       
    public function setUp()
    {
        $this->_connection = new SingleConnection();
        $this->_connection->setDriver(new MockDriver());
    }
    
    public function testSetGetConnection()
    {
        $repo = new EntityRepository();
        $this->assertNull($repo->getConnection());
        $r = $repo->setConnection(new MockConnection());
        $this->assertTrue($r instanceof RepositoryInterface);
        $this->assertTrue($repo->getConnection() instanceof ConnectionInterface);
    }
    
    public function testSetGetTableName()
    {
        $repo = new EntityRepository();
        $this->assertNull($repo->getTableName());
        $r = $repo->setTableName('xxx');
        $this->assertTrue($r instanceof RepositoryInterface);
        $this->assertEquals('xxx', $repo->getTableName());
    }
    
    public function testRepo()
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
                throw new Exception("Unsupported driver '{$databaseType}'!");
            }
        
            $this->executeStatement("INSERT INTO test(a, b) VALUES (123, 'abc')");
            $this->executeStatement("INSERT INTO test(a, b) VALUES (456, 'def')");
            $this->executeStatement("INSERT INTO test(a, b) VALUES (789, 'ghi')");
        
            $repo = new EntityRepository($this->_connection);
            $this->assertNull($repo->getTableName());
            $r = $repo->setTableName('test');
            $this->assertTrue($r instanceof EntityRepository);
            $this->assertEquals('test', $repo->getTableName());
            
            $this->assertEquals('\Commons\Entity\Entity', $repo->getEntityClass());
            $r = $repo->setEntityClass('xxx');
            $this->assertTrue($r instanceof EntityRepository);
            $this->assertEquals('xxx', $repo->getEntityClass());
            $repo->setEntityClass('\Commons\Entity\Entity');
            
            $entity = $repo->fetch(1);
            $this->assertTrue($entity instanceof Entity);
            $this->assertTrue($entity->has($repo->getPrimaryKey()));
            $this->assertEquals(1, $entity->id);
            $this->assertEquals(123, $entity->a);
            $this->assertEquals('abc', $entity->b);
            
            $entity->a = '666';
            $entity->b = 'xxx';
            $r = $repo->save($entity);
            $this->assertTrue($r instanceof EntityRepository);
            
            $entity = $repo->fetch(1);
            $this->assertTrue($entity instanceof Entity);
            $this->assertEquals(1, $entity->id);
            $this->assertEquals(666, $entity->a);
            $this->assertEquals('xxx', $entity->b);
            
            $collection = $repo->fetchCollection();
            $this->assertTrue($collection instanceof Collection);
            $this->assertEquals(3, count($collection));
            foreach ($collection as $e) {
                $this->assertTrue($e instanceof Entity);
                $this->assertTrue($e->has($repo->getPrimaryKey()));
            }
            
            $r = $repo->delete($entity);
            $this->assertTrue($r instanceof EntityRepository);
            
            $this->assertNull($repo->fetch(1));
            
            $entity = new Entity();
            $entity->a = '999';
            $entity->b = 'yyy';
            $r = $repo->save($entity);
            $this->assertTrue($r instanceof EntityRepository);
            $this->assertEquals(4, $entity->id);
            
            $entity->a = '888';
            $entity->b = 'zzz';
            $repo->save($entity);
            
            $entity = $repo->fetch(4);
            $this->assertTrue($entity instanceof Entity);
            $this->assertEquals('888', $entity->a);
            $this->assertEquals('zzz', $entity->b);
            
            $collection = $repo->createQuery()
                ->select()
                ->from()
                ->orderBy('a ASC')
                ->execute()
                ->fetchCollection();
            $this->assertEquals(3, count($collection));
                    
            $this->_connection->disconnect();
            \Bootstrap::dropDatabase($database);
        
        } catch (Exception $e) {
            \Bootstrap::abort($e);
        }
    }
    
    public function testRepo_CustomPrimaryKey()
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
                throw new Exception("Unsupported driver '{$databaseType}'!");
            }
        
            $this->executeStatement("INSERT INTO test2(test_a, test_b) VALUES (123, 'abc')");
            $this->executeStatement("INSERT INTO test2(test_a, test_b) VALUES (456, 'def')");
            $this->executeStatement("INSERT INTO test2(test_a, test_b) VALUES (789, 'ghi')");
        
            $repo = new EntityRepository($this->_connection);
            $repo->setPrimaryKey('test_id');
            $this->assertNull($repo->getTableName());
            $r = $repo->setTableName('test2');
            $this->assertTrue($r instanceof EntityRepository);
            $this->assertEquals('test2', $repo->getTableName());
            
            $this->assertEquals('\Commons\Entity\Entity', $repo->getEntityClass());
            $r = $repo->setEntityClass('xxx');
            $this->assertTrue($r instanceof EntityRepository);
            $this->assertEquals('xxx', $repo->getEntityClass());
            $repo->setEntityClass('\Commons\Entity\Entity');
            
            $entity = $repo->fetch(1);
            $this->assertTrue($entity instanceof Entity);
            $this->assertEquals('1', $entity->test_id);
            $this->assertEquals('123', $entity->test_a);
            $this->assertEquals('abc', $entity->test_b);
            
            $entity->test_a = '666';
            $entity->test_b = 'xxx';
            $r = $repo->save($entity);
            $this->assertTrue($r instanceof EntityRepository);
            
            $entity = $repo->fetch(1);
            $this->assertTrue($entity instanceof Entity);
            $this->assertEquals('1', $entity->test_id);
            $this->assertEquals('666', $entity->test_a);
            $this->assertEquals('xxx', $entity->test_b);
            
            $collection = $repo->fetchCollection();
            $this->assertTrue($collection instanceof Collection);
            $this->assertEquals(3, count($collection));
            foreach ($collection as $r) {
                $this->assertTrue($r instanceof Entity);
            }
            
            $r = $repo->delete($entity);
            $this->assertTrue($r instanceof EntityRepository);
            
            $this->assertNull($repo->fetch(1));
            
            $entity = new Entity();
            $entity->test_a = '999';
            $entity->test_b = 'yyy';
            $r = $repo->save($entity);
            $this->assertTrue($r instanceof EntityRepository);
            $this->assertEquals('4', $entity->test_id);
            
            $entity->test_a = '888';
            $entity->test_b = 'zzz';
            $repo->save($entity);
            
            $entity = $repo->fetch(4);
            $this->assertTrue($entity instanceof Entity);
            $this->assertEquals('888', $entity->test_a);
            $this->assertEquals('zzz', $entity->test_b);
            
            $collection = $repo->createQuery()
                ->select('*')
                ->from('test2')
                ->orderBy('test_a ASC')
                ->execute()
                ->fetchCollection();
            $this->assertEquals(3, count($collection));
                    
            $this->_connection->disconnect();
            \Bootstrap::dropDatabase($database);
        
        } catch (Exception $e) {
            \Bootstrap::abort($e);
        }
    }
    
    public function testRepo_UuidKey()
    {
        try {
            $database = \Bootstrap::createDatabase();
            $this->_connection
                ->setDriver(new PdoDriver())
                ->connect(\Bootstrap::getDatabaseOptions($database));
            
            $databaseType = $this->_connection->getDatabaseType();
            if ($databaseType == Sql::TYPE_MYSQL) {
                $this->executeStatement("CREATE TABLE test3 ( uuid varchar(36) not null unique primary key, test_a int, test_b varchar(128) )");
            } else if ($databaseType == Sql::TYPE_POSTGRESQL) {
                $this->executeStatement("CREATE TABLE test3 (  uuid varchar(36) not null unique, test_a int, test_b varchar(128) )");
            } else {
                throw new Exception("Unsupported driver '{$databaseType}'!");
            }
        
            $uuid1 = RandomUtils::randomUuid();
            $this->executeStatement("INSERT INTO test3(uuid, test_a, test_b) VALUES ('{$uuid1}', 123, 'abc')");
            $uuid2 = RandomUtils::randomUuid();
            $this->executeStatement("INSERT INTO test3(uuid, test_a, test_b) VALUES ('{$uuid2}', 456, 'def')");
            $uuid3 = RandomUtils::randomUuid();
            $this->executeStatement("INSERT INTO test3(uuid, test_a, test_b) VALUES ('{$uuid3}', 789, 'ghi')");
        
            $repo = new EntityRepository($this->_connection);
            $repo->setPrimaryKey('uuid');
            $this->assertNull($repo->getTableName());
            $r = $repo->setTableName('test3');
            $this->assertTrue($r instanceof EntityRepository);
            $this->assertEquals('test3', $repo->getTableName());
            
            $this->assertEquals('\Commons\Entity\Entity', $repo->getEntityClass());
            $r = $repo->setEntityClass('xxx');
            $this->assertTrue($r instanceof EntityRepository);
            $this->assertEquals('xxx', $repo->getEntityClass());
            $repo->setEntityClass('\Commons\Entity\Entity');
            
            $entity = $repo->fetch($uuid1);
            $this->assertTrue($entity instanceof Entity);
            $this->assertEquals($uuid1, $entity->uuid);
            $this->assertEquals('123', $entity->test_a);
            $this->assertEquals('abc', $entity->test_b);
            
            $entity->test_a = '666';
            $entity->test_b = 'xxx';
            $r = $repo->save($entity);
            $this->assertTrue($r instanceof EntityRepository);
            
            $entity = $repo->fetch($uuid1);
            $this->assertTrue($entity instanceof Entity);
            $this->assertEquals($uuid1, $entity->uuid);
            $this->assertEquals('666', $entity->test_a);
            $this->assertEquals('xxx', $entity->test_b);
            
            $collection = $repo->fetchCollection();
            $this->assertTrue($collection instanceof Collection);
            $this->assertEquals(3, count($collection));
            foreach ($collection as $r) {
                $this->assertTrue($r instanceof Entity);
            }
            
            $r = $repo->delete($entity);
            $this->assertTrue($r instanceof EntityRepository);
            
            $this->assertNull($repo->fetch(1));
            
            $uuid4 = RandomUtils::randomUuid();
            $entity = new Entity();
            $entity->uuid = $uuid4;
            $entity->test_a = '999';
            $entity->test_b = 'yyy';
            $r = $repo->save($entity);
            $this->assertTrue($r instanceof EntityRepository);
            $this->assertEquals($uuid4, $entity->uuid);
            
            $entity->test_a = '888';
            $entity->test_b = 'zzz';
            $repo->save($entity);
            
            $entity = $repo->fetch($uuid4);
            $this->assertTrue($entity instanceof Entity);
            $this->assertEquals('888', $entity->test_a);
            $this->assertEquals('zzz', $entity->test_b);
            
            $collection = $repo->createQuery()
                ->select('*')
                ->from('test3')
                ->orderBy('test_a ASC')
                ->execute()
                ->fetchCollection();
            $this->assertEquals(3, count($collection));
                    
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
