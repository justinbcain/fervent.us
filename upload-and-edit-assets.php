<?php
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




## CREATE VARIABLES FOR EACH POST VARIABLE
foreach($_POST as $key => $value) {
  #leave the double $$
    $$key = mysqli_real_escape_string($conn,$value);
}

#CREATE FILENAME VARIABLES
foreach($_FILES as $key => $value){
  #check if filename is in the deleted values. Set img value to empty placeholder if true;
  strpos($deletedValues,$key) === FALSE ? $$key = $value['name'] : $$key = '#';
}



if(isset($_POST['testMode'])){
  $testMode = 1;
} else {
  $testMode = 0;
}



#
# GET ARRAY OF CURRENT CAMPAIGNS
# SEE IF POSTED CAMPAIGNNAME IS IN THE ARRAY
#

$preExisting = FALSE;
$sql = "SELECT campaignName FROM pageFormatting";
$query = mysqli_query($conn, $sql);
while($campaignRow = mysqli_fetch_assoc($query)){
 if($campaignName == $campaignRow['campaignName']){
   $preExisting = TRUE;
 }
}




#
#
#
# DELETE CAMPAIGNS
#
#
#




if(isset($_POST['delete'])){

  $sql = "DELETE FROM pageFormatting WHERE campaignName = '$campaignName'";
  $conn->query($sql);
  rmdir("/var/www/fervent.us/html/$campaignName-images");
  unlink("/var/www/fervent.us/html/$campaignName");

  $_SESSION['campaignName'] = 'New Campaign';

  header('Location:https://fervent.us/editor');

}









#
#
#
#UPDATE ALREADY EXISTING CAMPAIGNS
#
#
#



