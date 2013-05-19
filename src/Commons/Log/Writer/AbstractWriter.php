<?php

/**
 * =============================================================================
 * @file        Commons/Log/Writer/AbstractWriter.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Log\Writer;

use Commons\Log\Formatter\FormatterInterface;
use Commons\Log\Formatter\DefaultFormatter;

abstract class AbstractWriter
{
    
    protected $_formatter;
    
    /**
     * Construct.
     * Set the default formatter.
     */
    public function __construct($formatter = null) 
    {
        $this->_formatter = $formatter;
    }
    
    /**
     * Set log formatter.
     * @param FormatterInterface $formatter
     * @return AbstractWriter
     */
    public function setFormatter(FormatterInterface $formatter)
    {
        $this->_formatter = $formatter;
        return $this;
    }
    
    /**
     * Get log formatter.
     * @return FormatterInterface
     */
    public function getFormatter()
    {
        if (!isset($this->_formatter)) {
            $this->setFormatter(new DefaultFormatter());
        }
        return $this->_formatter;
    }
    
    /**
     * Log a message.
     * @param string|array $message
     * @param int $priority
     */
    public function write($message, $priority) 
    {
        $this->_write($this->getFormatter()->format($message), $priority);
    }
    
    /**
     * Override this method!
     * @param string|array $message
     * @param int $priority
     * @throws Exception
     */
    protected function _write($message, $priority) 
    {
        throw new Exception("Not implemented");
    }
    
}
