<?php

/**
 * =============================================================================
 * @file       Commons/Container/SetContainer.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Container;

class SetContainer extends CollectionContainer
{

    /**
     * Add an element to the set.
     * @param mixed $element
     * @return SetContainer
     */
    public function add($element)
    {
        $this->_collection[] = $element;
        return $this;
    }    
    
    /**
     * Set an element in the set.
     * @param int $index
     * @param mixed $element
     * @return SetContainer
     */
    public function set($index, $element)
    {
        if (is_null($index)) {
            return $this->add($element);
        }
        return parent::set((int) $index, $element);
    }
    
    /**
     * Get an element from the set.
     * @param int $index
     * @throws Exception
     * @return mixed
     */
    public function get($index)
    {
        if (!parent::has((int) $index)) {
            throw new Exception("Index $index has not been found!");
        }
        return parent::get((int) $index);
    }
    
    /**
     * Check if the set has an element.
     * @param int $index
     * @return boolean
     */
    public function has($index)
    {
        return parent::has((int) $index);
    }
    
    /**
     * Remove an element from the set.
     * @param int $index
     * @return SetContainer
     */
    public function remove($index)
    {
        return parent::remove((int) $index);
    }
    
}
