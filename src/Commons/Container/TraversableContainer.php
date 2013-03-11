<?php

/**
 * =============================================================================
 * @file        Commons/Container/TraversableContainer.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Container;

use Commons\Exception\NotFoundException;
use Commons\Exception\InvalidArgumentException;

class TraversableContainer implements \ArrayAccess, \Countable, \IteratorAggregate
{
    
    protected $_name;
    protected $_data;
    protected $_counter;
    protected $_lookup;
    
    /**
     * Init traversable.
     * @param string $name
     */
    public function __construct($name = null)
    {
        $this->clear();
        $this->_name = $name;
    }
    
    /**
     * Reset.
     * @return Commons\Container\TraversableContainer
     */
    public function clear()
    {
        $this->_name = null;
        $this->_data = null;
        $this->_counter = 0;
        $this->_lookup = array();
        return $this;
    }
    
    /**
     * Merge with another tree.
     * @param Commons\Container\TraversableContainer $source
     * @return Commons\Container\TraversableContainer
     */
    public function merge(TraversableContainer $source)
    {
        $className = get_class($this);
        $this->_name = $source->_name;
        if (is_array($source->_data)) {
            if (!is_array($this->_data)) {
                $this->_data = array();
            }
            foreach ($source->_data as $obj) {
                $child = new $className();
                $child->merge($obj);
                $this->addChild($child);
            }
        } else if (is_object($source->_data)) {
            $this->_data = clone $source->_data;
        } else if (trim($source->_data) != '') {
            $this->_data = $source->_data;
        }
        return $this;
    }
    
    /**
     * Alter with another tree.
     * @param Commons\Container\TraversableContainer $source
     * @return Commons\Container\TraversableContainer
     */
    public function alter(TraversableContainer $source)
    {
        $className = get_class($this);
        $this->_name = $source->_name;
        if (is_array($source->_data)) {
            if (!is_array($this->_data)) {
                $this->_data = array();
            }
            foreach ($source->_data as $obj) {
                if ($this->hasChild($obj->getName())) {
                    $child = $this->getChild($obj->getName());
                } else {
                    $child = new $className();
                }
                $child->alter($obj);
                $this->addChild($child);
            }
        } else if (is_object($source->_data)) {
            $this->_data = clone $source->_data;
        } else if (trim($source->_data) != '') {
            $this->_data = $source->_data;
        }
        return $this;
    }
    
    /**
     * Copy from another traversable.
     * @param Commons\Container\TraversableContainer $source
     * @return Commons\Container\TraversableContainer
     */
    public function copy(TraversableContainer $source)
    {
        return $this
            ->clear()
            ->merge($source);
    }
    
    /**
     * Set name.
     * @param string $name
     * @return Commons\Container\TraversableContainer
     */
    public function setName($name)
    {
        $this->_name = $name;
        return $this;
    }
    
    /**
     * Get name.
     * @return string|null
     */
    public function getName()
    {
        return (string) $this->_name;
    }
    
    /**
     * Set data.
     * @param string|array $data
     * @return Commons\Container\TraversableContainer
     */
    public function setData($data)
    {
        $this->_data = $data;
        return $this;
    }
    
    /**
     * Get data.
     * @return string|array
     */
    public function getData()
    {
        return $this->_data;
    }
    
    /**
     * Set child or add next child.
     * @param Commons\Container\TraversableContainer $child
     * @return Commons\Container\TraversableContainer
     */
    public function addChild(TraversableContainer $child)
    {
        $this->_convertDataToArray();
        if (!$this->hasChild($child->getName())) {
            $this->_lookup[$child->getName()] = $this->_counter;
        }
        $this->_data[$this->_counter] = $child;
        $this->_counter++;
        return $this;
    }
    
    /**
     * Set child.
     * @param Commons\Container\TraversableContainer $child
     * @return Commons\Container\TraversableContainer
     */
    public function setChild(TraversableContainer $child)
    {
        $this->_convertDataToArray();
        if (!$this->hasChild($child->getName())) {
            $this->_lookup[$child->getName()] = $this->_counter;
            $this->_counter++;
        }
        $this->_data[$this->_lookup[$child->getName()]] = $child;
        return $this;
    }
    
    /**
     * Has child.
     * @param string $childName
     * @return boolean
     */
    public function hasChild($childName)
    {
        if (is_int($childName)) {
            return isset($this->_data[$childName]);
        }
        return isset($this->_lookup[$childName]);
    }
    
    /**
     * Get child.
     * @param string $childName
     * @throws Commons\Exception\NotFoundException
     * @return Commons\Container\TraversableContainer
     */
    public function getChild($childName)
    {
        if (!$this->hasChild($childName)) {
            $this->setChild($this->_createNewChild($childName));
        }
        if (is_int($childName)) {
            return $this->_data[$childName];
        }
        return $this->_data[$this->_lookup[$childName]];
    }
    
    /**
     * Remove child.
     * @param string $childName
     * @return Commons\Container\TraversableContainer
     */
    public function removeChild($childName)
    {
        if ($this->hasChild($childName)) {
            unset($this->_data[$this->_lookup[$childName]]);
            unset($this->_lookup[$childName]);
        }
        return $this;
    }
    
    /**
     * Set child.
     * @param string $childName
     * @param Commons\Container\TraversableContainer $child
     */
    public function __set($childName, $child)
    {
        if ($child instanceof TraversableContainer) {
            if ($child->getName() != $childName) {
                $child->setName($childName);
            }
        } else {
            $data = $child;
            $child = $this->_createNewChild();
            $child
                ->setName($childName)
                ->setData($data);
        }
        $this->setChild($child);
    }
    
    /**
     * Get child.
     * @param string $childName
     * @return Commons\Container\TraversableContainer
     */
    public function __get($childName)
    {
        return $this->getChild($childName);
    }
    
    /**
     * Has child.
     * @param string $childName
     * @return boolean
     */
    public function __isset($childName)
    {
        return $this->hasChild($childName);
    }
    
    /**
     * Remove child.
     * @param string $childName
     */
    public function __unset($childName)
    {
        $this->removeChild($childName);
    }
    
    /**
     * Countable
     * @return number
     */
    public function count()
    {
        if (is_array($this->_data)) {
            return count($this->_data);
        }
        return 0;
    }
    
    /**
     * ArrayAccess
     * @param string $childName
     * @param Commons\Container\TraversableContainer $child
     */
    public function offsetSet($childName, $child)
    {
        $this->__set($childName, $child);
    }
    
    /**
     * ArrayAccess
     * @param string $childName
     * @return Commons\Container\TraversableContainer
     */
    public function offsetGet($childName)
    {
        return $this->__get($childName);
    }
    
    /**
     * ArrayAccess
     * @param string $childName
     * @return boolean
     */
    public function offsetExists($childName)
    {
        return $this->__isset($childName);    
    }
    
    /**
     * ArrayAssocContainer
     * @param unknown_type $childName
     */
    public function offsetUnset($childName)
    {
        $this->__unset($childName);
    }
    
    /**
     * Convert to string.
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getData();
    }
    
    /**
     * IteratorAggregate
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->_data);
    }
    
    /**
     * Convert data to array.
     */
    protected function _convertDataToArray()
    {
        if (!is_array($this->_data)) {
            $this->_data = array();
        }
    }
    
    protected function _createNewChild($name = null)
    {
        return new TraversableContainer($name);
    }
    
}
