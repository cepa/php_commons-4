<?php

/**
 * =============================================================================
 * @file        Commons/Json/Errors.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Json;

class Errors
{
    
    protected static $_errors = array(
        JSON_ERROR_DEPTH            => 'The maximum stack depth has been exceeded',
        JSON_ERROR_STATE_MISMATCH   => 'Invalid or malformed JSON',
        JSON_ERROR_CTRL_CHAR        => 'Control character error, possibly incorrectly encoded JSON',
        JSON_ERROR_SYNTAX           => 'Syntax error found, possibly incorrectly encoded JSON',
        JSON_ERROR_UTF8             => 'Malformed UTF-8 characters, possibly incorrectly encoded',
    );
    
    protected function __construct() {}
    
    public static function translateErrorCode($errorCode)
    {
        return (isset(self::$_errors[$errorCode]) ? self::$_errors[$errorCode] : "Unknown error"); 
    }

}

