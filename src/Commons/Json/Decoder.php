<?php

/**
 * =============================================================================
 * @file        Commons/Json/Decoder.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Json;

use Commons\Exception\MissingDependencyException;

class Decoder
{
    
    public function decode($data, $associative = true)
    {
        if (!function_exists('json_decode')) {
            throw new MissingDependencyException("json_decode is missing");
        }
        
        if ($data === '') { 
            return ''; 
        }
        
        if ($data === 'null') {
            return null;
        }
        
        if (is_numeric($data)) {
            return $data;
        }
        
        $data = json_decode($data, $associative);
        if ($data === null || json_last_error() != JSON_ERROR_NONE) {
            throw new Exception(Errors::translateErrorCode(json_last_error()));
        }
        return $data;
    }
    
}
