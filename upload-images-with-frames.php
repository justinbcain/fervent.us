<?php

$number = $_POST['number'];
$campaign = $_POST['campaign'];
$testMode = $_POST['testMode'];
$img = $_POST['imgBase64'];

$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$fileData = base64_decode($img);
//echo $fileData;
//saving

echo $fileName;
if($_POST['testMode']==1){
  $path = "/var/www/fervent.us/html/$campaign-images/test-donors/{$number}.png";
} else {
  $path = "/var/www/fervent.us/html/$campaign-images/donors/{$number}.png";
}
file_put_contents($path, $fileData);



?>
