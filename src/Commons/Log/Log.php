<?php

/**
 * =============================================================================
 * @file        Commons/Log/Log.php
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

class Log
{
    
    const EMERGENCY    = LOG_EMERG;
    const ALERT        = LOG_ALERT;
    const CRITICAL     = LOG_CRIT;
    const ERROR        = LOG_ERR;
    const WARNING      = LOG_WARNING;
    const NOTICE       = LOG_NOTICE;
    const INFO         = LOG_INFO;
    const DEBUG        = LOG_DEBUG;
    
    protected static $_logger;
    
    protected function __construct() {}
    
    /**
     * Set logger.
     * @param Logger $logger
     */
    public static function setLogger(Logger $logger)
    {
        self::$_logger = $logger;
    }
    
    /**
     * Get logger.
     * @return Logger
     */
    public static function getLogger()
    {
        if (!isset(self::$_logger)) {
            $logger = new Logger();
            $logger->addWriter(new NullWriter());
            self::setLogger($logger);
        }
        return self::$_logger;
    }
    
    /**
     * Log message.
     * @param string $message
     * @param int $priority
     */
    public static function log($message, $priority = self::DEBUG)
    {
        self::_log($message, $priority);
    }

    /**
     * Log emergency message.
     * @param string $message
     */
    public static function emergency($message)
    {
        self::_log($message, self::EMERGENCY);
    }
    
    /**
     * Log alert message.
     * @param string $message
     */
    public static function alert($message)
    {
        self::_log($message, self::ALERT);
    }
    
    /**
     * Log critical message.
     * @param string $message
     */
    public static function critical($message)
    {
        self::_log($message, self::CRITICAL);
    }
    
    /**
     * Log error message.
     * @param string $message
     */
    public static function error($message)
    {
        self::_log($message, self::ERROR);
    }
    
    /**
     * Log warning message.
     * @param string $message
     */
    public static function warning($message)
    {
        self::_log($message, self::WARNING);
    }
    
    /**
     * Log notice message.
     * @param string $message
     */
    public static function notice($message)
    {
        self::_log($message, self::NOTICE);
    }
    
    /**
     * Log info message.
     * @param string $message
     */
    public static function info($message)
    {
        self::_log($message, self::INFO);
    }
    
    /**
     * Log debug message.
     * @param string $message
     */
    public static function debug($message)
    {
        self::_log($message, self::DEBUG);
    }
    
    /**
     * Log a message.
     * @param string $message
     */
    protected static function _log($message, $priority)
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
        
        self::getLogger()->write($message, $priority);
    }

}
