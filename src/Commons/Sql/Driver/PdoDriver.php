<?php

/**
 * =============================================================================
 * @file        Commons/Sql/Driver/PdoDriver.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Sql\Driver;

use Commons\Exception\InvalidArgumentException;
use Commons\Sql\Exception;
use Commons\Sql\Statement\PdoStatement;
use Commons\Sql\Sql;

class PdoDriver implements DriverInterface
{
    
    protected $_pdo;
    protected $_inTransaction = false;
    
    /**
     * Dummy.
     */
    public function __construct()
    {
        
    }
    
    /**
     * Close connection when destroying an object.
     */
    public function __destruct()
    {
        $this->disconnect();
    }
    
    /**
     * Get pdo driver.
     * @note Don't use pdo references to avoid connection hanging.
     * @throws Exception
     * @return \PDO
     */
    public function getPdo()
    {
        if (!isset($this->_pdo)) {
            throw new Exception("Driver is not connected to the database!");
        }
        return $this->_pdo;
    }

    /**
     * @see Commons\Sql\Driver\DriverInterface::getDatabaseType()
     */
    public function getDatabaseType()
    {
        $driverName = strtolower($this->getPdo()->getAttribute(\PDO::ATTR_DRIVER_NAME));
        switch ($driverName) {
            case 'mysql': return Sql::TYPE_MYSQL;
            case 'pgsql': return Sql::TYPE_POSTGRESQL;
        }
        return $driverName;
    }
    
    /**
     * @see Commons\Sql\Driver\DriverInterface::connect()
     */
    public function connect($options = null)
    {
        if ($this->isConnected()) {
            throw new Exception("Driver is already connected to the database!");    
        }
        
        if (!isset($options['driver'])) {
            throw new InvalidArgumentException("Missing driver option!");
        }
        
        $driver    = $options['driver'];
        $host      = (isset($options['host']) ? $options['host'] : 'localhost');
        $port      = (isset($options['port']) ? $options['port'] : null);
        $database  = (isset($options['database']) ? $options['database'] : null);
        $username  = (isset($options['username']) ? $options['username'] : null);
        $password  = (isset($options['password']) ? $options['password'] : null);
        
        $dsn = "{$driver}:host={$host};";
        if (!empty($port)) {
            $dsn .= "port={$port};";
        }
        if (!empty($database)) {
            $dsn .= "dbname={$database};";
        }

        try {
            $this->_pdo = new \PDO($dsn, $username, $password);
            $this->_pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            
            // MySQL charset.
            if (strtolower($driver) == 'mysql' && isset($options['charset'])) {
                $this->_pdo->exec("SET NAMES ".$options['charset']);
                $this->_pdo->exec("SET CHARSET ".$options['charset']);
            }
            
        } catch (\PDOException $e) {
            throw new Exception($e);
        }
    }
    
    /**
     * @see Commons\Sql\Driver\DriverInterface::disconnect()
     */
    public function disconnect()
    {
        $this->_pdo = null;
    }
    
    /**
     * @see Commons\Sql\Driver\DriverInterface::isConnected()
     */
    public function isConnected()
    {
        return isset($this->_pdo);
    }
    
    /**
     * @see Commons\Sql\Driver\DriverInterface::prepareStatement()
     */
    public function prepareStatement($rawSql)
    {
        return new PdoStatement($this, $rawSql);
    }
    
    /**
     * @see Commons\Sql\Driver\DriverInterface::begin()
     */
    public function begin()
    {
        try {
            $this->getPdo()->beginTransaction();
            $this->_inTransaction = true;
        } catch (\PDOException $e) {
            throw new Exception($e);
        }
    }
    
    /**
     * @see Commons\Sql\Driver\DriverInterface::commit()
     */
    public function commit()
    {
        try {
            $this->getPdo()->commit();
            $this->_inTransaction = false;
        } catch (\PDOException $e) {
            throw new Exception($e);
        }
    }
    
    /**
     * @see Commons\Sql\Driver\DriverInterface::rollback()
     */
    public function rollback()
    {
        try {
            $this->getPdo()->rollBack();
            $this->_inTransaction = false;
        } catch (\PDOException $e) {
            throw new Exception($e);
        }
    }
    
    /**
     * @see Commons\Sql\Driver\DriverInterface::inTransaction()
     */
    public function inTransaction()
    {
        try {
            if (method_exists($this->getPdo(), 'inTransaction')) {
                // Force type to boolean.
                return ($this->getPdo()->inTransaction() ? true : false);
            } else {
                return $this->_inTransaction;
            }
        } catch (\PDOException $e) {
            throw new Exception($e);
        }
    }
    
}
