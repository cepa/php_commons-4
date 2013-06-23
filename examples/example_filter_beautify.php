<?php

require_once 'bootstrap.php';

use Commons\Filter\BeautifyFilter;

$filter = new BeautifyFilter();
$content = $filter->filter(file_get_contents(dirname(__FILE__).'/beautify.md'));
?>
<html>
<head>
    <title>Beautify example</title>
    <link href="http://cdn.hellworx.com/hellworx/reset.css" rel="stylesheet">
    <link href="http://cdn.hellworx.com/bootstrap/css/bootstrap.css" rel="stylesheet">
</head>
<body>
    <div style="padding:20px;">
    <?= $content ?>
    </div>
</body>
</html>
