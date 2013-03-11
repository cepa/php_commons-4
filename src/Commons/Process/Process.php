<?php

/**
 * =============================================================================
 * @file        Commons/Process/Process.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Process;

class Process
{

    protected $_command = null;
    protected $_stdin = null;
    protected $_stdout = null;
    protected $_stderr = null;
    protected $_cwd = null;
    protected $_env = array();
    protected $_exitCode = null;
    protected $_params = array();

    /**
     * Constructor
     * @param string $command
     */
    public function __construct($command = null, $cwd = './')
    {
        $this->_command = $command;
        $this->_cwd = realpath($cwd);
    }

    /**
     * Set command.
     * @param string $command
     * @return Commons\Process\Process
     */
    public function setCommand($command)
    {
        $this->_command = $command;
        return $this;
    }

    /**
     * Get command.
     * @return string
     */
    public function getCommand()
    {
        return $this->_command;
    }

    /**
     * Set STDIN value.
     * @param string $stdin
     * @return Commons\Process\Process
     */
    public function setStdin($stdin)
    {
        $this->_stdin = (string) $stdin;
        return $this;
    }

    /**
     * Get STDIN value.
     * @return string
     */
    public function getStdin()
    {
        return $this->_stdin;
    }

    /**
     * Get STDOUT value.
     * @return string
     */
    public function getStdout()
    {
        return $this->_stdout;
    }

    /**
     * Get STDERR value.
     * @return string
     */
    public function getStderr()
    {
        return $this->_stderr;
    }

    /**
     * Set current working directory.
     * @param string $cwd
     * @return Commons\Process\Process
     */
    public function setCwd($cwd)
    {
        $this->_cwd = $cwd;
        return $this;
    }

    /**
     * Get current working directory.
     * @return string
     */
    public function getCwd()
    {
        return $this->_cwd;
    }

    /**
     * Set environment variables.
     * @param array $env
     * @return Commons\Process\Process
     */
    public function setEnv(array $env)
    {
        $this->_env = $env;
        return $this;
    }

    /**
     * Get environment variables.
     * @return array
     */
    public function getEnv()
    {
        return $this->_env;
    }

    /**
     * Get an exit code.
     * @return int
     */
    public function getExitCode()
    {
        return $this->_exitCode;
    }

    /**
     * Set parameters.
     * @param array $params
     * @return Commons\Process\Process
     */
    public function setParams(array $params)
    {
        $this->_params = $params;
        return $this;
    }

    /**
     * Get parameters.
     * @return array
     */
    public function getParams()
    {
        return $this->_params;
    }

    /**
     * Clear parameters.
     * @return Commons\Process\Process
     */
    public function clearParams()
    {
        $this->_params = array();
        return $this;
    }

    /**
     * Add a single parameter.
     * @param string $param
     * @return Commons\Process\Process
     */
    public function addParam($param)
    {
        $this->_params[] = $param;
        return $this;
    }

    /**
     * Convert to full command with parameters list.
     * @return string
     */
    public function getFullCommand()
    {
        return $this->_command.' '.implode(' ', $this->_params);
    }


    /**
     * Execute a process.
     * Returns an error code from a process.
     * @throws Commons\Process\Exception
     * @return int
     */
    public function run()
    {
        $desc = array(
        0 => array('pipe', 'r'),
        1 => array('pipe', 'w'),
        2 => array('pipe', 'w')
        );

        $pipes = array();
        $process = proc_open(
        $this->getFullCommand(),
        $desc,
        $pipes,
        $this->_cwd,
        $this->_env);
        if (!is_resource($process)) {
            throw new Exception("proc_open failed!");
        }
         
        if (!empty($this->_stdin)) {
            fwrite($pipes[0], $this->_stdin);
            fclose($pipes[0]);
        }

        $this->_stdout = stream_get_contents($pipes[1]);
        $this->_stderr = stream_get_contents($pipes[2]);

        fclose($pipes[1]);
        fclose($pipes[2]);

        $this->_exitCode = proc_close($process);
        return $this->_exitCode;
    }
    
    /**
     * Quicker way to execute an external process.
     * @param string $command
     * @param array $params
     * @throws Commons\Process\Exception
     * @return string
     */
    public static function execute($command, array $params = array()) 
    {
        $proc = new Process($command);
        $proc->setParams($params);
        if ($proc->run() != 0) {
            throw new Exception($command." failed: ".$proc->getStderr());
        }
        return $proc->getStdout();
    }

}
