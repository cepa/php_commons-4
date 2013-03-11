<?php

/**
 * =============================================================================
 * @file        Commons/Migration/Map.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Migration;

use Commons\Exception\NotFoundException;

class Map
{

    protected $_migrations = array();
    
    /**
     * Init.
     * @param array $migrations
     */
    public function __construct(array $migrations = array())
    {
        $this->setMigrations($migrations);
    }
    
    /**
     * Set migrations.
     * @param int $version
     * @param string $className
     * @return \Commons\Migration\Map
     */
    public function setMigration($version, $className)
    {
        $this->_migrations[$version] = $className;
        return $this;
    }
    
    /**
     * Has migration.
     * @param int $version
     * @return boolean
     */
    public function hasMigration($version)
    {
        return isset($this->_migrations[$version]);
    }
    
    /**
     * Get migration.
     * @param int $version
     * @throws NotFoundException
     * @return string
     */
    public function getMigration($version)
    {
        if (!$this->hasMigration($version)) {
            throw new NotFoundException();
        }
        return $this->_migrations[$version];
    }
    
    /**
     * Remove migration.
     * @param int $version
     * @return \Commons\Migration\Map
     */
    public function removeMigration($version)
    {
        unset($this->_migrations[$version]);
        return $this;
    }
    
    /**
     * Set migrations.
     * @param array $migrations
     * @return \Commons\Migration\Map
     */
    public function setMigrations(array $migrations)
    {
        foreach ($migrations as $version => $className) {
            $this->setMigration($version, $className);
        }
        return $this;
    }
    
    /**
     * Get migrations.
     * @return array
     */
    public function getMigrations()
    {
        return $this->_migrations;
    }
    
    /**
     * Clear migrations.
     * @return \Commons\Migration\Map
     */
    public function clearMigrations()
    {
        $this->_migrations = array();
        return $this;
    }
    
}
