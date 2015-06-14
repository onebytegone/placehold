<?php

require "src/require.php";

//echo $_GET['w'] . "x" . $_GET['h'] . "\n";

$fetch = new ImageFetch('placeimg', 'placeimg/generated');
$path = $fetch->getPathForImage($_GET['w'], $_GET['h']);

$data = getimagesize($path);
if (!$data) {
   die("Cannot get mime type");
} else {
   header('Content-Type: ' . $data['mime']);
}

readfile($path);
