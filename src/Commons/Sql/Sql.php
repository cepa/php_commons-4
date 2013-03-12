<?php

/**
 * =============================================================================
 * @file        Commons/Sql/Sql.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Sql;

class Sql
{

    const TYPE_MYSQL = 'mysql';
    const TYPE_POSTGRESQL = 'pgsql';
    
    const FETCH_ARRAY        = 0;
    const FETCH_OBJECT       = 1;
    
    private function __construct() {} 
    
}
