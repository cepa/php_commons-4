<?php

/**
 * =============================================================================
 * @file        Commons/Sql/Statement/PdoStatement.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Sql\Statement;

use Commons\Entity\Collection;
use Commons\Log\Log;
use Commons\Sql\Driver\DriverInterface;
use Commons\Sql\Driver\PdoDriver;
use Commons\Sql\Exception;
use Commons\Sql\Sql;

class PdoStatement implements StatementInterface
{
    
    protected $_rawSql;
    protected $_stmt;
    
    /**
     * Init statement.
     * @param DriverInterface $driver
     * @param string $rawSql
     * @throws InvalidArgumentException
     */
    public function __construct(DriverInterface $driver, $rawSql)
    {
        if (!($driver instanceof PdoDriver)) {
            throw new Exception("Driver instance has to be the PdoDriver");
        }    
        $this->_rawSql = $rawSql;
        $this->_stmt = $driver->getPdo()->prepare($rawSql);
    }
    
    /**
     * Destroy statement.
     */
    public function __destruct()
    {
        $this->_stmt = null;
    }
    
    /**
     * @see Commons\Sql\Statement\StatementInterface::bind()
     */
    public function bind($name, $value)
    {
        try {
            if (is_numeric($value)) {
                $this->_stmt->bindValue($name, $value, \PDO::PARAM_INT);
            } else {
                $this->_stmt->bindValue($name, $value, \PDO::PARAM_STR);
            }
            return $this;
        } catch (\PDOException $e) {
            throw new Exception($e);
        }
    }
    
    /**
     * @see Commons\Sql\Statement\StatementInterface::execute()
     */
    public function execute()
    {
        try {
            $this->_stmt->execute();
            return $this;
        } catch (\PDOException $e) {
            Log::log("Invalid query: ".$this->_rawSql);
            throw new Exception($e);
        }
    }
    
    /**
     * @see \Commons\Sql\Statement\StatementInterface::fetch()
     */
    public function fetch($entityClass = '\\Commons\\Entity\\Entity')
    {
        try {
            $row = $this->_stmt->fetch(\PDO::FETCH_ASSOC);
            if (!$row) {
                return null;
            }
            return new $entityClass($row);
        } catch (\PDOException $e) {
            throw new Exception($e);
        }
    }
    
    /**
     * @see \Commons\Sql\Statement\StatementInterface::fetchCollection()
     */
    public function fetchCollection($entityClass = '\\Commons\\Entity\\Entity')
    {
        $rows = $this->fetchArray();
        $collection = new Collection();
        foreach ($rows as $row) {
            $collection->add(new $entityClass($row));
        }
        return $collection;
    }
    
    /**
     * @see \Commons\Sql\Statement\StatementInterface::fetchArray()
     */
    public function fetchArray()
    {
        try {
            return $this->_stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new Exception($e);
        }
    }
    
    /**
     * @see \Commons\Sql\Statement\StatementInterface::fetchScalar()
     */
    public function fetchScalar($index = 0)
    {
        try {
            return $this->_stmt->fetchColumn($index);
        } catch (\PDOException $e) {
            throw new Exception($e);
        }
    }
    
}
