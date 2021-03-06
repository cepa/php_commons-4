<?php

/**
 * =============================================================================
 * @file       Commons/Light/View/JsonView.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Light\View;

use Commons\Json\Encoder as JsonEncoder;

class JsonView implements ViewInterface 
{
    
    protected $_json;
    
    /**
     * Init json view.
     * @param mixed $json
     */
    public function __construct($json = null)
    {
        $this->_json = $json;
    }    
    
    /**
     * Set json data.
     * @param mixed $json
     * @return \Commons\Light\View\JsonView
     */
    public function setJson($json)
    {
        $this->_json = $json;
        return $this;
    }
    
    /**
     * Get json data.
     * @return mixed
     */
    public function getJson()
    {
        return $this->_json;
    }
    
    /**
     * Render json
     * @return string
     */
    public function render($content = null)
    {
        $encoder = new JsonEncoder();
        return $encoder->encode($this->getJson());
    }
    
}
