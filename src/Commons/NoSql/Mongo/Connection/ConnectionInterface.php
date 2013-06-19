<?php

/**
 * =============================================================================
 * @file       Commons/NoSql/Mongo/Connection/ConnectionInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\NoSql\Mongo\Connection;

interface ConnectionInterface
{
    
    /**
     * Connect.
     * @param mixed $options
     * @return ConnectionInterface
     */
    public function connect($options = null);
    
    /**
     * Disconnect.
     * @return ConnectionInterface
     */
    public function disconnect();
    
    /**
     * Get Mongo client.
     * @return \MongoClient
     */
    public function getClient();
    
    /**
     * Select Mongo database.
     * @param string $name
     * @return \MongoDB
     */
    public function selectDatabase($name);

    /**
     * Select Mongo collection from currently selected database.
     * @param string $name
     * @return \MongoCollection
     */
    public function selectCollection($name);
    
}
