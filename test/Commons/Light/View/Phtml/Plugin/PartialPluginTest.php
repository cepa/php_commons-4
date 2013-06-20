<?php

/**
 * =============================================================================
 * @file       Commons/Light/View/Phtml/Plugin/PartialPluginTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Light\View\Phtml\Plugin;

use Commons\Light\View\Phtml\Script;

class PartialPluginTest extends \PHPUnit_Framework_TestCase
{

    public function testPartial()
    {
        $script = new Script();
        $script->getTemplateLocator()->addLocation(ROOT_PATH.'/test/fixtures');
        $plugin = new PartialPlugin();
        $plugin->setInvoker($script);
        $content = $plugin->partial('test_script_view', array('xxx' => 123));
        $this->assertEquals($content, 'hello 123');
    }
    
}
