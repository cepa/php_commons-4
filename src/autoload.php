<?php

/**
 * =============================================================================
 * @file       autoload.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

require_once dirname(__FILE__).'/Commons/Autoloader/DefaultAutoloader.php';
Commons\Autoloader\DefaultAutoloader::addIncludePath(dirname(__FILE__));
Commons\Autoloader\DefaultAutoloader::init();
