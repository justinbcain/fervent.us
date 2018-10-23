<?php
session_start();

$name = $_POST['username'];
$pwerd = $_POST['password'];

if($name != 'cgreen@1211dev.com' && $pwerd != 'Redbud4216!' && $_SESSION['signedIn'] != 1 && !isset($_COOKIE['signedIn'])){
  header('Location: https://fervent.us/editor-login.php');
} else {
  $_SESSION['signedIn'] = 1;
  setcookie("signedIn", 1);
}

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




if(isset($_POST['campaignName'])){
  $campaignSelection = $_POST['campaignName'];
} elseif(isset($_SESSION['campaignName'])){
  $campaignSelection = $_SESSION['campaignName'];
} else {
  $campaignSelection = 'New Campaign';
}



if(isset($campaignSelection)){
  $sql = "SELECT * FROM pageFormatting WHERE campaignName = '$campaignSelection'";
} else {
  $sql = "SELECT * FROM pageFormatting WHERE id = '1'";
}




$result = $conn->query($sql);

$row = $result->fetch_assoc();

#check if the testMode is engaged
$checked = '';

if($row['testMode']==1){
  $checked = 'checked';
}






?>

<html>

<head>
<link href="editor.css" type="text/css" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
  <!-- Rounded switch -->



<!-- let user know if duplicate campaign was submitted -->
<?php

if(isset($_SESSION['duplicate'])){
  echo '<h3 style="color:red"> Campaign Already Exists </h3>';
  session_destroy();
}


?>

<h1><?=$campaignSelection?></h1>



<div class="box">
<h2> Select Campaign </h2>
<form action="editor.php" method="POST">



<?php
#posts back to the editor page with selection

$sql = "SELECT campaignName FROM pageFormatting";
$query = mysqli_query($conn, $sql);

#create campaign selector dropdown
if($query) {
    echo '<select name="campaignName" id="selectCampaignName" onchange="this.form.submit()">';
    while($campaignRow = mysqli_fetch_assoc($query)){
      $indexedCampaign = $campaignRow['campaignName'];
      //echo $campaignRow['campaignName'].'<br>';
        if($indexedCampaign == $campaignSelection){

            echo "<option selected='selected'>$indexedCampaign</option>";


        } else {
            echo "<option>$indexedCampaign</option>";
        }
    }
    if($campaignSelection == 'New Campaign'){
        echo "<option selected='selected'>New Campaign</option>";
    } else {
        echo "<option>New Campaign</option>";
    }
    echo "</select>";

}

if($campaignSelection == 'New Campaign'){
  $required = 'required';
} else {
  $required = '';
}


isset($row['logoHeight']) ? $logoHeight = $row['logoHeight'] : $logoHeight = '150px';
isset($row['headline1']) ? $headline1 = $row['headline1'] : $headline1 = 'This is the first banner headline';
isset($row['headline2']) ? $headline2 = $row['headline2'] : $headline2 = 'This is the second banner headline';
isset($row['copy']) ? $copy = $row['copy'] : $copy = 'Text at the bottom of the page: Thanks to our sponsor this campaign will donate...';
isset($row['fbTitle']) ? $fbTitle = $row['fbTitle'] : $fbTitle = 'The title of the Facebook post: Help Feed The Children';
isset($row['fbDescription']) ? $fbDescription = $row['fbDescription'] : $fbDescription = 'Description of the facebook post: This awesome campaign is to help inner city kids...';
isset($row['suggestedPost']) ? $suggestedPost = $row['suggestedPost'] : $suggestedPost = 'Suggested post for the user: I just took part in this great campaign and so can you...';
isset($row['donorFontColor']) ? $donorFontColor = $row['donorFontColor'] : $donorFontColor = '#000000';
isset($row['donorFontSize']) ? $donorFontSize = $row['donorFontSize'] : $donorFontSize = '40';
isset($row['donorFontSelection']) ? $donorFontSelection = $row['donorFontSelection'] : $donorFontSelection = 'Arial';
isset($row['donorNumberX']) ? $donorNumberX = $row['donorNumberX'] : $donorNumberX = '100';
isset($row['donorNumberY']) ? $donorNumberY = $row['donorNumberY'] : $donorNumberY = '100';



$conn->close();
?>
</form>

