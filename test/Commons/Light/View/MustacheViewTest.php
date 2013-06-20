<?php

/**
 * =============================================================================
 * @file       Commons/Light/View/MustacheViewTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Light\View;

class MustacheViewTest extends \PHPUnit_Framework_TestCase
{

    public function testView()
    {
        $view = new MustacheView();
        $view->setTemplate('Test {{content}} {{var}}');
        $view->var = '123';
        $content = $view->render('xxx');
        $this->assertEquals('Test xxx 123', $content);
    }
    
    public function testRenderEmptyView()
    {
        $view = new MustacheView();
        $this->assertEquals('', $view->render());
    }
    
}
