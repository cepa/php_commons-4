<?php

/**
 * =============================================================================
 * @file       Mock/Light/ActionController.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Mock\Light;

class ActionController extends \Commons\Light\Controller\ActionController 
{
    
    public function indexAction()
    {
        return 'index';
    }
    
    public function someOtherAction()
    {
        return 'some other';
    }
    
}
