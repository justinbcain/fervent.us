# fervent.us

A PHP web app built on a LAMP stack.  

The campaign landing page takes donations through a stripe form. Upon succesful completion the user is sent to the confirmation page. Stripe increments the donor number by sending the completed transaction to a webhook, which then updates the donor number in the database.  

On the confiramtion page the user can upload a custom image, where a frame is overlaid.  Upon confirming their image, the frame and image are combined into a single image which is posted to the server. Facebook's Graph API is called through their JavaScript SDK and the Facebook bot crawls the page. It grabs the corresponding meta data to create a post for the user to then share on Facebook.

Creating New Campaigns: 

Editor.php allows for new campaign creation.  Page formatting and campaign donor number are stored in the 'campaigns' database. 

When creating a new campaign editor spins up new instances of homepagetemplate, webhook, test-webhook, confirmationpage. Formatting values like background images and headers are saved to the database. 

The admin creating the campaign must integrate the new campaign with stripe before running a campaign or a test campaign. 




