<?php

/**
 * =============================================================================
 * @file       Commons/Validator/ValidatorInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Validator;

interface ValidatorInterface
{
    
    /**
     * Validate.
     * @param mixed $value
     * @return mixed
     */
    public function validate($value);
    
}

