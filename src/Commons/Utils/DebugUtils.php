<?php

/**
 * =============================================================================
 * @file       Commons/Utils/DebugUtils.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Utils;

use Commons\Log\Log;

class DebugUtils
{

    const TEMPLATE = <<<EOD
        <html>
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Fatal Error</title>
        </head>
        <body style="border:0; margin:0; padding:0; width:100%; height:100%; font:13px Arial,Tahoma,helvetica,sans-serif; background:#efefef; color:#000000;">
        <div style="height:70px; background:#b70606; color:#ffffff; line-height:70px; font-size:30px; font-weight:bold; padding:0 20px;">Error</div>
        <div style="padding:10px 20px;">
            <div style="font-weight:bold; font-size:16px; color:#aaaaaa; line-height:32px; letter-spacing:1px;">Error:</div>
            <div style="font-size:22px; font-weight:bold; color:#000000; padding:4px 20px;">{{CLASS}}: {{MESSAGE}}</div>
            <div style="font-weight:bold; font-size:16px; color:#aaaaaa; line-height:32px; letter-spacing:1px;">Backtrace:</div>
            <div style="padding:4px 20px;">
                <pre>{{TRACE}}</pre>
            </div>
        </div>
        </body>
        </html>
EOD;

    protected function __construct() {}

    public static function renderExceptionPage(\Exception $e)
    {
        ob_end_clean();

        $message = get_class($e).": ".$e->getMessage()."\n".$e->getTraceAsString();
        Log::critical(str_replace("\n", ': ', $message));

        header("HTTP/1.1 500 Internal Server Error");
        header("Content-Type: text/html; charset=utf-8");

        $template = array(
            '{{CLASS}}'   => get_class($e),
            '{{MESSAGE}}' => $e->getMessage(),
            '{{TRACE}}'   => $e->getTraceAsString()
        );

        echo str_replace(array_keys($template), array_values($template), self::TEMPLATE);
    }

}
