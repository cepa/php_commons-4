<?php

/**
 * =============================================================================
 * @file        Commons/Light/View/ScriptView.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Light\View;

use Commons\Buffer\OutputBuffer;
use Commons\Container\AssocContainer;

class ScriptView extends AssocContainer implements ViewInterface 
{
    
    protected $_scriptPath;
    
    /**
     * Set script path.
     * @param string $scriptPath
     * @return \Commons\Light\View\ScriptView
     */
    public function setScriptPath($scriptPath)
    {
        $this->_scriptPath = $scriptPath;
        return $this;
    }
    
    /**
     * Get script path.
     * @return string
     */
    public function getScriptPath()
    {
        return $this->_scriptPath;
    }
    
    /**
     * Render script to html.
     * @throws NotFoundException
     * @return string
     */
    public function render($content = null)
    {
        $scriptPath = $this->getScriptPath();
        if (empty($scriptPath)) {
            return $content;
        }
        
        // Pass content as a view variable.
        $this->content = $content;
        
        OutputBuffer::start();
        $result = @include $scriptPath;
        $content = OutputBuffer::end();
        
        if ($result === false) {
            throw new Exception("Cannot load view file '{$scriptPath}'");
        }
        
        return $content;
    }
    
}
