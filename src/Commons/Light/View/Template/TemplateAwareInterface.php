<?php

/**
 * =============================================================================
 * @file       Commons/Light/View/Template/TemplateAwareInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Light\View\Template;

interface TemplateAwareInterface
{

    /**
     * Set template.
     * @param string $template
     * @return TemplateAwareInterface
     */
    public function setTemplate($template);
    
    /**
     * Get template.
     * @return string
     */
    public function getTemplate();
    
}

