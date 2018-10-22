<?php
ini_set('session.gc_maxlifetime',5);
session_set_cookie_params(5);
session_start();


$servername = "localhost";
$username = "dbuser";
$password = "organicBackbone4217";
$db = "campaigns";








// Create connection
$conn = new mysqli($servername, $username, $password, $db);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$uri = $_SERVER['REQUEST_URI'];
if (strpos($uri, '.')) {
    preg_match('/[^\/][^.]*/',$uri,$match);
    $campaign = $match[0];
} else {
  preg_match('/[^\/].*/',$uri,$match);
  $campaign = $match[0];
}


$sql = "SELECT * FROM pageFormatting WHERE campaignName = '$campaign'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();




$conn->close();


if($row['testMode']==1){
  $stripekey = $row['stripeTestToken'];
} else {
  $stripekey = $row['stripeToken'];
}




?>

<html>
<head>
	<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-54T674M');</script>
<!-- End Google Tag Manager -->
	<link rel="shortcut icon" type="image/png" href="<?=$row['logo']?>"/>
	<link rel="stylesheet" type="text/css" href="firstpage.css">
	<!--<link rel="stylesheet" type="text/css" href="freethestates-images.css">-->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<style>
html {
 background-image:url(<?=$row['campaignName'].'-images/'.$row['backgroundImage']?>); no-repeat center center fixed;
 -webkit-background-size: cover;
 -moz-background-size: cover;
 -o-background-size: cover;
 background-size: cover;
}
.header {
	background-color:<?=$row['headerColor']?>;
}
.right {
	color:<?=$row['headerFontColor']?>;
}
#p1{
	background-image:url(<?=$row['campaignName'].'-images/'.$row['placeholder1']?>);
	background-size:100%;
}
#p2{
	background-image:url(<?=$row['campaignName'].'-images/'.$row['placeholder2']?>);
	background-size:100%;;
}
#p3{
	background-image:url(<?=$row['campaignName'].'-images/'.$row['placeholder3']?>);
	background-size:100%;
}
#p4{
	background-image:url(<?=$row['campaignName'].'-images/'.$row['placeholder4']?>);
	background-size:100%;
}
#p5{
	background-image:url(<?=$row['campaignName'].'-images/'.$row['placeholder5']?>);
	background-size:100%;
}
#p6{
	background-image:url(<?=$row['campaignName'].'-images/'.$row['placeholder6']?>);
	background-size:100%;
}
#p7{
	background-image:url(<?=$row['campaignName'].'-images/'.$row['placeholder7']?>);
	background-size:100%;
}
#p8{
	background-image:url(<?=$row['campaignName'].'-images/'.$row['placeholder8']?>);
	background-size:100%;
}
#p9{
	background-image:url(<?=$row['campaignName'].'-images/'.$row['placeholder9']?>);
	background-size:100%;
}
#p10{
	background-image:url(<?=$row['campaignName'].'-images/'.$row['placeholder10']?>);
	background-size:100%;
}

.frame {
	background-image: url('<?=$row['campaignName'].'-images/'.$row['miniFrame']?>');
	background-size:100%;
	height:100%;
	width:100%;
	position:absolute;
	top:0;

}

#logo {
	height:<?=$row['logoHeight']?>;
	margin:auto;
	padding-top:10px;
	margin-right:30px;
	padding-bottom:10px;
}

.stripeBox {
		background-color:<?=$row['boxColor']?>;
		color: <?=$row['boxFontColor']?>;
		opacity:.5;

}
#customButton {
	background-color:<?=$row['boxButtonColor']?>;
	color:<?=$row['boxButtonFontColor']?>;
}

.copy {
	color:<?=$row['copyFontColor']?>;
}

</style>
<body>
  <?php
  #create a back to editor button for the username
  #this avoids the browser asking if they'd like to
  #resubmit the form when they hit the back button
  #
  #also store the campaign the user is working on in the session to allow the
  #editor page to load which campaign the user is working on
  #otherwise destory session, since it could interfere with the
  #redirect on the confirm page
  $ref = $_SERVER['HTTP_REFERER'];

  if($ref == 'https://fervent.us/editor.php' or $ref == 'https://fervent.us/editor'){
    $_SESSION['campaignName'] = $row['campaignName'];
    echo '<a href="https://fervent.us/editor" style="text-decoration:none">
    <div style="background-color:#34A7C1;height:60px;width:150px;
    border-radius:5px;color:white;display:table-cell;vertical-align:middle;">
    BACK TO EDITOR
    </div>
    </a>';
  } else {
    session_destroy();
  }


?>


