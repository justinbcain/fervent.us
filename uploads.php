<?php

$img = $_POST['imgBase64'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$fileData = base64_decode($img);
//echo $fileData;
//saving
$fileName = $_POST['number'];
echo $fileName;
$path = "/var/www/fervent.us/html/images/{$fileName}.png";
file_put_contents($path, $fileData);
//var_dump($_POST);

$test = $_SERVER['DOCUMENT_ROOT'];
//echo $test;

?>
