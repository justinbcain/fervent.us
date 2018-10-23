<?php

$input = @file_get_contents('php://input');
$event_json = json_decode($input);

#get the campaign name from the url
$uri = $_SERVER['REQUEST_URI'];
preg_match('/[^\/].*(?=(\-test))/',$uri,$match);
$campaign = $match[0];

$servername = "xxxxxxxxxxxxx";
$username = "xxxxxxxxxxxxx";
$password = "xxxxxxxxxxxxx";
$db = "campaigns";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT testDonorCount FROM pageFormatting WHERE campaignName = '$campaign'";
$query = mysqli_query($conn, $sql);
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$donorCount = $row['testDonorCount'];


if(!isset($donorCount)){
  $donorCount = 1;
}


if(isset($event_json)){
  $donorCount++;
  $sql = "UPDATE pageFormatting SET testDonorCount = $donorCount WHERE campaignName = '$campaign'";
  $conn->query($sql);
  $conn->close();
}






?>
