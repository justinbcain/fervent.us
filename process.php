<?php
#this page processes the stripe payment
#sends the user to the campaign-confirm
#with the donor number appended to the url
ini_set('session.gc_maxlifetime',5);
session_set_cookie_params(5);
session_start();


$servername = "localhost";
$username = "dbuser";
$password = "organicBackbone4217";
$db = "campaigns";

$campaign = $_GET['campaign'];

// Create connection
$conn = new mysqli($servername, $username, $password, $db);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM pageFormatting WHERE campaignName = '$campaign'";

$result = $conn->query($sql);

$row = $result->fetch_assoc();

isset($row['testDonorCount']) ? $testDonorCount = $row['testDonorCount'] : $testDonorCount = 1;
isset($row['donorCount']) ? $donorCount = $row['donorCount'] : $donorCount = 1;


//composer requirement for stripe sdk
require_once('vendor/autoload.php');



if($row['testMode']==1){
  $stripeToken = $row['stripeTestTokenSecret'];
  $nextPage = "https://fervent.us/$campaign-confirm.php?status=test&id=$testDonorCount";
  $current = $testDonorCount;
} else {
  $stripeToken = $row['stripeTokenSecret'];
  $nextPage = "https://fervent.us/$campaign-confirm.php?id=$donorCount";
  $current = $donorCount;
}

\Stripe\Stripe::setApiKey("$stripeToken");


$unsuccessful = false;
#set that the user has paid, avoids redirecting on the campaign-confirm page
$paid = isset($_SESSION['number']);




// Get the payment token ID submitted by the form:
$amount = $_POST['amountInCents'];
$token = $_POST['stripeToken'];
$email = $_POST['stripeEmail'];


try {
    $charge = \Stripe\Charge::create([
        "amount" => $amount,
        "currency" => "usd",
        "card" => $token,
        "description" => $campaign,
        "receipt_email" => $email,
        "metadata" => array("donorNumber" => $current),
    ]);
} catch(Stripe_CardError $e) {
  $unsuccessful = true;
    // The card has been declined
}

echo $unsuccessful;

if($unsuccessful == false){
    $_SESSION['number'] = $current;
    header("Location:$nextPage");
}
$conn->close();

?>
