<?php

/**
 * =============================================================================
 * @file        Commons/Sql/QueryExpression.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Sql;

class QueryExpression
{

    protected $_statements = array();

    /**
     * Add a statement.
     * @param string $sql
     * @return QueryExpression
     */
    public function add($sql)
    {
        $this->_statements[] = trim((string) $sql);
        return $this;
    }

    /**
     * Clear expression.
     * @return QueryExpression
     */
    public function clear()
    {
        $this->_statements = array();
        return $this;
    }

    /**
     * Reset expression, set one element.
     * @param string $sql
     * @return QueryExpression
     */
    public function set($sql)
    {
        return $this
            ->clear()
            ->add($sql);
    }

    /**
     * Get one expression or all of them.
     * @param int|null $index
     * @return array|string
     */
    public function get($index = null)
    {
        if (isset($index)) {
            if (isset($this->_statements[$index])) {
                return $this->_statements[$index];
            }
            return null;
        }
        return $this->_statements;
    }

    /**
     * Check is a statement is empty.
     * @return boolean
     */
    public function isEmpty()
    {
        return (count($this->_statements) == 0 ? true : false);
    }

    /**
     * Convert expression to SQL string.
     * @return string
     */
    public function toSql()
    {
        $sql = trim(implode(' ', $this->_statements));
        return (empty($sql) ? '' : $sql.' ');
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toSql();
    }

}
