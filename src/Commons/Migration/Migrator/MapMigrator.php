<?php

/**
 * =============================================================================
 * @file       Commons/Migration/Migrator/MapMigrator.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Migration\Migrator;

use Commons\Callback\Callback;
use Commons\Log\LoggerAwareInterface;
use Commons\Migration\Exception;
use Commons\Migration\Map;
use Commons\Migration\MigrationInterface;
use Commons\Migration\Versioner\VersionerInterface;

class MapMigrator implements MigratorInterface
{
    
    protected $_maps = array();
    protected $_versioner;
    protected $_upgradeMax = null;
    protected $_downgradeMin = 0;
    protected $_factory;
    
    /**
     * Init.
     * @param array $maps
     */
    public function __construct(array $maps = array())
    {
        $this->setMaps($maps);
    }
    
    /**
     * Set map.
     * @param string $name
     * @param Map $map
     * @return \Commons\Migration\Migrator\MigratorInterface
     */
    public function setMap($name, Map $map)
    {
        $this->_maps[$name] = $map;
        return $this;
    }
    
    /**
     * Has map.
     * @param string $name
     * @return boolean
     */
    public function hasMap($name)
    {
        return isset($this->_maps[$name]);
    }
    
    /**
     * Get map.
     * @param string $name
     * @return array
     */
    public function getMap($name)
    {
        if (!$this->hasMap($name)) {
            $this->setMap($name, new Map());
        }
        return $this->_maps[$name];
    }
    
    /**
     * Remove map.
     * @param string $name
     * @return \Commons\Migration\Migrator\MigratorInterface
     */
    public function removeMap($name)
    {
        unset($this->_maps[$name]);
        return $this;
    }
    
    /**
     * Set maps.
     * @param array $maps
     * @return \Commons\Migration\Migrator\MigratorInterface
     */
    public function setMaps(array $maps)
    {
        foreach ($maps as $name => $map) {
            $this->setMap($name, $map);
        }
        return $this;
    }
    
    /**
     * Get maps.
     * @return array
     */
    public function getMaps()
    {
        return $this->_maps;
    }
    
    /**
     * Clear maps.
     * @return \Commons\Migration\Migrator\MigratorInterface
     */
    public function clearMaps()
    {
        $this->_maps = array();
        return $this;
    }
    
    /**
     * Set versioner.
     * @param VersionerInterface $versioner
     * @return \Commons\Migration\Migrator\MigratorInterface
     */
    public function setVersioner(VersionerInterface $versioner)
    {
        $this->_versioner = $versioner;
        return $this;
    }
    
    /**
     * Get versioner.
     * @throws Exception
     * @return VersionerInterface
     */
    public function getVersioner()
    {
        if (!isset($this->_versioner)) {
            throw new Exception("Please set versioner object first");
        }
        return $this->_versioner;
    }
    
    /**
     * Set upgrade max.
     * @param int $max
     * @return \Commons\Migration\Migrator\MapMigrator
     */
    public function setUpgradeMax($max)
    {
        $this->_upgradeMax = $max;
        return $this;
    }
    
    /**
     * Get upgrade max.
     * @return int
     */
    public function getUpgradeMax()
    {
        return $this->_upgradeMax;
    }
    
    /**
     * Set downgrade min.
     * @param int $min
     * @return \Commons\Migration\Migrator\MapMigrator
     */
    public function setDowngradeMin($min)
    {
        $this->_downgradeMin = $min;
        return $this;
    }
    
    /**
     * Get downgrade min.
     * @return int
     */
    public function getDowngradeMin()
    {
        return $this->_downgradeMin;
    }
    
    /**
     * Set factory.
     * @param callable|\Commons\Callback\Callback $callable
     * @return \Commons\Migration\Migrator\MapMigrator
     */
    public function setFactory($callable)
    {
        if (!($callable instanceof Callback)) {
            $callable = new Callback($callable);
        }
        $this->_factory = $callable;
        return $this;
    }
    
    /**
     * Get factory.
     * @throws Exception
     * @return callable|\Commons\Callback\Callback
     */
    public function getFactory()
    {
        if (!isset($this->_factory)) {
            $this->setFactory(function($className){
                if (!class_exists($className, true)) {
                    throw new Exception("Cannot load migration class '{$className}'");
                }
                return new $className();
            });
        }
        return $this->_factory;
    }
    
    /**
     * Upgrade.
     * @return \Commons\Migration\Migrator\MigratorInterface
     */
    public function upgrade()
    {
        $versioner = $this->getVersioner();
        foreach ($this->getMaps() as $name => $map) {
            $migrations = $map->getMigrations();
            ksort($migrations);
            $current = $versioner->getVersion($name);
            foreach ($migrations as $version => $className) {
                if ($this->getUpgradeMax() && $version > $this->getUpgradeMax()) break;
                if ($current < $version) {
                    if ($this instanceof LoggerAwareInterface) {
                        $this->getLogger()->debug("Upgrade {$name} from {$current} to {$version} ({$className})");
                    }
                    $this->_createMigrationInstance($className)->upgrade();
                    $current = $version;
                    $versioner->setVersion($name, $current);
                }
            }
        }
        return $this;
    }
    
    /**
     * Downgrade.
     * @return \Commons\Migration\Migrator\MigratorInterface
     */
    public function downgrade()
    {
        $versioner = $this->getVersioner();
        foreach ($this->getMaps() as $name => $map) {
            $migrations = $map->getMigrations();
            krsort($migrations);
            $current = $versioner->getVersion($name);
            foreach ($migrations as $version => $className) {
                if ($version <= $this->getDowngradeMin()) break;
                if ($current >= $version) {
                    if ($this instanceof LoggerAwareInterface) {
                        $this->getLogger()->debug("Downgrade {$name} from {$current} to ".($version-1)." ({$className})");
                    }
                    $this->_createMigrationInstance($className)->downgrade();
                    $current = $version - 1;
                    $versioner->setVersion($name, $current);
                }                
            }
            if ($this->getDowngradeMin() == 0) {
                $versioner->setVersion($name, 0);
            }
        }
        return $this;
    }
    
    /**
     * Create instance of a migration object.
     * @param string $className
     * @throws Exception
     * @return \Commons\Migration\MigrationInterface
     */
    protected function _createMigrationInstance($className)
    {
        $migration = $this->getFactory()->call($className);
        if (!($migration instanceof MigrationInterface)) {
            throw new Exception("Invalid migration class '{$className}'");
        }
        return $migration;
    }
    
}
