<?php

/**
 * =============================================================================
 * @file       Commons/Log/Writer/SyslogWriter.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Log\Writer;

class SyslogWriter extends AbstractWriter
{
    
    /**
     * Open syslog.
     */
    public function __construct($name = 'commons')
    {
        parent::__construct();
        openlog($name, null, LOG_PERROR | LOG_SYSLOG);
    }
    
    /**
     * Close syslog.
     */
    public function __destruct()
    {
        closelog();
    }
    
    /**
     * Log a message to syslog.
     * @see Commons\Log\Writer\AbstractWriter::_write()
     */
    public function _write($message, $priority)
    {
        syslog($priority, $message);
    }
    
}