</div>

	<form action="upload-and-edit-assets.php" method="POST" enctype="multipart/form-data">



    <div class="box" id="newCampaign">
      <h2> Name the campaign </h2>
      <p> This is how the url will appear. All lower case. No spaces or special characters. Don't use a file extension like .html or .php </p>
      <p> ex. freethestates, feedthechildren, cityrescuemission, etc. </p>
      <label> https://fervent.us/ </label>
      <input name="campaignName" id="newCampaignName" type="text" placeholder="mynewcampaign" onchange="campaignSelection();" oninput="updateWebHookExample();" <?=$required?>>
    </div>

    <input id="campaignNameHolder" name="campaignName" value="<?$_POST['campaignName']?>" type="hidden">




    <div class="box" id="campaignStatus">
      <h2> Campaign Status </h2>




      <p id="testCount"> Current test donor number = <?=$row['testDonorCount']-1?> </p>
      <p id="liveCount"> Current donor number = <?=$row['donorCount']-1?>  </p>
      <?php echo $row['campaignName'];?>
      <p id="liveImages"> <a href="https://fervent.us/<?=$campaignSelection?>-images/donors">view current live mode images</a></p>
      <p id="testImages"> <a href="https://fervent.us/<?=$campaignSelection?>-images/test-donors">view current test mode images</a></p>

    </div>

    <div class='box'>
      <h2> Engage test mode? </h2>
      <p> This will use stripe test keys and will use a different donor counter and link for facebook </p>
      <div class="onoffswitch">
          <input type="checkbox" name="testMode" id="testMode" class="onoffswitch-checkbox" <?=$checked?> onchange="displayCounter();">
          <label class="onoffswitch-label" for="testMode">
              <span class="onoffswitch-inner"></span>
              <span class="onoffswitch-switch"></span>
          </label>
      </div>
    </div>



		<div class="box">
			<h2> Edit the Banner </h2>
			<p> select a color for the header banner </p>
			<input type="color" id="headerColor" name="headerColor" value="<?=$row["headerColor"]?>">
			<p> select font color </p>
			<input type="color" name="headerFontColor" value="<?=$row["headerFontColor"]?>">
			<p> upload the logo </p>
      <p>*keep logo file smaller for faster performance</p>
			<input type='file' id="logo" name = "logo" value='<?$row["logo"]?>' onchange="readURL(this)" onClick="get_id(this.id)">
			<img class="imageHolder" id="logoImage" src="<?=$row['campaignName'].'-images/'.$row["logo"]?>"><br>
      <div><button class="deletePlaceholder" onclick="event.preventDefault();removeImage('logo');">Delete</button></div>
			<p> set logo max height </p>
			<input type='text' id="logoHeight" name='logoHeight' value='<?=$logoHeight?>'><br>
			<p> Enter the banner text </p>
			<div><input type="text" class="long" id="headline1" name="headline1" value="<?=$headline1?>"/></div>
			<div><input type="text" class="long" id="headline2" name="headline2" value ="<?=$headline2?>"/></div>
		</div>

		<div class="box">
			<h2>Background Image </h2>
			<input type="file" name="backgroundImage" id="backgroundImage" onchange="readURL(this)" onClick="get_id(this.id)">
			<img class="imageHolder" id="backgroundImageImage" src="<?=$row[campaignName].'-images/'.$row["backgroundImage"]?>">
      <div><button class="deletePlaceholder" onclick="event.preventDefault();removeImage('backgroundImage');">Delete</button></div>
		</div>

		<div class="box">
			<h2> Small Preview Frames </h2>
			<p> upload image placeholders. use 200px x 200px images </p>
			<input type='file' name="placeholder1" id="placeholder1" label='Upload Placeholder Image' onchange="readURL(this)" onClick="get_id(this.id)">
			<img class="imageHolder" id="placeholder1Image" src="<?=$row['campaignName'].'-images/'.$row["placeholder1"]?>"><br>
      <div><button class="deletePlaceholder" onclick="event.preventDefault();removeImage('placeholder1');">Delete</button></div>
			<input type='file' name="placeholder2" id="placeholder2" label='Upload Placeholder Image' onchange="readURL(this)" onClick="get_id(this.id)">
			<img class="imageHolder" id="placeholder2Image" src="<?=$row['campaignName'].'-images/'.$row["placeholder2"]?>"><br>
      <div><button class="deletePlaceholder" onclick="event.preventDefault();removeImage('placeholder2');">Delete</button></div>
			<input type='file' name="placeholder3" id="placeholder3" label='Upload Placeholder Image' onchange="readURL(this)" onClick="get_id(this.id)">
			<img class="imageHolder" id="placeholder3Image" src="<?=$row['campaignName'].'-images/'.$row["placeholder3"]?>"><br>
      <div><button class="deletePlaceholder" onclick="event.preventDefault();removeImage('placeholder3');">Delete</button></div>
			<input type='file' name="placeholder4" id="placeholder4" label='Upload Placeholder Image' onchange="readURL(this)" onClick="get_id(this.id)">
			<img class="imageHolder" id="placeholder4Image" src="<?=$row['campaignName'].'-images/'.$row["placeholder4"]?>"><br>
      <div><button class="deletePlaceholder" onclick="event.preventDefault();removeImage('placeholder4');">Delete</button></div>
			<input type='file' name="placeholder5" id="placeholder5" label='Upload Placeholder Image' onchange="readURL(this)" onClick="get_id(this.id)">
			<img class="imageHolder" id="placeholder5Image" src="<?=$row['campaignName'].'-images/'.$row["placeholder5"]?>"><br>
      <div><button class="deletePlaceholder" onclick="event.preventDefault();removeImage('placeholder5');">Delete</button></div>
			<input type='file' name="placeholder6" id="placeholder6" label='Upload Placeholder Image' onchange="readURL(this)" onClick="get_id(this.id)">
			<img class="imageHolder" id="placeholder6Image" src="<?=$row['campaignName'].'-images/'.$row["placeholder6"]?>"><br>
      <div><button class="deletePlaceholder" onclick="event.preventDefault();removeImage('placeholder6');">Delete</button></div>
			<input type='file' name="placeholder7" id="placeholder7" label='Upload Placeholder Image' onchange="readURL(this)" onClick="get_id(this.id)">
			<img class="imageHolder" id="placeholder7Image" src="<?=$row['campaignName'].'-images/'.$row["placeholder7"]?>"><br>
      <div><button class="deletePlaceholder" onclick="event.preventDefault();removeImage('placeholder7');">Delete</button></div>
			<input type='file' name="placeholder8" id="placeholder8" label='Upload Placeholder Image' onchange="readURL(this)" onClick="get_id(this.id)">
			<img class="imageHolder" id="placeholder8Image" src="<?=$row['campaignName'].'-images/'.$row["placeholder8"]?>"><br>
      <div><button class="deletePlaceholder" onclick="event.preventDefault();removeImage('placeholder8');">Delete</button></div>
			<input type='file' name="placeholder9" id="placeholder9" label='Upload Placeholder Image' onchange="readURL(this)" onClick="get_id(this.id)">
			<img class="imageHolder" id="placeholder9Image" src="<?=$row['campaignName'].'-images/'.$row["placeholder9"]?>"><br>
      <div><button class="deletePlaceholder" onclick="event.preventDefault();removeImage('placeholder9');">Delete</button></div>
			<input type='file' name="placeholder10" id="placeholder10" label='Upload Placeholder Image' onchange="readURL(this)" onClick="get_id(this.id)">
			<img class="imageHolder" id="placeholder10Image" src="<?=$row['campaignName'].'-images/'.$row["placeholder10"]?>"><br>
      <div><button class="deletePlaceholder" onclick="event.preventDefault();removeImage('placeholder10');">Delete</button></div>
			<p> upload frame placeholder. use 200px x 200px image </p>
			<input type='file' name="miniFrame" id="miniFrame" label='Upload Placeholder Image'onchange="readURL(this)" onClick="get_id(this.id)">
			<img class="imageHolder" id="miniFrameImage" src="<?=$row['campaignName'].'-images/'.$row["miniFrame"]?>"><br>
      <div><button class="deletePlaceholder" onclick="event.preventDefault();removeImage('miniFrame');">Delete</button></div>
		</div>

		<div class="box">
			<h2> Edit the donation box </h2>
			<p>donation box main color</p>
			<input type="color" id="boxColor" name="boxColor" value="<?=$row["boxColor"]?>"><br>
			<p>box font color</p>
			<input type="color" id="boxFontColor" name="boxFontColor" value="<?=$row["boxFontColor"]?>"><br>
			<p>button main color</p>
			<input type="color" id="boxButtonColor" name="boxButtonColor" value="<?=$row["boxButtonColor"]?>"><br>
			<p>button font color</p>
			<input type="color" id="boxButtonFontColor" name="boxButtonFontColor" value="<?=$row["boxButtonFontColor"]?>"><br>

		</div>


		<div class="box">
			<h2> paste the video link</h2>
			<input class="long" type='text' name="videoLink" id="videoLink" value='<?=$row["videoLink"]?>'><br>
      <p> Copy a youtube copying the url in the address bar when you're viewing the video </p>
      <p> when inserting add '/embed/' in between youtube.com and the video id </p>
      <p> https://www.youtube.com/watch?v=M8KmqaJvgpE <br> becomes <br>https://wwww.youtube.com<span style="background-color:yellow;">/embed/</span>M8KmqaJvgpE </p>
      <p> https://www.youtube.com/zcGOoDThC1E <br>becomes<br> https://www.youtube.com<span style="background-color:yellow;">/embed/</span>zcGOoDThC1E </p>
		</div>

		<div class="box">
			<h2> Text at the bottom of the page </h2>
			<input type="text" class="long" name="copy" id="copy" value ="<?=$copy?>"/>
			<p> select font color for the text</p>
			<input type="color" id ="copyFontColor" name="copyFontColor" value="<?=$row["copyFontColor"]?>"><br>

		</div>

		<div class="box">
			<h2> Enter The stripe key </h2>
      <p> Get these keys from the stripe dashboard under developers </p>
      <p> Click "view test data" to get the test keys </p>
      <br>
      <p> Publishable Test Key </p>
			<input type="text" class="long"  name="stripeTestToken" id="stripeTestToken" value="<?=$row['stripeTestToken']?>">
      <p> Secret Test Key </p>
			<input type="text" class="long"  name="stripeTestTokenSecret" id="stripeTestTokenSecret" value="<?=$row['stripeTestTokenSecret']?>">
      <p> Publishable Live key </p>
			<input type="text" class="long"  name="stripeToken" id="stripeToken" value="<?=$row['stripeToken']?>">
      <p> Secret Live key </p>
			<input type="text" class="long"  name="stripeTokenSecret" id="stripeTokenSecret" value="<?=$row['stripeTokenSecret']?>">

      <br>
      <p> Use card number 4242 4242 4242 4242 for testing </p>
		</div>

    <div class="box">
      <h2> Create The Facebook Post </h2>
      <p> Facebook Post TItle </p>
      <input type="text" name="fbTitle" class="long" id="fbTitle" value="<?=$fbTitle?>">
      <p> Facebook Post Description </p>
      <input type="text" class="long"  name="fbDescription" id="fbDescription" value="<?=$fbDescription?>">
      <p> Suggested Post </p>
      <input type="text" class="long"  name="suggestedPost" id="suggestedPost" value="<?=$suggestedPost?>">
    </div>

    <div class="box">
      <h2>  Frame Set Up </h2>
      <p> Default Background Image For The Frame </p>
      <input type="file" name="defaultFrameImage" id="defaultFrameImage" onchange="readURL(this)" onClick="get_id(this.id)">
      <img class="imageHolder" id="defaultFrameImageImage" src="<?=$row[campaignName].'-images/'.$row["defaultFrameImage"]?>">
      <div><button class="deletePlaceholder" onclick="event.preventDefault();removeImage('defaultFrameImage');">Delete</button></div>

      <p> The Frame: <span style="font-weight:bold;"> Use an image that is 635 pixels wide by 202 pixels high</span> </p>
      <input type="file" name="frame" id="frame" onchange="readURL(this);" onClick="get_id(this.id)">
      <img class="imageHolder" id="frameImage" style="width:100px;height:32px;" src="<?=$row[campaignName].'-images/'.$row["frame"]?>">
      <div><button class="deletePlaceholder" onclick="event.preventDefault();removeImage('frame');">Delete</button></div>
      <!--<button id="setCoords"  onclick ="event.preventDefault();setTheCoords();" >Place Donor Number *not ready</button>-->




      <!--<button id="exit" onclick="event.preventDefault();closePopUp();">X</button>-->
      <!--<p id="instruct"> Click to place the number </p>-->
      <div>
          <button  id="setCanvas" onclick="event.preventDefault();showCanvas();"> Edit & Place The Donor Number </button>
      </div>


      <div id="canvasHolder">
        <p id="canvasInstruct"> Click on the frame place the number </P>
        <canvas id="myCanvas"></canvas>

        <div id="donorNumberRow">


            <div id="fontSelectorBox">
              <p>Select Font</p>
                <?php
                $fonts = ['Lucida Console','Georgia','Palatino Linotype','Times New Roman','Arial','Arial Black','Comic Sans MS','Impact','Lucida Sans Unicode','Tahoma','Trebuchet MS','Verdana','Courier New'];
                echo '<select id="donorFontSelection" name="donorFontSelection" onchange="selectFont();">';
                for($x = 0; $x < count($fonts);$x++){
                    $fonts[$x] == $donorFontSelection ? $selected = 'selected = "selected"' : $selected = "";
                    echo '<option '.$selected.'style="font-family:'.$fonts[$x].';">'."$fonts[$x]".'</option>';
                }
                echo '</select>';
                ?>
            </div>
            <div id="fontSizeBox">
              <p>Number Size </p>
              <input type="range" id ="donorFontSize" min='5' max='100' name="donorFontSize" oninput="selectFont();" value="<?=$donorFontSize?>">
            </div>


            <div id="fontColorBox">
              <p>Number Color </p>
              <input type="color" id ="donorFontColor" name="donorFontColor"  oninput ="selectFont();" value="<?=$donorFontColor?>">
            </div>
          </div>
          <div style="text-align:center;margin:auto;width:400px;">
            <p> Or Enter X & Y Value To Change Position </p>
            <input type="number" oninput="selectFont();" label = 'X Position' name="donorNumberX" id="donorNumberX" value=<?=$donorNumberX?>>
            <input type="number" oninput="selectFont();" label = 'Y Position' name="donorNumberY" id="donorNumberY" value=<?=$donorNumberY?>>
          </div>
        <!--<div id="saveButtonRow">
          <button id="save" onclick="event.preventDefault();closePopUp();saveFrame();">Save</button>
        </div>-->
      </div>


      </div>




    </div>



      <div class="box" id="webhookBox" <?php echo $campaignSelection != 'New Campaign' ?  'style="display:none"' : ''; ?>>
        <h2> Set Up Webhooks On Stripe</h2>
        <p> This is what allows the donor count to go up </p>
        <p> Click 'webhooks' under the developers tab and add endpoint </p>
        <a href="https://fervent.us/webhook1.png">Step 1 </a>
        <p> Add the address as https://fervent.us/<span id="webhookurl1">{campaign name here}</span>-webhook.php </p>
        <p> Insert the current campaign name in the address </p>
        <p> and select charge.succeeded as the event </p>
        <a href="https://fervent.us/webhook2.png">Step 2 </a>
        <p> Repeat the steps above with 'View Test Data' turned on </p>
        <p> Add the address for the test webhook https://fervent.us/<span id="webhookurl2">{campaign name here}</span>-test-webhook.php </p>
      </div>

      <div class="box" id="webhookcheck" <?php echo $campaignSelection == 'New Campaign' ?  'style="display:none"' : ''; ?>>
        <p> Did you set up the webhook? </p>
        <button id="seenwebhook" onclick="event.preventDefault();showWebhookBox();"> No </button>
        <button id="yessssButton" onclick="event.preventDefault();showYes();"> Yes </button>
      </div>

      <input type="hidden" name="deletedValues" id="deletedValues">




		<button type='submit' name="submit" id="submit" class="animate"><h2>Update</h2></button>


	</form>


  <form id="deleteForm" action="upload-and-edit-assets.php" method="POST"  onsubmit="event.preventDefault();">
    <input type="hidden" name="campaignName" value="<?=$_POST['campaignName']?>">
    <input type="hidden" name="delete" value="delete">
    <div>
      <button id="delete" onclick="deleteCampaign()" class="animate"><h2>Delete Campaign</h2></button>
    </div>
  </form>



<script type="text/javascript"  src="editor.js"></script>
<script>

function pageSetUp() {
  if('<?=$campaignSelection?>' !== 'New Campaign'){
    newCampaign.style.display = 'none';
  } else {
    campaignStatus.style.display="none";
  }
  displayCounter();
  campaignSelection();
}
window.onload = pageSetUp();

</script>

</body>

</html>
