<?php

require "src/require.php";

echo $_GET['w'] . "x" . $_GET['h'] . "\n";

$fetch = new ImageFetch('placeimg', 'placeimg/generated');
echo $fetch->getPathForImage($_GET['w'], $_GET['h']);