<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-54T674M"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div class="container">
	<div class="header">
		<div class="headerContainer">
			<div class="left">
				<img id="logo" src="<?=$row['campaignName'].'-images/'.$row['logo']?>" onerror="this.style.display='none'">
			</div>
			<div class="right">
				<div class="tagline"><p><?=$row['headline1']?></p></div>
				<div class="math"><h1><?=$row['headline2']?> </h1></div>
			</div>
		</div>
	</div>

	<div class="frameRow">
		<div class="placeholder" id="p4">
			<div class="frame"></div>
		</div>
		<div class="placeholder" id="p2">
			<div class="frame"></div>
		</div>
		<div class="placeholder" id="p3">
			<div class="frame"></div>
		</div>
		<div class="placeholder" id="p1">
			<div class="frame"></div>
		</div>
		<div class="placeholder" id="p5">
			<div class="frame"></div>
		</div>
		<div class="placeholder hide" id="p6">
			<div class="frame"></div>
		</div>
		<div class="placeholder hide" id="p7">
			<div class="frame"></div>
		</div>
	</div>

	<div class="formAndVideo">
		<div class="stripeRow">
			<div class="stripeBox">
				<p>Please Enter Your Donation Amount</p>
				<form id="myForm" action="process.php?campaign=<?=$row['campaignName']?>" method="POST">
					<div id="inputRow">
					<div id="amountContainer">
						<label id="amountLabel" for='amountInDollars'>$</label>
						<input type="number" id="amountInDollars" placeholder ="Amount Here"/>
					</div>
					</div>
				  <input type="hidden" id="stripeToken" name="stripeToken" />
				  <input type="hidden" id="stripeEmail" name="stripeEmail" />
				  <input type="hidden" id="amountInCents" name="amountInCents" />
				</form>
				<div id="error_explanation"></div>
				<div id="buttonWrapper">
					<input type="button" id="customButton" value="Pay With Card">
				</div>
			</div>
		</div>

		<div class="frameRow middle">
			<div class="placeholder" id="p9">
				<div class="frame"></div>
			</div>
			<div class="placeholder" id="p5">
				<div class="frame"></div>
			</div>
			<div class="placeholder" id="p7">
				<div class="frame"></div>
			</div>
			<div class="placeholder" id="p6">
				<div class="frame"></div>
			</div>
			<div class="placeholder" id="p8">
				<div class="frame"></div>
			</div>
			<div class="placeholder hide" id="p9">
				<div class="frame"></div>
			</div>
			<div class="placeholder hide" id="p1">
				<div class="frame"></div>
			</div>
		</div>



		<div class="videoBox">
			<iframe width="300" height="168.688" src= '<?=$row['videoLink']?>' frameborder="0" allowfullscreen></iframe>
		</div>

	</div>

	<script src="https://checkout.stripe.com/checkout.js"></script>
	<script src="https://js.stripe.com/v3/"></script>


	<div class="copy">
		<p> <?=$row['copy']?> </p>
	</div>

	<div class="frameRow">
		<div class="placeholder" id="p8">
			<div class="frame"></div>
		</div>
		<div class="placeholder" id="p9">
			<div class="frame"></div>
		</div>
		<div class="placeholder" id="p10">
			<div class="frame"></div>
		</div>
		<div class="placeholder" id="p4">
			<div class="frame"></div>
		</div>
		<div class="placeholder" id="p1">
			<div class="frame"></div>
		</div>
		<div class="placeholder hide" id="p3">
			<div class="frame"></div>
		</div>
		<div class="placeholder hide" id="p2">
			<div class="frame"></div>
		</div>
	</div>

	<div class="footer">
		Website Powered By Fervent
	</div>
</div>
</body>

<script>


var handler = StripeCheckout.configure({
  key:'<?=$stripekey?>',
  <?php
    if($row['logo'] != "#"){
      $campaign = $row['campaignName'];
      $logo = $row['logo'];
      echo "image: '$campaign-images/$logo',";

    }
   ?>

	zipCode: true,
  token: function(token) {
    $("#stripeToken").val(token.id);
    $("#stripeEmail").val(token.email);
    $("#amountInCents").val(Math.floor($("#amountInDollars").val() * 100));
    $("#myForm").submit();
  }
});

//
//on hitting the submit button. trigger stripe iframe and numnber of donors
//

$('#customButton').on('click', function(e) {
  e.preventDefault();
	console.log('submit button clicked');
	//increment donor count by 1
	$.ajax({
 	 type: "POST",
 	 url: "increment.php",
 	 data: { num: 0 },
 })

	//errors for donation
  $('#error_explanation').html('');

  var amount = $('input#amountInDollars').val();
  amount = amount.replace(/\$/g, '').replace(/\,/g, '')

  amount = parseFloat(amount);

  if (isNaN(amount)) {
    $('#error_explanation').html('<p>Please enter a valid amount in USD ($).</p>');
  }
  else if (amount < 5.00) {
    $('#error_explanation').html('<p>Donation amount must be at least $5.</p>');
  }
  else {
    var amountInCents = Math.floor($("#amountInDollars").val() * 100);
    var displayAmount = parseFloat(Math.floor($("#amountInDollars").val() * 100) / 100).toFixed(2);

      // Open Checkout with further options
      handler.open({
        name: "<?=$row['campaignName']?>",
        <?php
          if($row['testMode']==1){
            echo "description: 'Use card #4242 4242 4242 4242 while in testing',";
          } else {
            echo "description: '$' + displayAmount,";
          }
        ?>
        amount: amountInCents,
				billingAddress : true,
      });
      e.preventDefault();


    // Close Checkout on page navigation
    $(window).on('popstate', function() {
      handler.close();
    })
  }
});


$(document).keypress(
  function(event){
    if (event.keyCode == '13') {
      event.preventDefault();
    }
});

$(document).ready(function(){
$("#myForm").keypress(function(e){
    if(e.keyCode==13){
        $("#customButton").click();
    }
 });
});




</script>

</html>
