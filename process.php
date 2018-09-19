<?php
#creates the charge for the stripe payment. If succesful, sends the donor to the frame creation page. 
ini_set('session.gc_maxlifetime',5);
session_set_cookie_params(5);
session_start();


$unsuccessful = false;
$paid = isset($_SESSION['number']);

//composer requirement for stripe sdk
require_once('vendor/autoload.php');
\Stripe\Stripe::setApiKey("sk_live_UqKQX9qoqtVhNGQkprgx11F5");
#\Stripe\Stripe::setApiKey("sk_test_KXddpjXNBwOshMDNFjHXSbQV");

// Get the payment token ID submitted by the form:
$amount = $_POST['amountInCents'];
$token = $_POST['stripeToken'];


try {
    $charge = \Stripe\Charge::create([
        "amount" => $amount,
        "currency" => "usd",
        "card" => $token,
        "description" => "City Center - OKC"
    ]);
} catch(Stripe_CardError $e) {
  $unsuccessful = true;
    // The card has been declined
}



if($unsuccessful == false){
    $file = 'donorcount.txt';
    $current = (int)file_get_contents($file);
    $_SESSION['number'] = $current;
    header("Location:https://fervent.us/echoenergy-confirm.php?ids=$current");
}


?>
