<?php

/**
 * =============================================================================
 * @file        Commons/Json/Encoder.php
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

class Encoder
{
    /**
     * @param mixed $data
     * @return string
     * @throws \Commons\Exception\MissingDependencyException
     * @throws Exception
     */
    public function encode($data)
    {
        if (!function_exists('json_encode')) {
            throw new MissingDependencyException("json_encode is missing");
        }
        
        /*
         * Convert numeric value to number in json not to string.
         */
        if (is_numeric($data)) {
            return (string) $data;
        }
        
        $data = json_encode($data);
        if ($data === false || json_last_error() != JSON_ERROR_NONE) {
            throw new Exception(Errors::translateErrorCode(json_last_error()));
        }
        return $data;
    }

}
