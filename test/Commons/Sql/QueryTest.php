<?php

/**
 * =============================================================================
 * @file        Commons/Sql/QueryTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Sql;

use Commons\Sql\Driver\PdoDriver;

class QueryTest extends \PHPUnit_Framework_TestCase
{
    
    protected $_connection;
       
    public function setUp()
    {
        $this->_connection = new Connection();
        $this->_connection->setDriver(new \Mock\Sql\Driver());
    }
    
    public function testSetGetObjectClassName()
    {
        $query = $this->getQuery();
        $this->assertEquals('\\Commons\\Sql\\Record', $query->getObjectClassName());
        $q = $query->setObjectClassName('xxx');
        $this->assertTrue($q instanceof Query);
        $this->assertEquals('xxx', $query->getObjectClassName());
    }
    
    public function testCreate()
    {
        $query = $this->getQuery();
        $this->assertTrue($query instanceof Query);
        $this->assertTrue($query->getConnection() instanceof Connection);
        
        $query = $this->getQuery();
        $this->assertTrue($query instanceof Query);
        $this->assertTrue($query->getConnection() instanceof Connection);
        
        $this->assertTrue($query->getBeginning() instanceof QueryExpression);
        $this->assertTrue($query->getFrom() instanceof QueryExpression);
        $this->assertTrue($query->getWhere() instanceof QueryExpression);
        $this->assertTrue($query->getGroupBy() instanceof QueryExpression);
        $this->assertTrue($query->getHaving() instanceof QueryExpression);
        $this->assertTrue($query->getUnion() instanceof QueryExpression);
        $this->assertTrue($query->getOrderBy() instanceof QueryExpression);
        $this->assertTrue($query->getLimit() instanceof QueryExpression);
        $this->assertTrue($query->getOffset() instanceof QueryExpression);
        $this->assertTrue($query->getJoin() instanceof QueryExpression);
        $this->assertTrue($query->getEnding() instanceof QueryExpression);
        
        $this->assertEquals(Query::TYPE_SELECT, $query->getType());
    }    
    
    public function testSelect()
    {
        $query = $this->getQuery()->select('*');
        $this->assertTrue($query instanceof Query);
        $this->assertEquals("SELECT *", (string) $query);
        $this->assertEquals(Query::TYPE_SELECT, $query->getType());
        
        $query->select('x');
        $this->assertEquals("SELECT x", (string) $query);
        
        $query->addSelect('a')->addSelect('b')->addSelect('c');
        $this->assertEquals("SELECT x , a , b , c", (string) $query);

        $query = $this->getQuery()->addSelect('a')->addSelect('b')->addSelect('c');
        $this->assertEquals("SELECT a , b , c", (string) $query);
    }
    
    public function testInsert()
    {
        $query = $this->getQuery()->insertInto('xxx');
        $this->assertTrue($query instanceof Query);
        $this->assertEquals('INSERT INTO xxx ( ) VALUES ( )', (string) $query);
        $this->assertEquals(Query::TYPE_INSERT, $query->getType());
        
        $query->insertInto('a')->insertInto('b')->insertInto('c');
        $this->assertEquals('INSERT INTO c ( ) VALUES ( )', (string) $query);
    }
    
    public function testUpdate()
    {
        $query = $this->getQuery()->update('xxx');
        $this->assertTrue($query instanceof Query);
        $this->assertEquals('UPDATE xxx SET', (string) $query);
        $this->assertEquals(Query::TYPE_UPDATE, $query->getType());
        
        $query->update('a')->update('b')->update('c');
        $this->assertEquals('UPDATE c SET', (string) $query);
    }
    
    public function testDelete()
    {
        $query = $this->getQuery()->delete('xxx');
        $this->assertTrue($query instanceof Query);
        $this->assertEquals('DELETE FROM xxx', (string) $query);
        $this->assertEquals(Query::TYPE_DELETE, $query->getType());
        
        $query->delete('a')->delete('b')->delete('c');
        $this->assertEquals('DELETE FROM c', (string) $query);
    }
    
    public function testFrom()
    {
        $query = $this->getQuery()->from('xxx');
        $this->assertTrue($query instanceof Query);
        $this->assertEquals('FROM xxx', (string) $query);
        
        $query->from('x');
        $this->assertEquals('FROM x', (string) $query);
        
        $query->addFrom('a')->addFrom('b')->addFrom('c');
        $this->assertEquals('FROM x , a , b , c', (string) $query);
        
        $query = $this->getQuery()
            ->addFrom('a')->addFrom('b')->addFrom('c');
        $this->assertEquals('FROM a , b , c', (string) $query);
    }
    
    public function testWhereStatement()
    {
        $query = $this->getQuery()->where('xxx');
        $this->assertTrue($query instanceof Query);
        $this->assertEquals('WHERE xxx', (string) $query);
        
        $query
            ->where('a')
            ->andWhere('b')
            ->orWhere('c');
        $this->assertTrue($query instanceof Query);
        $this->assertEquals('WHERE a AND b OR c', (string) $query);
    }
    
    public function testGroupBy()
    {
        $query = $this->getQuery()->groupBy('xxx');
        $this->assertTrue($query instanceof Query);
        $this->assertEquals('GROUP BY xxx', (string) $query);
        
        $query->groupBy('x');
        $this->assertEquals('GROUP BY x', (string) $query);
        
        $query->addGroupBy('a')->addGroupBy('b')->addGroupBy('c');
        $this->assertEquals('GROUP BY x , a , b , c', (string) $query);

        $query = $this->getQuery()
            ->addGroupBy('a')->addGroupBy('b')->addGroupBy('c');
        $this->assertEquals('GROUP BY a , b , c', (string) $query);
    }
    
    public function testHaving()
    {
        $query = $this->getQuery()->having('xxx');
        $this->assertTrue($query instanceof Query);
        $this->assertEquals('HAVING xxx', (string) $query);
        
        $query->having('a')->having('b')->having('c');
        $this->assertEquals('HAVING c', (string) $query);
    }
    
    public function testUnion()
    {
        $query = $this->getQuery()->union('xxx');
        $this->assertTrue($query instanceof Query);
        $this->assertEquals('UNION xxx', (string) $query);
        
        $query->union('a')->union('b')->union('c');
        $this->assertEquals('UNION c', (string) $query);
    }
    
    public function testOrderBy()
    {
        $query = $this->getQuery()->orderBy('xxx');
        $this->assertTrue($query instanceof Query);
        $this->assertEquals('ORDER BY xxx', (string) $query);
        
        $query->orderBy('x');
        $this->assertEquals('ORDER BY x', (string) $query);
        
        $query->addOrderBy('a')->addOrderBy('b')->addOrderBy('c');
        $this->assertEquals('ORDER BY x , a , b , c', (string) $query);

        $query = $this->getQuery()
            ->addOrderBy('a')->addOrderBy('b')->addOrderBy('c');
        $this->assertEquals('ORDER BY a , b , c', (string) $query);
    }
    
    public function testLimit()
    {
        $query = $this->getQuery()->limit('xxx');
        $this->assertTrue($query instanceof Query);
        $this->assertEquals('LIMIT xxx', (string) $query);
        
        $query->limit('a')->limit('b')->limit('c');
        $this->assertEquals('LIMIT c', (string) $query);
    }
    
    public function testOffset()
    {
        $query = $this->getQuery()->offset('xxx');
        $this->assertTrue($query instanceof Query);
        $this->assertEquals('OFFSET xxx', (string) $query);
        
        $query->offset('a')->offset('b')->offset('c');
        $this->assertEquals('OFFSET c', (string) $query);
    }
    
    public function testSet()
    {
        $query = $this->getQuery()
            ->update('')
            ->set('xxx', '666');
        $this->assertTrue($query instanceof Query);
        $this->assertEquals('UPDATE SET xxx = :_1', (string) $query);
        
        $query->set('a', 123)->set('b', 456)->set('c', 789);
        $this->assertEquals('UPDATE SET xxx = :_2 , a = :_3 , b = :_4 , c = :_5', (string) $query);
    }
    
    public function testJoin()
    {
        $query = $this->getQuery()->join('xxx');
        $this->assertTrue($query instanceof Query);
        $this->assertEquals('JOIN xxx', (string) $query);
        
        $query
            ->leftJoin('a')
            ->leftOuterJoin('b')
            ->rightJoin('c')
            ->rightOuterJoin('d')
            ->innerJoin('e')
            ->crossJoin('f')
            ->naturalJoin('g');
        $this->assertTrue($query instanceof Query);
        $this->assertEquals('JOIN xxx LEFT JOIN a LEFT OUTER JOIN b RIGHT JOIN c RIGHT OUTER JOIN d INNER JOIN e CROSS JOIN f NATURAL JOIN g', (string) $query);
    }
    
    public function testEnding()
    {
        $query = $this->getQuery()->ending('xxx');
        $this->assertTrue($query instanceof Query);
        $this->assertEquals('xxx', (string) $query);
        
        $query->ending('a')->ending('b')->ending('c');
        $this->assertEquals('c', (string) $query);
    }
    
    public function testToSql_Select()
    {
        $query = $this->getQuery()
            ->select('a')
            ->from('b')
            ->leftJoin('c')
            ->where('d')
            ->groupBy('e')
            ->having('f')
            ->union('g')
            ->orderBy('h')
            ->limit('i')
            ->offset('j')
            ->ending('k');
        
        $expect = 'SELECT a FROM b LEFT JOIN c WHERE d GROUP BY e HAVING f UNION g ORDER BY h LIMIT i OFFSET j k';
        $this->assertEquals($expect, $query->toSql());
    }
    
    public function testToSql_Insert()
    {
        $query = $this->getQuery()
            ->insertInto('a')
            ->set('b', 123)
            ->ending('c');
        
        $expect = 'INSERT INTO a ( b ) VALUES ( :_1 ) c';
        $this->assertEquals($expect, $query->toSql());
    }
    
    public function testToSql_Update()
    {
        $query = $this->getQuery()
            ->update('a')
            ->set('b', 123)
            ->where('c')
            ->limit('d')
            ->offset('e')
            ->ending('f');
        
        $expect = 'UPDATE a SET b = :_1 WHERE c LIMIT d OFFSET e f';
        $this->assertEquals($expect, $query->toSql());
    }
    
    public function testToSql_Delete()
    {
        $query = $this->getQuery()
            ->delete('a')
            ->where('b')
            ->limit('c')
            ->offset('d')
            ->ending('e');
        
        $expect = 'DELETE FROM a WHERE b LIMIT c OFFSET d e';
        $this->assertEquals($expect, $query->toSql());
    }
    
    public function testBindSetGetParams()
    {
        $query = $this->getQuery();
        $this->assertEquals(0, count($query));
        
        $query->abc = 'xyz';
        $this->assertEquals(1, count($query));
        $this->assertEquals('xyz', $query->abc);
        
        $query->abc = 'XYZ';
        $this->assertEquals(1, count($query));
        $this->assertEquals('XYZ', $query->abc);
    }
    
    public function testExecute_FetchColumn()
    {
        try {
            $database = \Bootstrap::createDatabase();
            $this->_connection
                ->setDriver(new PdoDriver())
                ->connect(\Bootstrap::getDatabaseOptions($database));
            
            $x = $this->getQuery()
                ->select('123 AS x')
                ->execute()
                ->fetchColumn();
            $this->assertEquals(123, $x);
            
            $this->_connection->disconnect();
            \Bootstrap::dropDatabase($database);
            
        } catch (Exception $e) {
            \Bootstrap::abort($e);
        }
    }
    
    public function testExecute_Fetch()
    {
        try {
            $database = \Bootstrap::createDatabase();
            $this->_connection
                ->setDriver(new PdoDriver())
                ->connect(\Bootstrap::getDatabaseOptions($database));
            
            $a = $this->getQuery()
                ->select('123 AS x, 456 AS y')
                ->execute()
                ->fetch();
            $this->assertEquals(2, count($a));
            $this->assertEquals(123, $a['x']);
            $this->assertEquals(456, $a['y']);
                 
            $this->_connection->disconnect();
            \Bootstrap::dropDatabase($database);
            
        } catch (Exception $e) {
            \Bootstrap::abort($e);
        }
    }
    
    public function testExecute_FetchObject()
    {
        try {
            $database = \Bootstrap::createDatabase();
            $this->_connection
                ->setDriver(new PdoDriver())
                ->connect(\Bootstrap::getDatabaseOptions($database));
            
            $a = $this->getQuery()
                ->select('123 AS x, 456 AS y')
                ->execute()
                ->fetchObject();
            $this->assertEquals(2, count($a));
            $this->assertEquals(123, $a->x);
            $this->assertEquals(456, $a->y);
            
            $this->assertTrue($a->getConnection() instanceof Connection);
                 
            $this->_connection->disconnect();
            \Bootstrap::dropDatabase($database);
            
        } catch (Exception $e) {
            \Bootstrap::abort($e);
        }
    }
    
    public function testExecute_FetchAll()
    {
        try {
            $database = \Bootstrap::createDatabase();
            $this->_connection
                ->setDriver(new PdoDriver())
                ->connect(\Bootstrap::getDatabaseOptions($database));
            
            $this->executeStatement("CREATE TABLE test ( a int, b varchar(128) )");
            
            $this->executeStatement("INSERT INTO test(a, b) VALUES (123, 'abc')");
            $this->executeStatement("INSERT INTO test(a, b) VALUES (456, 'def')");
            $this->executeStatement("INSERT INTO test(a, b) VALUES (789, 'ghi')");
            
            $a = $this->getQuery()
                ->select('*')
                ->from('test')
                ->orderBy('a ASC')
                ->execute()
                ->fetchAll();
            $this->assertEquals(3, count($a));
                 
            $this->_connection->disconnect();
            \Bootstrap::dropDatabase($database);
            
        } catch (Exception $e) {
            \Bootstrap::abort($e);
        }
    }
    
    public function testExecute_FetchAllObjects()
    {
        try {
            $database = \Bootstrap::createDatabase();
            $this->_connection
                ->setDriver(new PdoDriver())
                ->connect(\Bootstrap::getDatabaseOptions($database));
            
            $this->executeStatement("CREATE TABLE test ( a int, b varchar(128) )");
            
            $this->executeStatement("INSERT INTO test(a, b) VALUES (123, 'abc')");
            $this->executeStatement("INSERT INTO test(a, b) VALUES (456, 'def')");
            $this->executeStatement("INSERT INTO test(a, b) VALUES (789, 'ghi')");
            
            $a = $this->getQuery()
                ->select('*')
                ->from('test')
                ->orderBy('a ASC')
                ->execute()
                ->fetchAllObjects();
            $this->assertEquals(3, count($a));
            
            foreach ($a as $o) {
                $this->assertTrue($o instanceof Record);
                $this->assertTrue($o->getConnection() instanceof Connection);
            }
                 
            $this->_connection->disconnect();
            \Bootstrap::dropDatabase($database);
            
        } catch (Exception $e) {
            \Bootstrap::abort($e);
        }
    }
    
    public function testExecuteRealQuery()
    {
        try {
            $database = \Bootstrap::createDatabase();
            $this->_connection
                ->setDriver(new PdoDriver())
                ->connect(\Bootstrap::getDatabaseOptions($database));
            
            $this->executeStatement("CREATE TABLE test ( a int, b varchar(128) )");
            
            $this->executeStatement("INSERT INTO test(a, b) VALUES (123, 'abc')");
            $this->executeStatement("INSERT INTO test(a, b) VALUES (456, 'def')");
            $this->executeStatement("INSERT INTO test(a, b) VALUES (789, 'ghi')");
            
            $a = $this->getQuery()
                ->select('*')
                ->from('test')
                ->orderBy('a ASC')
                ->where('a = ?', 123)
                ->execute()
                ->fetchAll();
            $this->assertEquals(1, count($a));
            
            $this->assertEquals(123, $a[0]['a']);
            $this->assertEquals('abc', $a[0]['b']);
            
            $this->_connection->disconnect();
            \Bootstrap::dropDatabase($database);
            
        } catch (Exception $e) {
            \Bootstrap::abort($e);
        }
    }
    
    public function testExecuteRealQuery2()
    {
        try {
            $database = \Bootstrap::createDatabase();
            $this->_connection
                ->setDriver(new PdoDriver())
                ->connect(\Bootstrap::getDatabaseOptions($database));
            
            $this->executeStatement("CREATE TABLE test ( a int, b varchar(128) )");
            
            $this->getQuery()
                ->insertInto("test")
                ->set('a', 123)
                ->set('b', 'abc')
                ->execute();
            
            $this->getQuery()
                ->insertInto("test")
                ->set('a', 456)
                ->set('b', 'def')
                ->execute();
            
            $this->getQuery()
                ->insertInto("test")
                ->set('a', 789)
                ->set('b', 'ghi')
                ->execute();
            
            $a = $this->getQuery()
                ->select('*')
                ->from('test')
                ->orderBy('a DESC')
                ->where('a = ?', 123)
                ->orWhere('b = ?', 'ghi')
                ->execute()
                ->fetchAll();
            $this->assertEquals(2, count($a));
                 
            $this->assertEquals(789, $a[0]['a']);
            $this->assertEquals('ghi', $a[0]['b']);
            
            $this->assertEquals(123, $a[1]['a']);
            $this->assertEquals('abc', $a[1]['b']);
            
            $this->_connection->disconnect();
            \Bootstrap::dropDatabase($database);
            
        } catch (Exception $e) {
            \Bootstrap::abort($e);
        }
    }
    
    public function testExecuteRealQuery3()
    {
        try {
            $database = \Bootstrap::createDatabase();
            $this->_connection
                ->setDriver(new PdoDriver())
                ->connect(\Bootstrap::getDatabaseOptions($database));
            
            $this->executeStatement("CREATE TABLE test ( a int, b varchar(128) )");
            
            $this->executeStatement("INSERT INTO test(a, b) VALUES (123, 'abc')");
            $this->executeStatement("INSERT INTO test(a, b) VALUES (456, 'def')");
            $this->executeStatement("INSERT INTO test(a, b) VALUES (789, 'ghi')");
            
            $this->getQuery()
                ->update('test')
                ->set('a', 666)
                ->set('b', 'xyz')
                ->where('a = ?', 123)
                ->execute();
            
            $a = $this->getQuery()
                ->select('*')
                ->from('test')
                ->orderBy('a ASC')
                ->execute()
                ->fetchAll();
            $this->assertEquals(3, count($a));
            
            $this->assertEquals(666, $a[1]['a']);
            $this->assertEquals('xyz', $a[1]['b']);
            
            $this->_connection->disconnect();
            \Bootstrap::dropDatabase($database);
            
        } catch (Exception $e) {
            \Bootstrap::abort($e);
        }
    }
    
    public function testExecuteRealQuery4()
    {
        try {
            $database = \Bootstrap::createDatabase();
            $this->_connection
                ->setDriver(new PdoDriver())
                ->connect(\Bootstrap::getDatabaseOptions($database));
            
            $this->executeStatement("CREATE TABLE test ( a int, b varchar(128) )");
            
            $this->executeStatement("INSERT INTO test(a, b) VALUES (123, 'abc')");
            $this->executeStatement("INSERT INTO test(a, b) VALUES (456, 'def')");
            $this->executeStatement("INSERT INTO test(a, b) VALUES (789, 'ghi')");
            
            $this->getQuery()
                ->delete('test')
                ->where('a = ?', 456)
                ->execute();
            
            $a = $this->getQuery()
                ->select('*')
                ->from('test')
                ->orderBy('a ASC')
                ->execute()
                ->fetchAll();
            $this->assertEquals(2, count($a));
            
            $this->_connection->disconnect();
            \Bootstrap::dropDatabase($database);
            
        } catch (Exception $e) {
            \Bootstrap::abort($e);
        }
    }
    
    public function testExecuteRealQuery5()
    {
        try {
            $database = \Bootstrap::createDatabase();
            $this->_connection
                ->setDriver(new PdoDriver())
                ->connect(\Bootstrap::getDatabaseOptions($database));
            
            $this->executeStatement("CREATE TABLE test ( a int, b varchar(128) )");
            
            $this->executeStatement("INSERT INTO test(a, b) VALUES (123, 'abc')");
            $this->executeStatement("INSERT INTO test(a, b) VALUES (456, 'def')");
            $this->executeStatement("INSERT INTO test(a, b) VALUES (789, 'ghi')");
            
            $record = $this->getQuery()
                ->select('*')
                ->from('test')
                ->where('a = ?', 456)
                ->execute()
                ->fetchObject();
            $this->assertTrue($record instanceof Record);
            $this->assertEquals('456', $record->a);
            $this->assertEquals('def', $record->b);
            
            $a = $this->getQuery()
                ->select('*')
                ->from('test')
                ->orderBy('a ASC')
                ->execute()
                ->fetchAllObjects();
            $this->assertTrue(is_array($a));
            $this->assertEquals(3, count($a));
            
            $this->assertTrue($a[0] instanceof Record);
            $this->assertEquals('123', $a[0]->a);
            $this->assertEquals('abc', $a[0]->b);
            
            $this->assertTrue($a[1] instanceof Record);
            $this->assertEquals('456', $a[1]->a);
            $this->assertEquals('def', $a[1]->b);
            
            $this->assertTrue($a[2] instanceof Record);
            $this->assertEquals('789', $a[2]->a);
            $this->assertEquals('ghi', $a[2]->b);
            
            $this->_connection->disconnect();
            \Bootstrap::dropDatabase($database);
            
        } catch (Exception $e) {
            \Bootstrap::abort($e);
        }
    }
    
    public function getQuery()
    {
        return new Query($this->_connection);
    }
    
    public function executeStatement($rawSql)
    {
        $this->_connection
            ->prepareStatement($rawSql)
            ->execute();
    }
    
}
