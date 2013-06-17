<?php

/**
 * =============================================================================
 * @file       Commons/NoSql/Cassandra/EntityRepositoryTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

/**
 *
 * In order to run this test:
 * 
 * 1) Create phpcommons keyspace.
 * 
 * # run ./bin/cassandra-cli
 * create keyspace phpcommons with placement_strategy = 'SimpleStrategy' and strategy_options = {replication_factor:1};
 * 
 * 2) Create column family Test.
 * 
 * # run ./bin/cassandra-cli
 * use phpcommons;
 * create column family Test with comparator=UTF8Type and default_validation_class=UTF8Type and key_validation_class=UTF8Type;
 * 
 */

namespace Commons\NoSql\Cassandra;

use phpcassa\Connection\ConnectionPool;
use Commons\Entity\Entity;
use Commons\Utils\RandomUtils;

class EntityRepositoryTest extends \PHPUnit_Framework_TestCase
{
    
    public function testRepo()
    {
        if (getenv('DISABLE_CASSANDRA') == 1) {
            $this->markTestIncomplete('Cassandra tests are disabled');
            return;
        }
        
        $uuid = RandomUtils::randomUuid();
        $entity = new Entity();
        $entity->uuid = $uuid;
        $entity->first_name = 'Johnny';
        $entity->last_name = 'Walker';
        $entity->email = 'johnny@walker.com';
        
        $repo = new EntityRepository($this->getConnection());
        $repo
            ->setColumnFamilyName('Test')
            ->setPrimaryKey('uuid');
        
        $this->assertNull($repo->fetch($uuid));
        $repo->save($entity);
        
        $entity = $repo->fetch($uuid);
        $this->assertTrue($entity instanceof Entity);
        $this->assertEquals($uuid, $entity->uuid);
        
        $repo->delete($entity);
        $this->assertNull($repo->fetch($uuid));
    }
    
    public function getConnection()
    {
        static $connection;
        if (!isset($connection)) {
            $connection = new ConnectionPool('phpcommons', array('localhost:9160'));
        }   
        return $connection; 
    }
    
}
