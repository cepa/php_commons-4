<?php

/**
 * =============================================================================
 * @file       Commons/Container/ValidableContainer.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Container;

use Commons\Callback\Callback;

class ValidableContainer extends CollectionContainer
{
    
    protected $_validator;
    
    public function setValidator($callable)
    {
        $this->_validator = new Callback($callable);
        return $this;
    }
    
    public function getValidator()
    {
        return $this->_validator;
    }
    
    public function set($name, $value)
    {
        $this->_validate($value);
        return parent::set($name, $value);
    }
    
    protected function _validate($value)
    {
        if (isset($this->_validator)) {
            if (!$this->getValidator()->call($value)) {
                if (is_object($value)) {
                    throw new Exception("Invalid value of type ".get_class($value));
                } else {
                    throw new Exception("Invalid value of type ".gettype($value));
                }
            }
        }
        return true;
    }
    
}
