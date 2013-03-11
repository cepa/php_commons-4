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

use Commons\Exception\NotImplementedException;
use Commons\Exception\InvalidArgumentException;
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
     * @param Commons\Sql\Driver\DriverInterface $driver
     * @param string $rawSql
     * @throws Commons\Exception\InvalidArgumentException
     */
    public function __construct(DriverInterface $driver, $rawSql)
    {
        if (!($driver instanceof PdoDriver)) {
            throw new InvalidArgumentException();
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
     * @see Commons\Sql\Statement\StatementInterface::fetch()
     */
    public function fetch($mode = Sql::FETCH_ARRAY, array $options = array())
    {
        switch ($mode) {
            case Sql::FETCH_ARRAY:
                $array = $this->_fetchAssoc();
                if (!$array) {
                    return null;
                }
                return $array;
                
            case Sql::FETCH_OBJECT:
                $array = $this->_fetchAssoc();
                if (!$array) {
                    return null;
                }
                $className = (isset($options['className']) ? $options['className'] : 'Commons\\Sql\\Record');
                return new $className($array);
                
            default:
                throw new NotImplementedException();
        }
    }
    
    /**
     * @see Commons\Sql\Statement\StatementInterface::fetchAll()
     */
    public function fetchAll($mode = Sql::FETCH_ARRAY, array $options = array())
    {
        switch ($mode) {
            case Sql::FETCH_ARRAY:
                return $this->_fetchAllAssoc();
                
            case Sql::FETCH_OBJECT:
                $collection = array();
                $className = (isset($options['className']) ? $options['className'] : '\\Commons\\Sql\\Record');
                $records = $this->_fetchAllAssoc();
                foreach ($records as $record) {
                    $collection[] = new $className($record);
                }
                return $collection;
                
            default:
                throw new NotImplementedException();
        }
    }
    
    /**
     * @see Commons\Sql\Statement\StatementInterface::fetchColumn()
     */
    public function fetchColumn($name = null)
    {
        $record = $this->_fetchAssoc();
        if (!is_array($record) || count($record) == 0) {
            throw new Exception("Missing or empty result!");
        }
        if (!isset($name)) {
            reset($record);
            return current($record);
        }
        return $record[$name];
    }
    
    protected function _fetchAssoc()
    {
        try {
            return $this->_stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new Exception($e);
        }
    }
    
    protected function _fetchAllAssoc()
    {
        try {
            return $this->_stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new Exception($e);
        }
    }
    
}
