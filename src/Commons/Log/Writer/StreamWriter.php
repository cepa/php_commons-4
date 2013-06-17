<?php

/**
 * =============================================================================
 * @file       Commons/Log/Writer/StreamWriter.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Log\Writer;

class StreamWriter extends AbstractWriter
{
    
    protected $_stream;
    
    /**
     * Init writer.
     * @param resource $stream
     */
    public function __construct($stream = null)
    {
        $this->setStream($stream);
    }
    
    /**
     * Set stream.
     * @param resource $stream
     * @return \Commons\Log\Writer\StreamWriter
     */
    public function setStream($stream)
    {
        $this->_stream = $stream;
        return $this;
    }
    
    /**
     * Get stream.
     * @return resource
     */
    public function getStream()
    {
        if (!isset($this->_stream)) {
            $this->_stream = @fopen('php://stderr', 'w');
        }
        return $this->_stream;
    }
    
    /**
     * Write to stream.
     * @see Commons\Log\Writer\AbstractWriter::_write()
     */
    public function _write($message, $priority)
    {
        fputs($this->getStream(), $message."\n");
    }
    
}
