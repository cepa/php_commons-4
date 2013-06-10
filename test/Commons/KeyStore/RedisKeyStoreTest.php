<?php

/**
 * =============================================================================
 * @file        Commons/KeyStore/RedisKeyStoreTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\KeyStore;

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
    
}
