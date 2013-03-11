<?php

/**
 * =============================================================================
 * @file        Mock/Callback/Object.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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

