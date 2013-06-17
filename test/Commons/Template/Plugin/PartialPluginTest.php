<?php

/**
 * =============================================================================
 * @file       Commons/Template/Plugin/PartialPluginTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Template\Plugin;

use Commons\Template\PhpTemplate;

class PartialPluginTest extends \PHPUnit_Framework_TestCase
{

    public function testPartial()
    {
        $plugin = new PartialPlugin();
        $plugin->setInvoker(new PhpTemplate());
        $content = $plugin->partial(ROOT_PATH.'/test/fixtures/test_script_view.phtml', array('xxx' => 123));
        $this->assertEquals($content, 'hello 123');
    }
    
}
