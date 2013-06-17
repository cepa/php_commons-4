<?php

/**
 * =============================================================================
 * @file       Commons/Container/AssocContainer.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Container;

class AssocContainer extends CollectionContainer
{

    /**
     * Set assoc element.
     * @param string $name
     * @param mixed $value
     * @return AssocContainer
     */
    public function set($name, $value)
    {
        return parent::set((string) $name, $value);
    }

    /**
     * Get assoc element.
     * @param string $name
     * @return mixed
     */
    public function get($name)
    {
        return parent::get((string) $name);
    }

    /**
     * Check if a assoc element exists.
     * @param string $name
     * @return boolean
     */
    public function has($name)
    {
        return parent::has((string) $name);
    }

    /**
     * Remove assoc element.
     * @param string $name
     */
    public function remove($name)
    {
        return parent::remove((string) $name);
    }

    /**
     * Set property.
     * @param string $name
     * @param mixed $value
     * @return AssocContainer
     */
    public function __set($name, $value)
    {
        return $this->set($name, $value);
    }

    /**
     * Get property.
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * Check if property exists.
     * @param string $name
     * @return boolean
     */
    public function __isset($name)
    {
        return $this->has($name);
    }

    /**
     * Remove property.
     * @param string $name
     */
    public function __unset($name)
    {
        $this->remove($name);
    }

}
