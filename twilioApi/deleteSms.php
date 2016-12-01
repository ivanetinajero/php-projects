<?php

   // Get the PHP helper library from twilio.com/docs/php/install
   require "./twilio-php/Services/Twilio.php"; // Loads the library
   
   // Your Account Sid and Auth Token from twilio.com/user/account
   $AccountSid = "AC0afebea49d21b6c6066b393941bf7843";
   $AuthToken = "123";
   $client = new Services_Twilio($AccountSid, $AuthToken);

   $sid = $_POST['sid']; // sid to delete
   
   // REST API delete  
   //$response = $client->deleteData("/2010-04-01/Accounts/AC0afebea49d21b6c6066b393941bf7843/$sid",  array( ));

   // Go back to grid
   header('Location: index.php?deleted=1');
?>

