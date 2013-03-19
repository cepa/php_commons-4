<?php

/**
 * =============================================================================
 * @file        Commons/Callback/Callback.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Callback;

use Commons\Exception\InvalidArgumentException;

class Callback
{
    
    protected $_callback;
    
    /**
     * Create a callback.
     * @throws InvalidArgumentException
     */
    public function __construct()
    {
        $numArgs = func_num_args();
        if ($numArgs == 1) {
            $this->_callback = func_get_arg(0);
            
        } else if ($numArgs == 2) {
            $this->_callback = array(func_get_arg(0), func_get_arg(1));
        
        } else {
            throw new Exception("Missing or too much arguments!");
        }
        
        if (!is_callable($this->_callback)) {
            throw new Exception("Given parameters are not callable!");
        }
    }
    
    /**
     * Get a callback.
     * @return string|array
     */
    public function getCallback()
    {
        return $this->_callback;
    }
    
    /**
     * Call a function or a method.
     * @return mixed
     */
    public function call()
    {
        $args = func_get_args();
        return call_user_func_array($this->_callback, $args);
    }
    
}
