<?php

/**
 * =============================================================================
 * @file        Commons/Utils/TestUtils.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Utils;

class TestUtils
{

    protected function __construct() {}

    /**
     * Abort an unit test in a safe way with printing the exception output.
     * @param Exception $exception
     */
    public static function abort(\Exception $exception = null)
    {
    	if ($exception) {
    		$message = get_class($exception).": ".$exception->getMessage()."\n".$exception->getTraceAsString();
    		echo $message."\n";
    	}
    	exit(-1);
    }
    
}
