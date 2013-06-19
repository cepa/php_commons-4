<?php

/**
 * =============================================================================
 * @file       Commons/NoSql/Mongo/Connection/Connection.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\NoSql\Mongo\Connection;

use \MongoClient;
use Commons\NoSql\Mongo\Exception;

class Connection extends AbstractConnection
{
    
    private $_client;
    private $_db;
    
    public function connect($options = null)
    {
        $client = new MongoClient($options['dsn']);
        $this->setClient($client);
        if (isset($options['database'])) {
            $this->selectDatabase($options['database']);
        }
        return $this;
    }
    
    public function disconnect()
    {
        if ($this->_client) {
            $this->getClient()->close();
        }
        return $this;
    }
    
    public function isConnected()
    {
        return isset($this->_client);
    }
    
    public function setClient(MongoClient $client)
    {
        $this->_client = $client;
        return $this;
    }
    
    public function getClient()
    {
        if (!isset($this->_client)) {
            throw new Exception("Mongo is not connected");
        }
        return $this->_client;
    }
    
    public function selectDatabase($name)
    {
        $this->_db = $this->getClient()->selectDB($name);
        return $this->_db;
    }
    
    public function getSelectedDatabase()
    {
        if (!isset($this->_db)) {
            throw new Exception("Database is not selected");
        }
        return $this->_db;
    }

    public function selectCollection($name)
    {
        return $this->getSelectedDatabase()->selectCollection($name);
    }
    
}
