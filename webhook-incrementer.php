<?php
#receives a charge.successful event from stripe. increments the donor number +1.
$input = @file_get_contents('php://input');
$event_json = json_decode($input);
$file = 'donorcount.txt';
$current = (int)file_get_contents($file);
$new = $current + 1;
if(isset($event_json)){
  file_put_contents($file,$new);
}
?>
