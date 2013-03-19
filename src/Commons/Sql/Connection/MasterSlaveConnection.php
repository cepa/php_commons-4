<?php

/**
 * =============================================================================
 * @file        Commons/Sql/Connection/MasterSlaveConnection.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Sql\Connection;

use Commons\Sql\Driver\DriverInterface;
use Commons\Sql\Driver\PdoDriver;
use Commons\Sql\Exception;
use Commons\Sql\Statement\StatementInterface;
use Commons\Utils\StringUtils;

class MasterSlaveConnection extends AbstractConnection
{

    protected $_masterDriver;
    protected $_slaveDriver;
    protected $_tables = array();
    
    /**
     * Setup connection object.
     * @param DriverInterface $masterDriver
     * @param DriverInterface $slaveDriver
     */
    public function __construct(DriverInterface $masterDriver = null, DriverInterface $slaveDriver = null)
    {
        $this->_masterDriver = $masterDriver;
        $this->_slaveDriver = $slaveDriver;
    }
    
    /**
     * Set master driver.
     * @param DriverInterface $masterDriver
     * @return \Commons\Sql\Connection\MasterSlaveConnection
     */
    public function setMasterDriver(DriverInterface $masterDriver)
    {
        $this->_masterDriver = $masterDriver;
        return $this;
    }
    
    /**
     * Get master driver.
     * @throws Exception
     * @return DriverInterface
     */
    public function getMasterDriver()
    {
        if (!isset($this->_masterDriver)) {
            $this->setMasterDriver(new PdoDriver());
        }
        return $this->_masterDriver;
    }
    
    /**
     * Has master driver?
     * @return boolean
     */
    public function hasMasterDriver()
    {
        return isset($this->_masterDriver);
    }
    
    /**
     * Set slave driver.
     * @param DriverInterface $slaveDriver
     * @return \Commons\Sql\Connection\MasterSlaveConnection
     */
    public function setSlaveDriver(DriverInterface $slaveDriver)
    {
        $this->_slaveDriver = $slaveDriver;
        return $this;
    }
    
    /**
     * Get slave driver.
     * @throws Exception
     * @return DriverInterface
     */
    public function getSlaveDriver()
    {
        if (!isset($this->_slaveDriver)) {
            $this->setSlaveDriver(new PdoDriver());
        }
        return $this->_slaveDriver;
    }
    
    /**
     * Has slave driver?
     * @return boolean
     */
    public function hasSlaveDriver()
    {
        return isset($this->_slaveDriver);
    }
        
    /**
     * Connect to the database.
     * @param array $options
     * @return ConnectionInterface
     */
    public function connect($options = null)
    {
        $this->getMasterDriver()->connect(isset($options['master']) ? $options['master'] : null);
        $this->getSlaveDriver()->connect(isset($options['slave']) ? $options['slave'] : null);
        return $this;
    }
    
    /**
     * Disconnect from the database.
     * @return ConnectionInterface
     */
    public function disconnect()
    {
        $this->getMasterDriver()->disconnect();
        $this->getSlaveDriver()->disconnect();
        return $this;
    }
    
    /**
     * Check if connected.
     * @return boolean
     */
    public function isConnected()
    {
        return ($this->getMasterDriver()->isConnected() && $this->getSlaveDriver()->isConnected());
    }
    
    /**
     * Prepare a statement.
     * @note Automatically detects if a query should be executed on master or on slave server.
     * @param string $rawSql
     * @param mixed $options
     * @return StatementInterface
     */
    public function prepareStatement($rawSql, $options = null)
    {
        // Use slave by default.
        $driver = $this->getSlaveDriver();
        
        // If transaction is opened use master.
        if ($this->inTransaction()) {
            $driver = $this->getMasterDriver();
        
        } else {
            // If $rawSql does not begin with SELECT then use master.
            if (!StringUtils::startsWith($rawSql, 'SELECT', false)) {
                $driver = $this->getMasterDriver();
            }
        }
        
        // If $options['driver'] == 'master' use master driver explicitly.
        if (is_array($options) && isset($options['driver']) && $options['driver'] == 'master') {
            $driver = $this->getMasterDriver();
        }
        
        return $driver->prepareStatement($rawSql);
    }
    
    /**
     * Begin transaction.
     * @return ConnectionInterface
     */
    public function begin()
    {
        $this->getMasterDriver()->begin();
        return $this;
    }
    
    /**
     * Commit transaction.
     * @return ConnectionInterface
     */
    public function commit()
    {
        $this->getMasterDriver()->commit();
        return $this;
    }
    
    /**
     * Rollback transaction.
     * @return ConnectionInterface
     */
    public function rollback()
    {
        $this->getMasterDriver()->rollback();
        return $this;
    }
    
    /**
     * Check if in transaction.
     * @return boolean
     */
    public function inTransaction()
    {
        return $this->getMasterDriver()->inTransaction();
    }

    /**
     * @return string
     */
    public function getDatabaseType()
    {
        return $this->getMasterDriver()->getDatabaseType();
    }
    
}
