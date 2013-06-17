<?php

/**
 * =============================================================================
 * @file       Commons/Log/Formatter/DefaultFormatter.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Log\Formatter;

class DefaultFormatter implements FormatterInterface
{
    
    protected static $_priorityMessages = array(
        LOG_EMERG   => 'EMERG',
        LOG_ALERT   => 'ALERT',
        LOG_CRIT    => 'CRIT',
        LOG_ERR     => 'ERR',
        LOG_WARNING => 'WARNING',
        LOG_NOTICE  => 'NOTICE',
        LOG_INFO    => 'INFO',
        LOG_DEBUG   => 'DEBUG'
    );
    
    protected $_dateTimeFormat = 'Y-m-d H:i:s';
    protected $_format = '%datetime%: %file%:%line%: %priority%: %message%';
    
    /**
     * Set date time formatting string.
     * @param string $dateTimeFormat
     * @return Commons\Log\Formatter\DefaultFormatter
     */
    public function setDateTimeFormat($dateTimeFormat)
    {
        $this->_dateTimeFormat = $dateTimeFormat;   
        return $this;
    }
    
    /**
     * Get date time formatting string.
     * @return string
     */
    public function getDateTimeFormat()
    {
        return $this->_dateTimeFormat;
    }
    
    /**
     * Format a message.
     * @param string $message
     * @return string
     */
    public function format($message)
    {
        $log = str_replace('%datetime%', date($this->_dateTimeFormat), $this->_format);
        
        if (is_string($message)) {
            $log = str_replace('%message%', $message, $log);
            
        } else if (is_array($message)) {
            foreach ($message as $key => $value) {
                if ($key == 'priority') {
                    $log = str_replace('%priority%', self::$_priorityMessages[$value], $log);
                } else {
                    $log = str_replace('%'.$key.'%', $value, $log);
                }
            }
            
        } else {
            throw new Exception("Invalid argument");
        }
         
        return $log;
    }
    
}
