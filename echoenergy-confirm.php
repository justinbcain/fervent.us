<?php
#creates the user frame and allows upload to FB.
#redirects new users to first page in flow

ini_set('session.gc_maxlifetime',5);
session_set_cookie_params(5);
session_start();

$paymentComplete = isset($_SESSION['number']);

if(
	strpos($_SERVER['HTTP_USER_AGENT'],'facebookexternalhit') === false &&
	strpos($_SERVER["HTTP_USER_AGENT"], 'Facebot') === false &&
	$paymentComplete == false

){
  #header('Location: https://fervent.us/okcity.center.php');
}



$current =  $_GET['ids'];

?>

<html>
<head>
	<link rel="shortcut icon" type="image/png" href="citycenter.png"/>
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-54T674M');</script>
	<!-- End Google Tag Manager -->
	<link rel="stylesheet" type="text/css" href="echoenergy-confirm.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="node_modules/croppie/croppie.css" />
	<script src="node_modules/croppie/croppie.js"></script>
	<script src="node_modules/exif-js/exif.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Courgette" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Meie+Script" rel="stylesheet">
	<meta property="fb:app_id" content="527400594366316" />
	<meta property="og:url" content="https://fervent.us/echoenergy-confirm.php?ids=<?=$current?>">
	<meta property="og:image:secure_url" content="https://fervent.us/images/<?=$current?>.png">
	<meta property="og:type" content="article" >
	<meta property="og:title" content="Be a part of something big right now!" >
	<meta property="og:description" content="Help Echo Energy and me increase safe places to play and feeding services to inner city youth by giving now to City Center. Once we get 1000 partners to give as little as $5, Echo Energy will donate $30,000 and fully fund food shortage programs at City Center. I am number <?=$current?>! WHAT'S YOUR NUMBER? #OKCfortheWYN @echoenergyco. https://fervent.us/okcity.center.php Follow this link to join!">
	<meta property="og:image" content="https://fervent.us/images/<?=$current?>.png" >
	<meta property="og:image:width" content="688" >
	<meta property="og:image:height" content="360" >
	<script src="https://js.stripe.com/v3/"></script>

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

	<script>
	function shareOverrideOGMeta(overrideLink, overrideTitle, overrideDescription, overrideImage)
	{
		FB.ui({
			method: 'share_open_graph',
			action_type: 'og.likes',
			action_properties: JSON.stringify({
				object: {
					'og:url': overrideLink,
					'og:title': overrideTitle,
					'og:description': overrideDescription,
					'og:image': overrideImage
				}
			})
		},
		function (response) {
		// Action after response
		});
	}
	</script>


</head>
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




	<div class="header">
		<h2 id="header1"> Thank you for your support! </h2>
		<h3 id="instructions"> Help grow the campaign by sharing on facebook! </br> Click the upload button to upload your own photo. </h3>

	</div>



	<div class="buttons">
		<div class="buttonBorder">
			<div class="initialUpload">
				<!--<input type="file" id="file" class="files" onchange="readURL(this)">-->
				<input type="file"  id="file" class="files" name="cameraInput" onchange="readURL(this)">
				<label for="file">
					<div class="uploadButton1">
						<i class="fa fa-upload" style="font-size:24px;border-radius:10px"></i>
					</div>
				</label>
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
		<p> Thanks to the generosity of Echo Energy, once 1,000 advocates give and share, Echo Energy will donate $30,000 to OKCityCenter.
	</div>

	<div class="ifError">
		<p> If you encounter any errors please contact info@okcity.center</p>
	</div>

	<div class="footer">
		<h4> Site Powered By Fervent </h4>
	</div>

	<div class="testholder" style="width:100%;display:none;">
		<div class="test" style="width:688;height:360;background-color:black;margin:auto;">
			<canvas id="myCanvas" height = '360' width = '688' ></canvas>
		</div>
	</div>

</div>
</body>

<script>



frame = '<img src="frame.png" id="frame" style="margin-top:247px;width:360px;"/>';

// set the viewport size
var basic = $('.cropHolder').croppie({
	enforceBoundary: true,
	enableExif: true,
    viewport: {
        width: 360,
        height: 360
    },

});

var idNumber = '<div id="number" style="text-align:left;width:100%;margin-top:-246px;margin-left:287px;position:relative;z-index:500;"> <p style="color:white;font-size:22px;margin-top:170px;margin-right:10px;font-family: Meie Scrip;font-style:italic;"> <?=$current ?>... </p> </div>'

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
img = 'blakegriffing.jpeg';





//bind the original image to croppie
basic.croppie('bind', {
    url: img,
});
$('.cr-boundary').append(frame);
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
	$('.fbShareButton').show();
	$('#fbicon').show();
	$('#instructions').html('Click The Facebook Icon To Share!'+'<br><br>'+'Suggested Post: '+'<br><br>'+'<span style="font-size:12px"> Help Echo Energy and me increase safe places to play and feeding services to inner city youth by giving now to City Center. Once we get 1000 partners to give as little as $5, Echo Energy will donate $30,000 and fully fund food shortage programs at City Center. I am number <?=$current?>! WHAT\'S YOUR NUMBER? #OKCfortheWYN @echoenergyco' + '<br><br>' + "https://fervent.us/okcity.center.php"+ '<br>' +  'Follow this link to join now!'+'</span>');


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
						ctx.fillText("<?=$current ?>...",452,305);
					var dataURL = c.toDataURL();
					$.ajax({
					    type: "POST",
					    url: 'uploads.php',
					    data: {
			     			imgBase64: dataURL,
								number: <?=$current?>
			  			},
					    success: function(){
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
