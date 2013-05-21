<?php

/**
 * =============================================================================
 * @file        Commons/Template/AbstractTemplate.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Template;

use Commons\Container\AssocContainer;

abstract class AbstractTemplate extends AssocContainer
{
    
    /**
     * Render template script.
     * @param string $template
     * @return string
     */
    abstract public function render($template);
    
}
