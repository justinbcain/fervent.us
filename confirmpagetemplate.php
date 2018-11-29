<?php
ini_set('session.gc_maxlifetime',5);
session_set_cookie_params(5);
session_start();


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



$uri = $_SERVER['REQUEST_URI'];
preg_match('/[^\/].*(?=(\-confirm))/',$uri,$match);
$campaign = $match[0];



$sql = "SELECT * FROM pageFormatting WHERE campaignName = '$campaign'";

$result = $conn->query($sql);

$row = $result->fetch_assoc();


$conn->close();

$current =  $_GET['id'];

$paymentComplete = isset($_SESSION['number']);

if(
	$row['testMode']==0 &&
	strpos($_SERVER['HTTP_USER_AGENT'],'facebookexternalhit') === false &&
	strpos($_SERVER["HTTP_USER_AGENT"], 'Facebot') === false &&
	$paymentComplete == false

){
  header("Location: https://fervent.us/$campaign");
}


if($row['testMode']==0){
$ogurl = "https://fervent.us/$campaign-confirm.php?id=$current";
$ogImageSecureUrl = "https://fervent.us/$campaign-images/donors/$current.png";
} else {
  $ogurl = "https://fervent.us/$campaign-confirm.php?status=test&id=$current";
  $ogImageSecureUrl = "https://fervent.us/$campaign-images/test-donors/$current.png";
}

?>



<html>
<head>
	<link rel="shortcut icon" type="image/png" href="<?=$row['logo']?>"/>
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-54T674M');</script>
	<!-- End Google Tag Manager -->
	<link rel="stylesheet" type="text/css" href="confirmpage.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="node_modules/croppie/croppie.css" />
	<script src="node_modules/croppie/croppie.js"></script>
	<script src="node_modules/exif-js/exif.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Courgette" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Meie+Script" rel="stylesheet">

	<meta property="fb:app_id" content="527400594366316" />
	<meta property="og:url" content="<?=$ogurl?>">
	<meta property="og:image:secure_url" content="<?=$ogImageSecureUrl?>">
  <meta property="og:image" content="<?=$ogImageSecureUrl?>">
	<meta property="og:type" content="article" >
	<meta property="og:title" content="<?=$row['fbTitle']?>" >
	<meta property="og:description" content="<?=$row['fbDescription']?>">
	<meta property="og:image:width" content="688" >
	<meta property="og:image:height" content="360" >
	<script src="https://js.stripe.com/v3/"></script>


</head>
<style>
html {
 background-image:url(<?=$row['campaignName'].'-images/'.$row['backgroundImage']?>); no-repeat center center fixed;
 -webkit-background-size: cover;
 -moz-background-size: cover;
 -o-background-size: cover;
 background-size: cover;
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

.copy {
	color:<?=$row['copyFontColor']?>;
}

.uploadButton1 {
	height: 50px;
	padding-top: 0px;
	cursor: pointer;
}

.uploadButton1:focus {
    outline: -webkit-focus-ring-color auto 0px;
		border-radius: 50%;
}


</style>
<body>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId            : '527400594366316',
      autoLogAppEvents : true,
      xfbml            : true,
      version          : 'v3.1'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-54T674M"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<div class="container">


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


  <!--test placing this image here and see if fb will crawl it -->
  <img src="<?=$ogImageSecureUrl?>" style="display:none"/>

	<div class="header">
		<h2 id="header1"> Thank you for your support! </h2>
		<h3 id="instructions"> Help grow the campaign by sharing on facebook! </br> Click the upload button to upload your own photo. </h3>

	</div>





	<div class="buttons">
		<div class="buttonBorder">
			<div class="initialUpload">
				<!--<input type="file" id="file" class="files" onchange="readURL(this)">-->
        <input type="file"  id="file" class="files" name="cameraInput" onchange="readURL(this)">
        <button class="uploadButton1 btn btn-primary">
          <i class="fa fa-upload" style="font-size:24px;border-radius:10px"></i>
        </button>
			</div>
			<div class="checkButton">
	          <i class="fa fa-check" aria-hidden="true" style="font-size:24px;color:white"></i>
			</div>
	        <div class="fbShareButton" onclick="uploadToFB()">
	          <img src="fbicon.png" id="fbicon"/>
	        </div>
	    </div>
	</div>

	<div class="cropHolder">
	</div>



	<div class="copy">
		<p> <?=$row['copy']?> </p>
	</div>


	<div class="footer">
		<h4> Site Powered By Fervent </h4>
	</div>

	<div class="testholder" style="width:100%;">
		<div class="test" style="width:688;height:360;background-color:black;margin:auto;">
			<canvas id="myCanvas" height = '360' width = '688' ></canvas>
		</div>
	</div>

</div>

  <canvas id="number" style="position:absolute;top:247;left:0;">

  </canvas>

</body>

<script>

$(".uploadButton1").click(function(event){
  event.preventDefault();
  $("#file").trigger("click")
})


frame = '<img src="<?=$campaign?>-images/<?=$row['frame']?>" id="frame" style="margin-top:247px;width:360px;"/>';

// set the viewport size
var basic = $('.cropHolder').croppie({
	enforceBoundary: true,
	enableExif: true,
    viewport: {
        width: 360,
        height: 360
    },

});

// adjust the number on the canvas in the image preview
var numberCanv = document.getElementById('number');
numberCanv.width = 360;
numberCanv.height = 114.516;
var numberCtx = numberCanv.getContext('2d');


var x = <?=$row['donorNumberX']?>;
console.log(x);
//console.log(x);
var y = <?=$row['donorNumberY']?>;
console.log(y);
//console.log(y);
var fontSize = <?=$row['donorFontSize']?>+'pt';
console.log(fontSize);
//console.log('font size : ',fontSize);
var fontColor = "<?=$row['donorFontColor']?>";
console.log(fontColor);
var font = "<?=$row['donorFontSelection']?>";
console.log(font);

numberCtx.fillStyle = fontColor;
numberCtx.font = `${fontSize} ${font}`;
//numberCtx.drawImage(background,0,0,numberCanv.width,numberCanv.height);
numberCtx.fillText("<?=$current?>",x,y);
//numberCtx.fillStyle = `${fontColor}`





//var idNumber = `<canvas id="numberPlacement" style="position:absolute;top:0;left:0;"> <p style="color:white;font-size:22px;margin-top:0;margin-right:0;font-family: Meie Scrip;font-style:italic;"> <?=$current ?>... </p> </canvas>`;

// get uploaded images and binds to the cropppie canvas
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onloadend = function (e) {
        	uploadSuccess();
        	image = e.target.result;
        	basic.croppie('bind', {
        	enableExif: true,
					enforceBoundary: false,
    		url: image
			});
			// what's this for?
			//$('#newImage').attr('src',image);

        };
        reader.readAsDataURL(input.files[0]);
				$('#header1').hide();
				$('#instructions').css('margin-top','20px');
	}

}

