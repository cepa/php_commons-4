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

use \MongoClient;
use Commons\Entity\Entity;
use Commons\Utils\RandomUtils;

class EntityRepositoryTest extends \PHPUnit_Framework_TestCase
{
    
    public function testRepo()
    {
        if (getenv('DISABLE_MONGO') == 1) {
            $this->markTestIncomplete('MongoDB tests are disabled');
            return;
        }
        
        $uuid = RandomUtils::randomUuid();
        $entity = new Entity();
        $entity->uuid = $uuid;
        $entity->first_name = 'Johnny';
        $entity->last_name = 'Walker';
        $entity->email = 'johnny@walker.com';
        
        $repo = new EntityRepository($this->getMongoDb());
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
    }
    
    public function getMongoDb()
    {
        static $client;
        if (!isset($client)) {
            $client = new MongoClient('mongodb://localhost:27017');
        }   
        return $client->phpcommons; 
    }
    
}
