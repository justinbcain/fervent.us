<?php
#first page in the user flow. initiates the stripe payment. posts data to process.php where stripe creates the charge. 
$stripekey = 'pk_live_neboPBl1ge07PH1qUz0y9rpe';
#$stripekey ='pk_test_WBJmijjYroO86KbebnkR6EHA';

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
	<link rel="shortcut icon" type="image/png" href="citycenter.png"/>
	<link rel="stylesheet" type="text/css" href="echoenergy.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-54T674M"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div class="container">
	<div class="header">
		<div class="headerContainer">
			<div class="left">
				<img src="logo.png" id="logo">
			</div>
			<div class="right">
				<div class="tagline"><p>Working Together To Impact Our Community.</p></div>
				<div class="math"><h1> 1,000 = $30,000 </h1></div>
			</div>
		</div>
	</div>

	<div class="frameRow">
		<div class="placeholder" id="p1">
			<div class="frame"></div>
		</div>
		<div class="placeholder" id="p2">
			<div class="frame"></div>
		</div>
		<div class="placeholder" id="p3">
			<div class="frame"></div>
		</div>
		<div class="placeholder" id="p4">
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
				<form id="myForm" action="process.php" method="POST">
					<div id="inputRow">
					<div id="amountContainer">
						<label id="amountLabel" for='amountInDollars'>$</label>
						<input type="number" id="amountInDollars" placeholder ="15"/>
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
			<div class="placeholder" id="p1">
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
			<div class="placeholder hide" id="p10">
				<div class="frame"></div>
			</div>
		</div>



		<div class="videoBox">
			<div style="position:relative;height:0;padding-bottom:56.21%" style="margin-top:50px"><iframe src="https://www.youtube.com/embed/KZfLKDE51bQ?ecver=2" style="position:absolute;width:100%;height:100%;left:0" width="641" height="360" frameborder="0" margin-top='50px'allow="autoplay; encrypted-media" allowfullscreen></iframe></div>
		</div>

	</div>

	<script src="https://checkout.stripe.com/checkout.js"></script>
	<script src="https://js.stripe.com/v3/"></script>


	<div class="copy">
		<p> Thanks to the generosity of Echo Energy, once 1,000 advocates give and share, Echo Energy will donate $30,000 to OKCityCenter. </p>
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
  image: 'citycenter.png',
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
        name: 'City Center Outreach Inc.',
        description: '$' + displayAmount,
        amount: amountInCents,
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
