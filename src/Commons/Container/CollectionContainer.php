<?php

/**
 * =============================================================================
 * @file       Commons/Container/CollectionContainer.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Container;

class CollectionContainer implements \ArrayAccess, \Countable, \Serializable, \IteratorAggregate
{
    
    protected $_collection = array();
    
    /**
     * Prepare collection.
     * @param array|object $collection
     */
    public function __construct($collection = null)
    {
        if (isset($collection)) {
            $this->populate($collection);
        }
    }
    
    /**
     * Set collection element.
     * @param mixed $name
     * @param mixed $value
     * @return CollectionContainer
     */
    public function set($name, $value)
    {
        $this->_collection[$name] = $value;
        return $this;
    }
    
    /**
     * Get collection element.
     * @param mixed $name
     * @return mixed:
     */
    public function get($name)
    {
        if (!isset($this->_collection[$name])) {
            return null;
        }
        return $this->_collection[$name];
    }
    
    /**
     * Check if collection has an element.
     * @param mixed $name
     * @return boolean
     */
    public function has($name)
    {
        return isset($this->_collection[$name]);
    }
    
    /**
     * Remove an element from the collection.
     * @param mixed $name
     * @return CollectionContainer
     */
    public function remove($name)
    {
        unset($this->_collection[$name]);
        return $this;
    }
    
    /**
     * Set collection.
     * @param array|object $collection
     * @return CollectionContainer
     */
    public function setAll($collection)
    {
        return $this->populate($collection);
    }
    
    /**
     * Get collection.
     * @return array
     */
    public function getAll()
    {
        return $this->_collection;
    }
    
    /**
     * Alias to getAll.
     * @return array
     */
    public function toArray()
    {
        return $this->getAll();
    }
    
    /**
     * Clear collection.
     * @return CollectionContainer
     */
    public function clearAll()
    {
        $this->_collection = array();
        return $this;
    }
    
    /**
     * Alias.
     * @return CollectionContainer
     */
    public function clear()
    {
        return $this->clearAll();
    }

    /**
     * Convert collection to single string.
     * @return string
     */
    public function __toString()
    {
        return var_export($this->_collection, true);
    }
    
    /**
     * ArrayAccess
     * @param mixed $offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }
    
    /**
     * ArrayAccess
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }
    
    /**
     * ArrayAccess
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }
    
    /**
     * ArrayAccess
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }
    
    /**
     * Countable
     * @return int
     */
    public function count()
    {
        return count($this->_collection);
    }

    /**
     * Serializable
     * @return string
     */
    public function serialize()
    {
        return serialize($this->_collection);
    }
    
    /**
     * Serializable
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $this->_collection = unserialize($serialized);
    }
    
    /**
     * IteratorAggregate
     * @return CollectionContainer
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->_collection);
    }

    /**
     * Populate.
     * @param array|object $collection
     * @return CollectionContainer
     */
    public function populate($collection)
    {
        $this->_collection = array();
        if (is_object($collection)) {
            if ($collection instanceof \IteratorAggregate) {
                $items = $collection;
            } else if (method_exists($collection, 'toArray')) {
                $items = $collection->toArray();
            } else {
                throw new Exception("Invalid collection parameter");
            }
        } else if (is_array($collection)) {
            $items = $collection;
        } else {
            throw new Exception("Invalid collection parameter");
        }
        foreach ($items as $name => $value) {
            $this->set($name, $value);
        }
        return $this;
        
    }

}
