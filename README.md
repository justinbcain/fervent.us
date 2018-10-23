# fervent.us

A PHP web app built on a LAMP stack.  

The campaign landing page takes donations through a stripe form. Payment info is processed on process.php. Upon succesful completion the user is sent to the confirmation page. The donor number increments when Stripe sends completed transaction to a webhook, which then updates the donor number in the database.  

On the confiramtion page the user can upload a custom image, where a frame is overlaid with the donor number.  Upon confirming their image, the frame and image are combined into a single image which is posted to the server by ajax to upload-images-with-frames.php. Facebook's Graph API is called through their JavaScript SDK and the Facebook bot crawls the page. It grabs the corresponding meta data to create a post for the user to then share on Facebook.

The image cropper on the confirmation page uses the croppie js tool. 

<strong>Creating New Campaigns: </strong>

Editor.php allows for new campaign creation.  Page formatting and campaign donor number are stored in the 'campaigns' database. upload-and-edit-assets.php creates and updates campaigns. 

When creating a new campaign editor spins up new instances of homepagetemplate, webhook, test-webhook, confirmationpage. Formatting values like background images and headers are saved to the database. 

The admin creating the campaign must integrate the new campaign with stripe before running a campaign or a test campaign. 




