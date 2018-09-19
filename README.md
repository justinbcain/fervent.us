# fervent.us
User flow goes: okcity.center.php > process.php > echoenergy-confirm.php. 
Process.php creates a charge, which then causes stripe to call webhook-incrementer.php via a webhook. 
Uploads.php posts the user's uploaded image with frame overlaid to the server. 
As of today (9/19) the webhook-incrementer looks to be counting correctly after setting it up last night. 
However, there are only a few transactions.

Check out https://fervent.us/okcity.center2.php for a test flow.  
Use card number 4242 4242 4242 4242 with filler data for testing .
