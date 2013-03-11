<?php

/**
 * =============================================================================
 * @file        Commons/Container/SetContainer.php
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

class SetContainer extends CollectionContainer
{

    /**
     * Add an element to the set.
     * @param mixed $element
     * @return Commons\Container\Set
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
     * @return Commons\Container\Set
     */
    public function set($index, $element)
    {
        return parent::set((int) $index, $element);
    }
    
    /**
     * Get an element from the set.
     * @param int $index
     * @throws Commons\Exception\NotFoundException
     * @return mixed
     */
    public function get($index)
    {
        if (!parent::has((int) $index)) {
            throw new NotFoundException("Index $index has not been found!");
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
     * @return Commons\Container\Set
     */
    public function remove($index)
    {
        return parent::remove((int) $index);
    }
    
}
