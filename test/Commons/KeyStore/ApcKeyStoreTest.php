<?php

/**
 * =============================================================================
 * @file       Commons/KeyStore/ApcKeyStoreTest.php
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

class ApcKeyStoreTest extends \PHPUnit_Framework_TestCase
{

    public function testStore()
    {
        if (ini_get('apc.enable_cli') != 1) {
            $this->markTestIncomplete('Please set ini apc.enable_cli=1');
            return;
        }
        
        $keyStore = new ApcKeyStore();
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
    }
    
    public function testStoreArray()
    {
        if (ini_get('apc.enable_cli') != 1) {
            $this->markTestIncomplete('Please set ini apc.enable_cli=1');
            return;
        }
        
        $array = array(
            'first_name' => 'Johnny',
            'last_name'  => 'Walker',
            'email'      => 'johnny@walker.com' 
        );
        
        $keyStore = new ApcKeyStore();
        $keyStore->remove('xxx');
        $this->assertFalse($keyStore->has('xxx'));
        
        $ks = $keyStore->set('xxx', $array);
        $this->assertTrue($ks instanceof KeyStoreInterface);
        $this->assertTrue($keyStore->has('xxx'));
        
        $a = $keyStore->get('xxx');
        $this->assertTrue(is_array($a));
        $this->assertEquals(3, count($a));
    }
    
    public function testEntityRepository()
    {
        if (ini_get('apc.enable_cli') != 1) {
            $this->markTestIncomplete('Please set ini apc.enable_cli=1');
            return;
        }
        
        $keyStore = new ApcKeyStore();
        $keyStore->remove('xxx');
        
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
