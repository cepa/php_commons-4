<?php

/**
 * =============================================================================
 * @file        Commons/KeyStore/SessionKeyStoreTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\KeyStore;

class SessionKeyStoreTest extends \PHPUnit_Framework_TestCase
{

    public function testStore()
    {
        $keyStore = new SessionKeyStore();
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
    
    public function testRestoreAndSaveValuesInSession()
    {
        $_SESSION = array('xxx' => 123, 'yyy' => 456);
        $keyStore = new SessionKeyStore();
        $this->assertTrue($keyStore->has('xxx'));
        $this->assertEquals(123, $keyStore->get('xxx'));
        $this->assertTrue($keyStore->has('yyy'));
        $this->assertEquals(456, $keyStore->get('yyy'));
        $this->assertFalse($keyStore->has('zzz'));
        $keyStore->set('xxx', 'foo');
        $this->assertEquals('foo', $_SESSION['xxx']);
    }
    
}