<?php

require_once 'bootstrap.php';

use Commons\Timer\Timer;

// Initialize timer..
$timer = new Timer();

// Print uptime.
$t = round($timer->getValue(), 4);
echo "a = $t\n";

// Wait for 0.1s.
usleep(100000);

// Print uptime.
$t = round($timer->getValue(), 4);
echo "b = $t\n";
