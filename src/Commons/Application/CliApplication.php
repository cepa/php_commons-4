<?php

/**
 * =============================================================================
 * @file       Commons/Application/CliApplication.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Application;

class CliApplication extends AbstractApplication
{
    
    private $_argv = array();
    private $_argc = 0;
    
    /**
     * Init cli application.
     * Check for CLI sapi and pcntl module.
     * @param array $argv
     * @throws MissingDependencyException
     */
    public function __construct(array $argv = array())
    {
        if (php_sapi_name() != 'cli') {
            throw new Exception("This application can only run in CLI mode.");
        }

        if (!function_exists('pcntl_signal')) {
            throw new Exception("Missing pcntl module");    
        }
        pcntl_signal(SIGTERM, array($this, 'signalHandler'));
        pcntl_signal(SIGINT, array($this, 'signalHandler'));

        $this->setArgv($argv);
    }
    
    /**
     * Set argv.
     * @param array $argv
     * @return \Commons\Light\Application\CliApplication
     */
    public function setArgv(array $argv)
    {
        $this->_argv = $argv;
        $this->_argc = count($argv);
        return $this;
    }
    
    /**
     * Get argv.
     * @param string $index
     * @return mixed
     */
    public function getArgv($index = null)
    {
        if (isset($index)) {
            return $this->_argv[$index];
        }
        return $this->_argv;
    }
    
    /**
     * Get argc.
     * @return int
     */
    public function getArgc()
    {
        return $this->_argc;
    }
    
    /**
     * Hook for signal handling.
     * @param int $signo
     */
    public function signalHandler($signo)
    {
        exit($this->shutdown($signo));
    }
    
    /**
     * Hook for shutting down the app.
     * @param int $signo
     */
    public function shutdown($signo)
    {
        
    }
    
}
