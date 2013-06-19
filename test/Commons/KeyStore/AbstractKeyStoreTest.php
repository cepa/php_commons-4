<?php

/**
 * =============================================================================
 * @file       Commons/KeyStore/AbstractKeyStoreTest.php
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
use Commons\Entity\RepositoryInterface;
use Commons\Utils\RandomUtils;
use Mock\KeyStore as MockKeyStore;

class AbstractKeyStoreTest extends \PHPUnit_Framework_TestCase
{

    public function testSetGetRepository()
    {
        $keyStore = new MockKeyStore();
        $repo = $keyStore->getRepository('\Mock\Entity\Repository');
        $this->assertTrue($repo instanceof RepositoryInterface);
    }
    
}