uploadSuccess = function(){
	$('#instructions').html('Adjust your image and click the check mark when it\'s perfect!');
	$('.checkButton').show();
	$('.uploadButton1').css('float','left');
}


var c = document.getElementById('myCanvas');
var ctx = c.getContext('2d');


window.onload = function(){
img = '<?=$row['campaignName'].'-images/'.$row['defaultFrameImage']?>';






//bind the original image to croppie
basic.croppie('bind', {
    url: img,
});
$('.cr-boundary').append(frame);
var idNumber = document.getElementById('number');
$('.cr-boundary').append(idNumber);

}


function uploadToFB(){
  FB.ui({
    method: 'share',
    href: window.location.href,
  }, function(response){});
}



$('.checkButton').click(function(event){
	$('.uploadButton1').hide();
	$('.checkButton').hide();

	  event.preventDefault();
	  $(window).width() < 500 ? $('#explain5').fadeIn() : $('#explain4').fadeIn();
		basic.croppie('result', 'base64').then(function(base64) {
			var img = new Image();
			img.onload = function(){
				$.when($.ajax(ctx.drawImage(img,
					c.width/2 - img.width/2,
					c.height/2-img.height/2))
				).then(
					function(){
						frameSet()
            ctx.font = `${fontSize} ${font}`;
            ctx.fillStyle = `${fontColor}`
						ctx.fillText("<?=$current ?>",160+x,247+y);
					var dataURL = c.toDataURL();
					$.ajax({
					    type: "POST",
					    url: 'upload-images-with-frames.php',
					    data: {
			     			imgBase64: dataURL,
								number: <?=$current?>,
                campaign: '<?=$campaign?>',
                testMode: <?=$row['testMode']?>
			  			},
							//once the image is uploaded post the page contents to facebook for caching
							//this helps facebook collect page information when the user uploads
					    success: function(){
								FB.api(
								  '/',
								  'POST',
								  {"scrape":"true","id":"<?=$ogurl?>","token":"527400594366316|Z-Qtrzme4lExJHYkJHU5RZdKoSY"},
								  function(response) {
                  	$('.fbShareButton').show();
                  	$('#fbicon').show();
                  	$('#instructions').html('Click The Facebook Icon To Share!'+'<br><br>'+'Suggested Post: '+'<br><br>'+'<span style="font-size:12px">' + "<?=$row['suggestedPost']?>" );
								  }
								);
			      	}
			      });
				}
			)
		}

		frameSet = function(){
		var frameimg = new Image();
		//newframe == '' ?
		frameimg.src = $(frame).attr('src');
		//frameimg.src = newframe
		frameh = frameimg.height;
		framew = frameimg.width;
		ctx.drawImage(frameimg,164,248,360,(360/framew)*frameh);
		}
    
    img.src= base64;
    ctx.font = "italic 22px Meie Scrip";
    ctx.fillStyle = 'white';

	});
});


function uploadToFB(){
  console.log('upload to fb clicked');
  FB.ui({
    method: 'share',
    href: window.location.href,
  }, function(response){});
}




</script>

<style>
.cr-slider {
	display:none !important;
}
</style>

</html>
