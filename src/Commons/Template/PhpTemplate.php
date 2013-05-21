<?php

/**
 * =============================================================================
 * @file        Commons/Template/PhpTemplate.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Template;

use Commons\Buffer\OutputBuffer;

class PhpTemplate extends AbstractTemplate
{
    
    /**
     * Render PHP template.
     * @see \Commons\Template\AbstractTemplate::render()
     */
    public function render($template)
    {
        $path = $template;
        if (!file_exists($path)) {
            $path = stream_resolve_include_path($template);
            if (!file_exists($path)) {
                $trace = debug_backtrace();
                $path = dirname(@$trace[1]['args'][0]).'/'.$template;
                if (!file_exists($path)) {
                    throw new Exception("Cannot render template '{$template}'");
                }
            }
        }
        
        OutputBuffer::start();
        $result = @include $path;
        $content = OutputBuffer::end();
        if ($result === false) {
            throw new Exception("Cannot render template '{$template}'");
        }
        return $content;
    }
    
}
