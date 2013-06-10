<?php

/**
 * =============================================================================
 * @file        Commons/KeyStore/EntityRepositoryTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\KeyStore;

use Commons\Entity\Entity;
use Commons\Entity\RepositoryInterface;

class EntityRepositoryTest extends \PHPUnit_Framework_TestCase
{

    public function testSetGetKeyStore()
    {
        $repo = new EntityRepository();
        $this->assertNull($repo->getKeyStore());
        $r = $repo->setKeyStore(new SessionKeyStore());
        $this->assertTrue($r instanceof RepositoryInterface);
        $this->assertTrue($repo->getKeyStore() instanceof KeyStoreInterface);
    }
    
    public function testRepo()
    {
        $repo = new EntityRepository();
        $repo->setKeyStore(new SessionKeyStore());
        
        $this->assertEquals('\Commons\Entity\Entity', $repo->getEntityClass());
        $r = $repo->setEntityClass('xxx');
        $this->assertTrue($r instanceof EntityRepository);
        $this->assertEquals('xxx', $repo->getEntityClass());
        $repo->setEntityClass('\Commons\Entity\Entity');
        
        $_SESSION = array(
            'abc' => array('id' => 'abc', 'a' => 123, 'b' => 'abc')
        );
        
        $entity = $repo->fetch('abc');
        $this->assertTrue($entity instanceof Entity);
        $this->assertTrue($entity->has($repo->getPrimaryKey()));
        $this->assertEquals('abc', $entity->id);
        $this->assertEquals(123, $entity->a);
        $this->assertEquals('abc', $entity->b);
        
        $entity->a = '666';
        $entity->b = 'xxx';
        $r = $repo->save($entity);
        $this->assertTrue($r instanceof EntityRepository);
        
        $entity = $repo->fetch('abc');
        $this->assertTrue($entity instanceof Entity);
        $this->assertEquals('abc', $entity->id);
        $this->assertEquals(666, $entity->a);
        $this->assertEquals('xxx', $entity->b);
        
        $r = $repo->delete($entity);
        $this->assertTrue($r instanceof EntityRepository);
        
        $this->assertNull($repo->fetch('abc'));
        
        $entity = new Entity();
        $entity->id = 'xxx';
        $entity->a = '999';
        $entity->b = 'yyy';
        $r = $repo->save($entity);
        $this->assertTrue($r instanceof EntityRepository);
        
        $entity->a = '888';
        $entity->b = 'zzz';
        $repo->save($entity);
        
        $entity = $repo->fetch('xxx');
        $this->assertTrue($entity instanceof Entity);
        $this->assertEquals('888', $entity->a);
        $this->assertEquals('zzz', $entity->b);
    }
    
    public function testRepoFetchCollectionException()
    {
        $this->setExpectedException('\Commons\KeyStore\Exception');
        $repo = new EntityRepository();
        $repo->fetchCollection();
    }
    
    public function testRepoInvalidKeyValue()
    {
        $_SESSION = array('xxx' => 'abc');
        $this->setExpectedException('\Commons\KeyStore\Exception');
        $repo = new EntityRepository();
        $repo->setKeyStore(new SessionKeyStore());
        $repo->fetch('xxx');
    }
    
}