elseif($preExisting == TRUE){
  $sql = "UPDATE pageFormatting SET campaignName = '$campaignName',
                                    headerColor= '$headerColor',
                                    headerFontColor= '$headerFontColor',
                                    logo=IF(LENGTH('$logo')=0, logo, '$logo'),
                                    logoHeight= '$logoHeight',
                                    headline1='$headline1',
                                    headline2= '$headline2',
                                    backgroundImage=IF(LENGTH('$backgroundImage')=0, backgroundImage, '$backgroundImage'),
                                    placeholder1=IF(LENGTH('$placeholder1')=0, placeholder1, '$placeholder1'),
                                    placeholder2=IF(LENGTH('$placeholder2')=0, placeholder2, '$placeholder2'),
                                    placeholder3=IF(LENGTH('$placeholder3')=0, placeholder3, '$placeholder3'),
                                    placeholder4=IF(LENGTH('$placeholder4')=0, placeholder4, '$placeholder4'),
                                    placeholder5=IF(LENGTH('$placeholder5')=0, placeholder5, '$placeholder5'),
                                    placeholder6=IF(LENGTH('$placeholder6')=0, placeholder6, '$placeholder6'),
                                    placeholder7=IF(LENGTH('$placeholder7')=0, placeholder7, '$placeholder7'),
                                    placeholder8=IF(LENGTH('$placeholder8')=0, placeholder8, '$placeholder8'),
                                    placeholder9=IF(LENGTH('$placeholder9')=0, placeholder9, '$placeholder9'),
                                    placeholder10=IF(LENGTH('$placeholder10')=0, placeholder10, '$placeholder10'),
                                    miniFrame=IF(LENGTH('$miniFrame')=0, miniFrame, '$miniFrame'),
                                    boxColor = '$boxColor',
                                    boxFontColor = '$boxFontColor',
                                    boxButtonColor ='$boxButtonColor',
                                    boxButtonFontColor = '$boxButtonFontColor',
                                    videoLink = '$videoLink',
                                    copy =  '$copy',
                                    copyFontColor =  '$copyFontColor',
                                    stripeToken = '$stripeToken',
                                    stripeTokenSecret = '$stripeTokenSecret',
                                    stripeTestToken = '$stripeTestToken',
                                    stripeTestTokenSecret ='$stripeTestTokenSecret',
                                    defaultFrameImage = IF(LENGTH('$defaultFrameImage')=0, defaultFrameImage, '$defaultFrameImage'),
                                    fbTitle = '$fbTitle',
                                    fbDescription = '$fbDescription',
                                    suggestedPost ='$suggestedPost',
                                    donorNumberY =  '$donorNumberY',
                                    donorNumberX = '$donorNumberX',
                                    donorFontColor = '$donorFontColor',
                                    donorFontSize = '$donorFontSize',
                                    donorFontSelection =  '$donorFontSelection',
                                    testMode = $testMode
                                    WHERE campaignName = '$campaignName'";


$conn->query($sql);

    if(mysqli_error($conn)){
      echo mysqli_error($conn);
    } else {
      $conn->close();
      header("Location:https://fervent.us/$campaignName");
  }

} else {


#
#
#
#CREATE NEW CAMPAIGN!
#
#
#


  $sql = "INSERT INTO pageFormatting (campaignName,headerColor,headerFontColor,logo,logoHeight,headline1,
headline2,backgroundImage,placeholder1,placeholder2,placeholder3,placeholder4,placeholder5,placeholder6,placeholder7,
placeholder8,placeholder9,placeholder10,miniFrame,boxColor,boxFontColor,boxButtonColor,boxButtonFontColor,videoLink,
copy,copyFontColor,stripeToken,stripeTokenSecret,stripeTestToken,stripeTestTokenSecret,defaultFrameImage,fbTitle,
fbDescription,suggestedPost,testMode,donorNumberY,donorNumberX,donorFontColor,donorFontSize,donorFontSelection,frame)VALUES('$campaignName',
'$headerColor','$headerFontColor','$logo','$logoHeight','$headline1','$headline2','$backgroundImage','$placeholder1','$placeholder2',
'$placeholder3','$placeholder4','$placeholder5','$placeholder6','$placeholder7','$placeholder8','$placeholder9','$placeholder10',
'$miniFrame','$boxColor','$boxFontColor','$boxButtonColor','$boxButtonFontColor','$videoLink','$copy','$copyFontColor','$stripeToken',
'$stripeTokenSecret','$stripeTestToken','$stripeTestTokenSecret','$defaultFrameImage','$fbTitle','$fbDescription','$suggestedPost',
'$testMode','$donorNumberY','$donorNumberX','$donorFontColor','$donorFontSize','$donorFontSelection','$frame')";




  $conn->query($sql);





  #CREATE NEW PHP TEMPLATE PAGES
  $templateHomePage = 'homepagetemplate.php';
  $newHomePage = "$campaignName.php";
  $templateConfirmPage = 'confirmpagetemplate.php';
  $newConfirmPage = "$campaignName-confirm.php";
  $webhooktemplate = 'webhooktemplate.php';
  $newwebhook = "$campaignName-webhook.php";
  $testwebhooktemplate = 'test-webhooktemplate.php';
  $newtestwebhook = "$campaignName-test-webhook.php";

  if (!copy($templateHomePage, $newHomePage)) {
      #echo "failed to copy";
  }
  if (!copy($templateConfirmPage, $newConfirmPage)) {
      #echo "failed to copy";
  }
  if (!copy($webhooktemplate, $newwebhook)) {
      #echo "failed to copy";
  }
  if (!copy($testwebhooktemplate, $newtestwebhook)) {
      #echo "failed to copy";
  }

  mkdir("/var/www/fervent.us/html/$campaignName-images", 0777,TRUE);
  mkdir("/var/www/fervent.us/html/$campaignName-images/donors", 0777,TRUE);
  mkdir("/var/www/fervent.us/html/$campaignName-images/test-donors", 0777,TRUE);

}



foreach($_FILES as $key=>$value){



$tmp = $_FILES[$key]['tmp_name'];
$name = $_FILES[$key]['name'];
$path = "/var/www/fervent.us/html/$campaignName-images/$name";

move_uploaded_file($tmp, $path);


if(mysqli_error($conn)){
  echo mysqli_error($conn);
} else {
  $conn->close();
  header("Location:https://fervent.us/$campaignName");
}

}








?>
