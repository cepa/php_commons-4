<?php

require_once 'bootstrap.php';

use Commons\Buffer\OutputBuffer;

OutputBuffer::start();

    OutputBuffer::start();
    echo "World";
    $content = OutputBuffer::end();
    
echo "Hello {$content}\n";
$content = OutputBuffer::end();

echo $content;
