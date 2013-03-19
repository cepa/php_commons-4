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

use Commons\Log\Writer\AbstractWriter;
use Commons\Log\Writer\NullWriter;

class Logger
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
     * @param int $priority
     * @return \Commons\Log\Logger
     */
    public function log($message, $priority = Log::DEBUG)
    {
        return $this->_log($message, $priority);
    }
    
    /**
     * Log emergency message.
     * @param string $message
     * @return \Commons\Log\Logger
     */
    public function emergency($message)
    {
        return $this->_log($message, Log::EMERGENCY);
    }
    
    /**
     * Log alert message.
     * @param string $message
     * @return \Commons\Log\Logger
     */
    public function alert($message)
    {
        return $this->_log($message, Log::ALERT);
    }
    
    /**
     * Log critical message.
     * @param string $message
     * @return \Commons\Log\Logger
     */
    public function critical($message)
    {
        return $this->_log($message, Log::CRITICAL);
    }
    
    /**
     * Log error message.
     * @param string $message
     * @return \Commons\Log\Logger
     */
    public function error($message)
    {
        return $this->_log($message, Log::ERROR);
    }
    
    /**
     * Log warning message.
     * @param string $message
     * @return \Commons\Log\Logger
     */
    public function warning($message)
    {
        return $this->_log($message, Log::WARNING);
    }
    
    /**
     * Log notice message.
     * @param string $message
     * @return \Commons\Log\Logger
     */
    public function notice($message)
    {
        return $this->_log($message, Log::NOTICE);
    }
    
    /**
     * Log info message.
     * @param string $message
     * @return \Commons\Log\Logger
     */
    public function info($message)
    {
        return $this->_log($message, Log::INFO);
    }
    
    /**
     * Log debug message.
     * @param string $message
     * @return \Commons\Log\Logger
     */
    public function debug($message)
    {
        return $this->_log($message, Log::DEBUG);
    }
    
    /**
     * Write raw message.
     * @param string $message
     * @param int $priority
     * @return \Commons\Log\Logger
     */
    public function write($message, $priority)
    {
        foreach ($this->getWriters() as $writer) {
            $writer->write($message, $priority);
        }
        return $this;
    }

    /**
     * Log a message.
     * @param string $message
     * @param int $priority
     * @return \Commons\Log\Logger
     */
    protected function _log($message, $priority = Log::DEBUG)
    {
    	if (is_array($message) || (is_object($message) && !method_exists($message, '__toString'))) {
    		$message = var_export($message, true);
    	}
        
    	$trace = debug_backtrace();
        $message = array(
            'priority'	=> $priority,
            'file'		=> $trace[1]['file'],
            'line'		=> $trace[1]['line'],
            'message'   => (string) $message
        );
        return $this->write($message, $priority);
    }

}
