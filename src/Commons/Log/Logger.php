<?php

/**
 * =============================================================================
 * @file        Commons/Log/Logger.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Log;

use Psr\Log\LoggerInterface;
use Commons\Log\Writer\AbstractWriter;
use Commons\Log\Writer\NullWriter;

class Logger implements LoggerInterface
{
    /** @var AbstractWriter[] */
    protected $_writers = array();
    
    /**
     * Add writer.
     * @param AbstractWriter $writer
     * @return \Commons\Log\Logger
     */
    public function addWriter(AbstractWriter $writer)
    {
        $this->_writers[] = $writer;
        return $this;
    }
    
    /**
     * Add writers.
     * @param array $writers
     * @return \Commons\Log\Logger
     */
    public function addWriters(array $writers)
    {
        foreach ($writers as $writer) {
            $this->addWriter($writer);
        }
        return $this;
    }
    
    /**
     * Get writers.
     * @return AbstractWriter[]
     */
    public function getWriters()
    {
        return $this->_writers;
    }
    
    /**
     * Clear writers.
     * @return \Commons\Log\Logger
     */
    public function clearWriters()
    {
        $this->_writers = array();
        return $this;
    }

    /**
     * Log message.
     * @param string $message
     * @param int $level
     * @return \Commons\Log\Logger
     */
    public function log($level, $message, array $context = array())
    {
        return $this->_log($level, $message);
    }
    
    /**
     * Log emergency message.
     * @param string $message
     * @return \Commons\Log\Logger
     */
    public function emergency($message, array $context = array())
    {
        return $this->_log(Log::EMERGENCY, $message);
    }
    
    /**
     * Log alert message.
     * @param string $message
     * @return \Commons\Log\Logger
     */
    public function alert($message, array $context = array())
    {
        return $this->_log(Log::ALERT, $message);
    }
    
    /**
     * Log critical message.
     * @param string $message
     * @return \Commons\Log\Logger
     */
    public function critical($message, array $context = array())
    {
        return $this->_log(Log::CRITICAL, $message);
    }
    
    /**
     * Log error message.
     * @param string $message
     * @return \Commons\Log\Logger
     */
    public function error($message, array $context = array())
    {
        return $this->_log(Log::ERROR, $message);
    }
    
    /**
     * Log warning message.
     * @param string $message
     * @return \Commons\Log\Logger
     */
    public function warning($message, array $context = array())
    {
        return $this->_log(Log::WARNING, $message);
    }
    
    /**
     * Log notice message.
     * @param string $message
     * @return \Commons\Log\Logger
     */
    public function notice($message, array $context = array())
    {
        return $this->_log(Log::NOTICE, $message);
    }
    
    /**
     * Log info message.
     * @param string $message
     * @return \Commons\Log\Logger
     */
    public function info($message, array $context = array())
    {
        return $this->_log(Log::INFO, $message);
    }
    
    /**
     * Log debug message.
     * @param string $message
     * @return \Commons\Log\Logger
     */
    public function debug($message, array $context = array())
    {
        return $this->_log(Log::DEBUG, $message);
    }
    
    /**
     * Write raw message.
     * @param string $message
     * @param int $level
     * @return \Commons\Log\Logger
     */
    public function write($message, $level)
    {
        foreach ($this->getWriters() as $writer) {
            $writer->write($message, $level);
        }
        return $this;
    }

    /**
     * Log a message.
     * @param string $message
     * @param int $level
     * @return \Commons\Log\Logger
     */
    protected function _log($level, $message)
    {
    	if (is_array($message) || (is_object($message) && !method_exists($message, '__toString'))) {
    		$message = var_export($message, true);
    	}
        
    	$trace = debug_backtrace();
        $message = array(
            'priority'	=> $level,
            'file'		=> $trace[1]['file'],
            'line'		=> $trace[1]['line'],
            'message'   => (string) $message
        );
        return $this->write($message, $level);
    }

}
