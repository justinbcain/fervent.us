<?php

$input = @file_get_contents('php://input');
$event_json = json_decode($input);

#get the campaign name from the url
$uri = $_SERVER['REQUEST_URI'];
preg_match('/[^\/].*(?=(\-webhook))/',$uri,$match);
$campaign = $match[0];

$servername = "localhost";
$username = "dbuser";
$password = "xxxxxxxxxxxxx";
$db = "campaigns";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT donorCount FROM pageFormatting WHERE campaignName = '$campaign'";
$query = mysqli_query($conn, $sql);
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$donorCount = $row['donorCount'];
$hmmm = $row['donorCount'];

if(!isset($donorCount)){
  $donorCount = 1;
}


if(isset($event_json)){
  $donorCount++;
  $sql = "UPDATE pageFormatting SET donorCount = $donorCount WHERE campaignName = '$campaign'";
  $conn->query($sql);
  $conn->close();
}






?>
