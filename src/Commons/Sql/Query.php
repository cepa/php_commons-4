<?php

/**
 * =============================================================================
 * @file        Commons/Sql/Query.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Sql;

use Commons\Exception\InvalidArgumentException;
use Commons\Container\AssocContainer;
use Commons\Sql\Connection\ConnectionInterface;

class Query implements \Countable 
{

    const TYPE_SELECT = 'SELECT';
    const TYPE_INSERT = 'INSERT';
    const TYPE_UPDATE = 'UPDATE';
    const TYPE_DELETE = 'DELETE';

    protected $_connection = null;
    protected $_type = self::TYPE_SELECT;
    protected $_statement = null;
    
    protected $_paramsCounter = 0;
    protected $_params = null;
    protected $_updates = null;
    
    protected $_beginningExpression = null;
    protected $_fromExpression = null;
    protected $_whereExpression = null;
    protected $_groupByExpression = null;
    protected $_havingExpression = null;
    protected $_unionExpression = null;
    protected $_orderByExpression = null;
    protected $_limitExpression = null;
    protected $_offsetExpression = null;
    protected $_joinExpression = null;
    protected $_endingExpression = null;
    
    protected $_objectClassName = '\\Commons\\Sql\\Record';
    
    /**
     * Init a new query.
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection = null)
    {
        $this->_connection = $connection;
        $this->reset();
    }
    
    /**
     * Destroy query.
     */
    public function __destruct()
    {
        $this->_connection = null;
    }
    
    /**
     * Countable.
     * @return int
     */
    public function count()
    {
        return $this->_params->count();
    }
    
    /**
     * Set parameter.
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $this->_params->set($name, $value);
    }
    
    /**
     * Get parameter.
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->_params->get($name);
    }
    
    /**
     * Check if parameter is set.
     * @param string $name
     * @return boolean
     */
    public function __isset($name)
    {
        return $this->_params->has($name);
    }
    
    /**
     * Remove parameter.
     * @param string $name
     */
    public function __unset($name)
    {
        $this->_params->remove($name);   
    }
    
    /**
     * Set sql connection.
     * @param ConnectionInterface $connection
     * @return Query
     */
    public function setConnection(ConnectionInterface $connection)
    {
        $this->_connection = $connection;
        return $this;
    }

    /**
     * Get connection.
     * @return ConnectionInterface
     */
    public function getConnection()
    {
        return $this->_connection;
    }
    
    /**
     * Set query type.
     * @param const $type
     * @return \Query
     */
    public function setType($type)
    {
        $this->_type = $type;
        return $this;
    }

    /**
     * Get query type.
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }
    
    /**
     * Set object class name.
     * @param string $className
     * @return Query
     */
    public function setObjectClassName($className)
    {
        $this->_objectClassName = $className;
        return $this;
    }
    
    /**
     * Get object class name.
     * @return string
     */
    public function getObjectClassName()
    {
        return $this->_objectClassName;
    }

    /**
     * Reset instance.
     * @return Query
     */
    public function reset()
    {
        $this->_type = self::TYPE_SELECT;
        $this->_paramsCounter = 0;
        $this->_params = new AssocContainer();
        $this->_updates = new AssocContainer();
        $this->_beginningExpression = new QueryExpression();
        $this->_fromExpression = new QueryExpression();
        $this->_whereExpression = new QueryExpression();
        $this->_groupByExpression = new QueryExpression();
        $this->_havingExpression = new QueryExpression();
        $this->_unionExpression = new QueryExpression();
        $this->_orderByExpression = new QueryExpression();
        $this->_limitExpression = new QueryExpression();
        $this->_offsetExpression = new QueryExpression();
        $this->_joinExpression = new QueryExpression();
        $this->_endingExpression = new QueryExpression();
        return $this;
    }

    public function __clone()
    {
        $this->_params = clone $this->_params;
        $this->_updates = clone $this->_updates;
        $this->_beginningExpression    = clone $this->_beginningExpression;
        $this->_fromExpression         = clone $this->_fromExpression;
        $this->_whereExpression        = clone $this->_whereExpression;
        $this->_groupByExpression      = clone $this->_groupByExpression;
        $this->_havingExpression       = clone $this->_havingExpression;
        $this->_unionExpression        = clone $this->_unionExpression;
        $this->_orderByExpression      = clone $this->_orderByExpression;
        $this->_limitExpression        = clone $this->_limitExpression;
        $this->_offsetExpression       = clone $this->_offsetExpression;
        $this->_joinExpression         = clone $this->_joinExpression;
        $this->_endingExpression       = clone $this->_endingExpression;       
    }
    
    /**
     * Get beginning expression (SELETC, INSERT, UPDATE, DELETE).
     * @return QueryExpression
     */
    public function getBeginning()
    {
        return $this->_beginningExpression;
    }

    /**
     * Get FROM expression.
     * @return QueryExpression
     */
    public function getFrom()
    {
        return $this->_fromExpression;
    }

    /**
     * Get WHERE expression.
     * @return QueryExpression
     */
    public function getWhere()
    {
        return $this->_whereExpression;
    }

    /**
     * Get GROUP BY expression.
     * @return QueryExpression
     */
    public function getGroupBy()
    {
        return $this->_groupByExpression;
    }

    /**
     * Get HAVING expression.
     * @return QueryExpression
     */
    public function getHaving()
    {
        return $this->_havingExpression;
    }

    /**
     * Get UNION expression.
     * @return QueryExpression
     */
    public function getUnion()
    {
        return $this->_unionExpression;
    }

    /**
     * Get ORDER BY expression.
     * @return QueryExpression
     */
    public function getOrderBy()
    {
        return $this->_orderByExpression;
    }

    /**
     * Get LIMIT expression.
     * @return QueryExpression
     */
    public function getLimit()
    {
        return $this->_limitExpression;
    }

    /**
     * Get OFFSET expression.
     * @return QueryExpression
     */
    public function getOffset()
    {
        return $this->_offsetExpression;
    }

    /**
     * Get JOIN expression.
     * @return QueryExpression
     */
    public function getJoin()
    {
        return $this->_joinExpression;
    }

    /**
     * Get ending (custom) expression.
     * @return QueryExpression
     */
    public function getEnding()
    {
        return $this->_endingExpression;
    }

    /**
     * SELECT statement.
     * @param string $sql
     * @return Query
     */
    public function select($sql)
    {
        $args = func_get_args();
        $this->_type = self::TYPE_SELECT;
        $this->_beginningExpression
            ->set('SELECT')
            ->add($this->_processSql($sql, $args));
        return $this;
    }

    /**
     * Append to a SELECT statement.
     * @param string $sql
     * @return Query
     */
    public function addSelect($sql)
    {
        $args = func_get_args();
        $this->_type = self::TYPE_SELECT;
        if ($this->_beginningExpression->isEmpty()) {
            $this->_beginningExpression->add('SELECT');
        } else {
            $this->_beginningExpression->add(',');
        }
        $this->_beginningExpression->add($this->_processSql($sql, $args));
        return $this;
    }

    /**
     * INSERT statement.
     * @param string $sql
     * @return Query
     */
    public function insertInto($sql)
    {
        $args = func_get_args();
        $this->_type = self::TYPE_INSERT;
        $this->_beginningExpression
            ->set('INSERT')
            ->add('INTO')
            ->add($this->_processSql($sql, $args));
        return $this;
    }

    /**
     * UPDATE statement.
     * @param string $sql
     * @return Query
     */
    public function update($sql)
    {
        $args = func_get_args();
        $this->_type = self::TYPE_UPDATE;
        $this->_beginningExpression
            ->set('UPDATE')
            ->add($this->_processSql($sql, $args));
        return $this;
    }

    /**
     * DELETE statement.
     * @param string $sql
     * @return Query
     */
    public function delete($sql)
    {
        $args = func_get_args();
        $this->_type = self::TYPE_DELETE;
        $this->_beginningExpression
            ->set('DELETE')
            ->add('FROM')
            ->add($this->_processSql($sql, $args));
        return $this;
    }

    /**
     * FROM statement.
     * @param string $sql
     * @return Query
     */
    public function from($sql)
    {
        $args = func_get_args();
        $this->_fromExpression
            ->set('FROM')
            ->add($this->_processSql($sql, $args));
        return $this;
    }

    /**
     * Append to a FROM statement.
     * @param unknown_type $sql
     * @return Query
     */
    public function addFrom($sql)
    {
        $args = func_get_args();
        if ($this->_fromExpression->isEmpty()) {
            $this->_fromExpression->add('FROM');
        } else {
            $this->_fromExpression->add(',');
        }
        $this->_fromExpression->add($this->_processSql($sql, $args));
        return $this;
    }

    /**
     * WHERE statement.
     * @param string $sql
     * @return Query
     */
    public function where($sql)
    {
        $args = func_get_args();
        $this->_whereExpression
            ->set('WHERE')
            ->add($this->_processSql($sql, $args));
        return $this;
    }

    /**
     * AND statement.
     * @param string $sql
     * @return Query
     */
    public function andWhere($sql)
    {
        $args = func_get_args();
        if ($this->_whereExpression->isEmpty()) {
            $this->_whereExpression->add('WHERE');
        } else {
            $this->_whereExpression->add('AND');
        }
        $this->_whereExpression->add($this->_processSql($sql, $args));
        return $this;
    }

    /**
     * Wrapper for andWhere.
     * @param string $sql
     * @return Query
     */
    public function addWhere($sql)
    {
        $args = func_get_args();
        if ($this->_whereExpression->isEmpty()) {
            $this->_whereExpression->add('WHERE');
        } else {
            $this->_whereExpression->add('AND');
        }
        $this->_whereExpression->add($this->_processSql($sql, $args));
        return $this;
    }

    /**
     * OR statement.
     * @param string $sql
     * @return Query
     */
    public function orWhere($sql)
    {
        $args = func_get_args();
        if ($this->_whereExpression->isEmpty()) {
            $this->_whereExpression->add('WHERE');
        } else {
            $this->_whereExpression->add('OR');
        }
        $this->_whereExpression->add($this->_processSql($sql, $args));
        return $this;
    }

    /**
     * GROUP BY statement.
     * @param string $sql
     * @return Query
     */
    public function groupBy($sql)
    {
        $args = func_get_args();
        $this->_groupByExpression
            ->set('GROUP BY')
            ->add($this->_processSql($sql, $args));
        return $this;
    }

    /**
     * Append to a GROUP BY statement.
     * @param string $sql
     * @return Query
     */
    public function addGroupBy($sql)
    {
        $args = func_get_args();
        if ($this->_groupByExpression->isEmpty()) {
            $this->_groupByExpression->add('GROUP BY');
        } else {
            $this->_groupByExpression->add(',');
        }
        $this->_groupByExpression->add($this->_processSql($sql, $args));
        return $this;
    }

    /**
     * HAVING statement.
     * @param string $sql
     * @return Query
     */
    public function having($sql)
    {
        $args = func_get_args();
        $this->_havingExpression
            ->set('HAVING')
            ->add($this->_processSql($sql, $args));
        return $this;
    }

    /**
     * UNION statement.
     * @param string $sql
     * @return Query
     */
    public function union($sql)
    {
        $args = func_get_args();
        $this->_unionExpression
            ->set('UNION')
            ->add($this->_processSql($sql, $args));
        return $this;
    }

    /**
     * ORDER BY statement.
     * @param string $sql
     * @return Query
     */
    public function orderBy($sql)
    {
        $args = func_get_args();
        $this->_orderByExpression
            ->set('ORDER BY')
            ->add($this->_processSql($sql, $args));
        return $this;
    }

    /**
     * Append to an ORDER BY statement.
     * @param string $sql
     * @return Query
     */
    public function addOrderBy($sql)
    {
        $args = func_get_args();
        if ($this->_orderByExpression->isEmpty()) {
            $this->_orderByExpression->add('ORDER BY');
        } else {
            $this->_orderByExpression->add(',');
        }
        $this->_orderByExpression->add($this->_processSql($sql, $args));
        return $this;
    }

    /**
     * LIMIT statement.
     * @param string $sql
     * @return Query
     */
    public function limit($sql)
    {
        if (!$sql) {
            $this->_limitExpression->clear();
            return $this;
        }
        $args = func_get_args();
        $this->_limitExpression
            ->set('LIMIT')
            ->add($this->_processSql($sql, $args));
        return $this;
    }

    /**
     * OFFSET statement.
     * @param string $sql
     * @return Query
     */
    public function offset($sql)
    {
        if (!$sql) {
            $this->_offsetExpression->clear();
            return $this;
        }
        $args = func_get_args();
        $this->_offsetExpression
            ->set('OFFSET')
            ->add($this->_processSql($sql, $args));
        return $this;
    }

    /**
     * JOIN statement.
     * @param string $sql
     * @return Query
     */
    public function join($sql)
    {
        $args = func_get_args();
        $this->_joinExpression
            ->add('JOIN')
            ->add($this->_processSql($sql, $args));
        return $this;
    }

    /**
     * LEFT JOIN statement.
     * @param string $sql
     * @return Query
     */
    public function leftJoin($sql)
    {
        $args = func_get_args();
        $this->_joinExpression
            ->add("LEFT JOIN")
            ->add($this->_processSql($sql, $args));
        return $this;
    }

    /**
     * LEFT OUTER statement.
     * @param string $sql
     * @return Query
     */
    public function leftOuterJoin($sql)
    {
        $args = func_get_args();
        $this->_joinExpression
            ->add("LEFT OUTER JOIN")
            ->add($this->_processSql($sql, $args));
        return $this;
    }

    /**
     * RIGHT JOIN statement.
     * @param string $sql
     * @return Query
     */
    public function rightJoin($sql)
    {
        $args = func_get_args();
        $this->_joinExpression
            ->add("RIGHT JOIN")
            ->add($this->_processSql($sql, $args));
        return $this;
    }

    /**
     * RIGHT OUTER statement.
     * @param string $sql
     * @return Query
     */
    public function rightOuterJoin($sql)
    {
        $args = func_get_args();
        $this->_joinExpression
            ->add("RIGHT OUTER JOIN")
            ->add($this->_processSql($sql, $args));
        return $this;
    }

    /**
     * INNER JOIN statement.
     * @param string $sql
     * @return Query
     */
    public function innerJoin($sql)
    {
        $args = func_get_args();
        $this->_joinExpression
            ->add("INNER JOIN")
            ->add($this->_processSql($sql, $args));
        return $this;
    }

    /**
     * CROSS JOIN statement.
     * @param string $sql
     * @return Query
     */
    public function crossJoin($sql)
    {
        $args = func_get_args();
        $this->_joinExpression
            ->add("CROSS JOIN")
            ->add($this->_processSql($sql, $args));
        return $this;
    }

    /**
     * NATURAL JOIN statement.
     * @param string $sql
     * @return Query
     */
    public function naturalJoin($sql)
    {
        $args = func_get_args();
        $this->_joinExpression
            ->add("NATURAL JOIN")
            ->add($this->_processSql($sql, $args));
        return $this;
    }

    /**
     * Custom ending statement.
     * @param string $sql
     * @return Query
     */
    public function ending($sql)
    {
        $args = func_get_args();
        $this->_endingExpression->set($this->_processSql($sql, $args));
        return $this;
    }

    /**
     * Convert to an SQL string.
     * @return string
     */
    public function toSql()
    {
        $sql = '';

        switch ($this->_type) {
            case self::TYPE_SELECT:
                $sql =
                    $this->_beginningExpression->toSql().
                    $this->_fromExpression->toSql().
                    $this->_joinExpression->toSql().
                    $this->_whereExpression->toSql().
                    $this->_groupByExpression->toSql().
                    $this->_havingExpression->toSql().
                    $this->_unionExpression->toSql().
                    $this->_orderByExpression->toSql().
                    $this->_limitExpression->toSql().
                    $this->_offsetExpression->toSql().
                    $this->_endingExpression->toSql();
                break;

            case self::TYPE_INSERT:
                $sql =
                    $this->_beginningExpression->toSql().
                    $this->_generateInsertExpression()->toSql().
                    $this->_endingExpression->toSql();
                break;

            case self::TYPE_UPDATE:
                $sql =
                    $this->_beginningExpression->toSql().
                    $this->_generateUpdateExpression()->toSql().
                    $this->_whereExpression->toSql().
                    $this->_limitExpression->toSql().
                    $this->_offsetExpression->toSql().
                    $this->_endingExpression->toSql();
                break;

            case self::TYPE_DELETE:
                $sql =
                    $this->_beginningExpression->toSql().
                    $this->_whereExpression->toSql().
                    $this->_limitExpression->toSql().
                    $this->_offsetExpression->toSql().
                    $this->_endingExpression->toSql();
                break;

            default:
                throw new InvalidArgumentException(
                	"Unknown query type '{$this->type}'!");
        }
        return trim($sql);
    }

    /**
     * Execute a query and fetch the result.
     * @param int $hydrate
     * @param mixed $options
     * @return Query
     */
    public function execute($options = null)
    {
        $this->_statement = $this->getConnection()
            ->prepareStatement($this->toSql(), $options);

        foreach ($this->_params->getAll() as $name => $value) {
            $this->getStatement()->bind(':'.$name, $value);
        }

        $this->getStatement()->execute();

        return $this;
    }
    
    /**
     * Fetch single row.
     * @param int $mode
     * @return array|AssocContainer
     */
    public function fetch($mode = Sql::FETCH_ARRAY)
    {
        return $this->getStatement()->fetch($mode);
    }
    
    /**
     * Fetch single row as object.
     * @return Record
     */
    public function fetchObject()
    {
        $options = array(
            'className' => $this->_objectClassName
        );
        $object = $this->getStatement()->fetch(Sql::FETCH_OBJECT, $options);
        if ($object instanceof Record) {
            $object->setConnection($this->getConnection());
        }
        return $object;
    }
    
    /**
     * Fetch all rows.
     * @param int $mode
     * @return array
     */
    public function fetchAll($mode = Sql::FETCH_ARRAY)
    {
        return $this->getStatement()->fetchAll($mode);
    }
    
    /**
     * Fetch all rows as array of objects.
     * @return array
     */
    public function fetchAllObjects()
    {
        $options = array(
            'className' => $this->_objectClassName
        );
        $collection = $this->getStatement()->fetchAll(Sql::FETCH_OBJECT, $options);
        foreach ($collection as $object) {
            if ($object instanceof Record) {
                $object->setConnection($this->getConnection());
            }
        }
        return $collection;
    }
    
    /**
     * Fetch single value from a column.
     * @param string $name
     * @return int|string
     */
    public function fetchColumn($name = null)
    {
        return $this->getStatement()->fetchColumn($name);
    }
    
    /**
     * Get statement.
     * @throws Exception
     * @return \Commons\Sql\Statement\StatementInterface
     */
    public function getStatement()
    {
        if (!$this->_statement) {
            throw new Exception("Execute the query first!");
        }
        return $this->_statement;
    }
    
    /**
     * Set update in insert and update query.
     * @param string $name
     * @param mixed $value
     * @return Query
     */
    public function set($name, $value)
    {
        $this->_updates->set($name, $value);
        return $this;
    }
    
    /**
     * Convert to string.
     * @return string
     */
    public function __toString()
    {
        return $this->toSql();
    }

    /**
     * Process sql and bind paramteres.
     * @param string $sql
     * @param array $params
     * @throws Exception
     * @return string
     */
    protected function _processSql($sql, array $params)
    {
        $out = '';
        $tokens = explode('?', $sql);
        
        $n = count($tokens);
        $m = count($params) - 1;
        if ($m + 1 < $n) {
            throw new Exception("Missing bind parameters!");
        }
        
        for ($i = 0; $i < $m; $i++) {
            $paramName = '_'.++$this->_paramsCounter;
            $out .= $tokens[$i];
            $out .= ':'.$paramName;
            $this->_params->set($paramName, $params[$i+1]);
        }
        $out .= $tokens[$i];
        
        return $out;
    }
    
    /**
     * Generate sql part for insert query.
     * @return string
     */
    protected function _generateInsertExpression()
    {
        $exp = new QueryExpression();
        
        $exp->add('(');
        $isFirst = true;
        foreach ($this->_updates->getAll() as $column => $value) {
            if ($isFirst) {
                $isFirst = false;
            } else {
                $exp->add(',');
            }
            $exp->add($column);
        }
        $exp->add(')');
        
        $exp->add('VALUES');
        
        $exp->add('(');
        $isFirst = true;
        foreach ($this->_updates->getAll() as $column => $value) {
            if ($isFirst) {
                $isFirst = false;
            } else {
                $exp->add(',');
            }
            $paramName = '_'.++$this->_paramsCounter;
            $exp->add(':'.$paramName);
            $this->_params->set($paramName, $value);
        }
        $exp->add(')');
        
        return $exp;
    }
    
    /**
     * Generate sql part for update query.
     * @return string
     */
    protected function _generateUpdateExpression()
    {
        $exp = new QueryExpression();
        
        $exp->add('SET');
        
        $isFirst = true;
        foreach ($this->_updates->getAll() as $column => $value) {
            if ($isFirst) {
                $isFirst = false;
            } else {
                $exp->add(',');
            }
            $paramName = '_'.++$this->_paramsCounter;
            $exp->add($column);
            $exp->add('=');
            $exp->add(':'.$paramName);
            $this->_params->set($paramName, $value);
        }
        
        return $exp;
    }

}
