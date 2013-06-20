<?php

/**
 * =============================================================================
 * @file       Commons/FileSystem/FileLocator.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\FileSystem;

class FileLocator
{
    
    protected $_locations = array();
    
    /**
     * Add location.
     * @param string $location
     * @return \Commons\FileSystem\FileLocator
     */
    public function addLocation($location)
    {
        $this->_locations[$location] = $location;
        return $this;
    }
    
    /**
     * Has location?
     * @param string $location
     * @return boolean
     */
    public function hasLocation($location)
    {
        return isset($this->_locations[$location]);
    }
    
    /**
     * Remove location.
     * @param string $location
     * @return \Commons\FileSystem\FileLocator
     */
    public function removeLocation($location)
    {
        unset($this->_locations[$location]);
        return $this;
    }
    
    /**
     * Get locations.
     * @return array<string, string>
     */
    public function getLocations()
    {
        return $this->_locations;
    }
    
    /**
     * Set locations.
     * @param array<string> $locations
     * @return \Commons\FileSystem\FileLocator
     */
    public function setLocations(array $locations)
    {
        $this->_locations = array();
        foreach ($locations as $location) {
            $this->addLocation($location);
        }
        return $this;
    }
    
    /**
     * Locate file.
     * @param string $filename
     * @return string|boolean
     */
    public function locate($filename)
    {
        foreach ($this->getLocations() as $location) {
            $p = $location.'/'.$filename;
            if (file_exists($p)) {
                return $p; 
            }
        }
        return false;
    }
    
}
