<?php
   // Get the PHP helper library from twilio.com/docs/php/install
   require "./twilio-php/Services/Twilio.php"; // Loads the library
   // Your Account Sid and Auth Token from twilio.com/user/account
   $AccountSid = "AC0afebea49d21b6c6066b393941bf7843";
   $AuthToken = "123";
   $client = new Services_Twilio($AccountSid, $AuthToken);
   
   // Loop over the list of messages and echo a property for each one
   echo "<table border='1'>";
   echo "<tr>";
   echo "<td>Sid</td><td>Date</td><td>From</td><td>To</td><td>Body</td><td>Status</td><td>Direction</td>";   
   echo "</tr>";   
     
   //https://www.twilio.com/docs/api/rest/message#list
   
   
   $response = $client->retrieveData("/2010-04-01/Accounts/AC0afebea49d21b6c6066b393941bf7843/Messages", 
           array(
               'Page' => '2',
               'PageSize' => '5'));
    
   print_r($response);
   
   foreach ($response->messages as $message) {
      echo "<tr>";      
      echo "<td>".$message->sid."</td>";
      echo "<td>".$message->date_created."</td>";
      echo "<td>".$message->from."</td>";
      echo "<td>".$message->to."</td>";
      echo "<td>".$message->body."</td>";
      echo "<td>".$message->status."</td>";
      echo "<td>".$message->direction."</td>";
      echo "</tr>";
   }
   echo "</table>";
   
