<?php

/**
 * =============================================================================
 * @file       Mock/Callback/Object.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Mock\Callback;

class Object
{
    public function method($array)
    {
        return $array['test'];
    }
}

