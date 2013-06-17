<?php

/**
 * =============================================================================
 * @file       Commons/KeyStore/RedisKeyStoreTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\KeyStore;

use Commons\Entity\Entity;
use Commons\Utils\RandomUtils;

class RedisKeyStoreTest extends \PHPUnit_Framework_TestCase
{

    public function testStore()
    {
        if (getenv('DISABLE_REDIS') == 1) {
            $this->markTestIncomplete('Redis tests are disabled');
            return;
        }
        
        if (!class_exists('\Predis\Client')) {
            $this->markTestIncomplete('Please install Predis library');
            return;
        }
        
        $keyStore = new RedisKeyStore();
        $ks = $keyStore->connect(array(
            'servers' => array('scheme' => 'tcp', 'host' => 'localhost', 'port' => 6379)
        ));
        
        // Cleanup.
        $keyStore
            ->remove('xxx')
            ->remove('yyy');
        
        $this->assertTrue($ks instanceof KeyStoreInterface);
        $this->assertFalse($keyStore->has('xxx'));
        $this->assertFalse($keyStore->has('yyy'));
        $this->assertEquals(666, $keyStore->get('yyy', 666));
        $this->assertNull($keyStore->get('yyy'));
        $ks = $keyStore->set('xxx', 123);
        $this->assertTrue($ks instanceof KeyStoreInterface);
        $this->assertTrue($keyStore->has('xxx'));
        $this->assertEquals(123, $keyStore->get('xxx'));
        $keyStore
            ->increment('xxx')
            ->increment('xxx', 2)
            ->increment('xxx', 3);
        $this->assertEquals(123 + 1 + 2 + 3, $keyStore->get('xxx'));
        $keyStore
            ->decrement('xxx')
            ->decrement('xxx', 2)
            ->decrement('xxx', 3);
        $this->assertEquals(123, $keyStore->get('xxx'));
        $ks = $keyStore->remove('xxx');
        $this->assertTrue($ks instanceof KeyStoreInterface);
        $this->assertFalse($keyStore->has('xxx'));
        $this->assertNull($keyStore->get('xxx'));
        $ks = $keyStore->close();
        $this->assertTrue($ks instanceof KeyStoreInterface);
    }
    
    public function testStoreArray()
    {
        if (getenv('DISABLE_REDIS') == 1) {
            $this->markTestIncomplete('Redis tests are disabled');
            return;
        }
        
        if (!class_exists('\Predis\Client')) {
            $this->markTestIncomplete('Please install Predis library');
            return;
        }
        
        $keyStore = new RedisKeyStore();
        $keyStore->connect(array(
            'servers' => array('scheme' => 'tcp', 'host' => 'localhost', 'port' => 6379)
        ));
        $keyStore->remove('xxx');
        $this->assertFalse($keyStore->has('xxx'));
        
        $array = array(
            'first_name' => 'Johnny',
            'last_name'  => 'Walker',
            'email'      => 'johnny@walker.com' 
        );
        
        $ks = $keyStore->set('xxx', $array);
        $this->assertTrue($ks instanceof KeyStoreInterface);
        $this->assertTrue($keyStore->has('xxx'));
        
        $a = $keyStore->get('xxx');
        $this->assertTrue(is_array($a));
        $this->assertEquals(3, count($a));
    }
    
    public function testEntityRepository()
    {
        if (getenv('DISABLE_REDIS') == 1) {
            $this->markTestIncomplete('Redis tests are disabled');
            return;
        }
        
        if (!class_exists('\Predis\Client')) {
            $this->markTestIncomplete('Please install Predis library');
            return;
        }
        
        $keyStore = new RedisKeyStore();
        $keyStore->connect(array(
            'servers' => array('scheme' => 'tcp', 'host' => 'localhost', 'port' => 6379)
        ));
        $keyStore->remove('xxx');
        $this->assertFalse($keyStore->has('xxx'));
                
        $uuid = RandomUtils::randomUuid();
        $entity = new Entity();
        $entity->uuid = $uuid;
        $entity->first_name = 'Johnny';
        $entity->last_name = 'Walker';
        $entity->email = 'johnny@walker.com';
        
        $repo = new EntityRepository($keyStore);
        $repo->setPrimaryKey('uuid');
        
        $this->assertNull($repo->fetch($uuid));
        $repo->save($entity);
        
        $entity = $repo->fetch($uuid);
        $this->assertTrue($entity instanceof Entity);
        $this->assertEquals($uuid, $entity->uuid);
        
        $repo->delete($entity);
        $this->assertNull($repo->fetch($uuid));
    }
    
}
