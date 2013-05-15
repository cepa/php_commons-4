<?php

/**
 * =============================================================================
 * @file        Commons/Entity/AbstractRepositoryTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Entity;

use Commons\Entity\RepositoryInterface;
use Mock\Entity\Repository as MockRepository;

class AbstractRepositoryTest extends \PHPUnit_Framework_TestCase
{

    public function testSetGetPrimaryKey()
    {
        $repo = new MockRepository();
        $this->assertEquals('id', $repo->getPrimaryKey());
        $r = $repo->setPrimaryKey('foo');
        $this->assertTrue($r instanceof RepositoryInterface);
        $this->assertEquals('foo', $repo->getPrimaryKey());
    }
    
    public function testSetGetEntityClass()
    {
        $repo = new MockRepository();
        $this->assertEquals('\Commons\Entity\Entity', $repo->getEntityClass());
        $r = $repo->setEntityClass('xxx');
        $this->assertTrue($r instanceof RepositoryInterface);
        $this->assertEquals('xxx', $repo->getEntityClass());
    }
    
}
