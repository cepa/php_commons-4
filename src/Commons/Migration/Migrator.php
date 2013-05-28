<?php

/**
 * =============================================================================
 * @file        Commons/Migration/Migrator.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Migration;

use Commons\Autoloader\DefaultAutoloader;
use Commons\Autoloader\Exception as AutoloaderException;
use Commons\Migration\Versioner\VersionerInterface;
use Commons\Log\Log;
use Commons\Log\Logger;

class Migrator
{
    
    protected $_maps = array();
    protected $_versioner;
    protected $_logger;
    
    /**
     * Init.
     * @param array $maps
     */
    public function __construct(array $maps = array())
    {
        $this->setMaps($maps);
    }
    
    /**
     * Set logger.
     * @param Logger $logger
     * @return \Commons\Migration\Migrator
     */
    public function setLogger(Logger $logger)
    {
        $this->_logger = $logger;
        return $this;
    }
    
    /**
     * 
     * @return Logger
     */
    public function getLogger()
    {
        if (!isset($this->_logger)) {
            $this->setLogger(Log::getLogger());
        }
        return $this->_logger;
    }
    
    /**
     * Set map.
     * @param string $name
     * @param Map $map
     * @return \Commons\Migration\Migrator
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
     * @return \Commons\Migration\Migrator
     */
    public function removeMap($name)
    {
        unset($this->_maps[$name]);
        return $this;
    }
    
    /**
     * Set maps.
     * @param array $maps
     * @return \Commons\Migration\Migrator
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
     * @return \Commons\Migration\Migrator
     */
    public function clearMaps()
    {
        $this->_maps = array();
        return $this;
    }
    
    /**
     * Set versioner.
     * @param VersionerInterface $versioner
     * @return \Commons\Migration\Migrator
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
     * Upgrade.
     * @return \Commons\Migration\Migrator
     */
    public function upgrade($max = null)
    {
        $versioner = $this->getVersioner();
        foreach ($this->getMaps() as $name => $map) {
            $migrations = $map->getMigrations();
            ksort($migrations);
            $current = $versioner->getVersion($name);
            foreach ($migrations as $version => $className) {
                if (isset($max) && $version > $max) break;
                if ($current < $version) {
                    $this->getLogger()->debug("Upgrade {$name} from {$current} to {$version} ({$className})");
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
     * @return \Commons\Migration\Migrator
     */
    public function downgrade($min = 0)
    {
        $versioner = $this->getVersioner();
        foreach ($this->getMaps() as $name => $map) {
            $migrations = $map->getMigrations();
            krsort($migrations);
            $current = $versioner->getVersion($name);
            foreach ($migrations as $version => $className) {
                if ($version <= $min) break;
                if ($current >= $version) {
                    $this->getLogger()->debug("Downgrade {$name} from {$current} to ".($version-1)." ({$className})");
                    $this->_createMigrationInstance($className)->downgrade();
                    $current = $version - 1;
                    $versioner->setVersion($name, $current);
                }                
            }
            if ($min == 0) {
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
        if (!class_exists($className, true)) {
            throw new Exception("Cannot load migration class '{$className}'");
        }
        $migration = new $className;
        if (!($migration instanceof MigrationInterface)) {
            throw new Exception("Invalid migration claSS '{$className}'");
        }
        return $migration;
    }
    
}
