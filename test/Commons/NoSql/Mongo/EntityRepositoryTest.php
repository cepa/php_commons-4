<?php

/**
 * =============================================================================
 * @file       Commons/NoSql/Mongo/EntityRepositoryTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\NoSql\Mongo;

use Commons\Entity\Entity;
use Commons\NoSql\Mongo\Connection\Connection;
use Commons\Utils\RandomUtils;

class EntityRepositoryTest extends \PHPUnit_Framework_TestCase
{
    
    public function testRepo()
    {
        if (getenv('DISABLE_MONGO') == 1) {
            $this->markTestIncomplete('MongoDB tests are disabled');
            return;
        }
        
        $conn = new Connection();
        $conn->connect(array(
            'dsn'      => 'mongodb://localhost:27017',
            'database' => 'phpcommons' 
        ));
        
        $uuid = RandomUtils::randomUuid();
        $entity = new Entity();
        $entity->uuid = $uuid;
        $entity->first_name = 'Johnny';
        $entity->last_name = 'Walker';
        $entity->email = 'johnny@walker.com';
        
        $repo = new EntityRepository($conn);
        $repo
            ->setCollectionName('Test')
            ->setPrimaryKey('uuid');
        
        $this->assertNull($repo->fetch($uuid));
        $repo->save($entity);
        
        $entity = $repo->fetch($uuid);
        $this->assertTrue($entity instanceof Entity);
        $this->assertEquals($uuid, $entity->uuid);
        
        $repo->delete($entity);
        $this->assertNull($repo->fetch($uuid));
        
        $conn->disconnect();
    }
    
}
