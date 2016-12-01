<?php
   require "./twilio-php/Services/Twilio.php";
   
   // set your AccountSid and AuthToken from www.twilio.com/user/account
   $AccountSid = "AC0afebea49d21b6c6066b393941bf7843";
   $AuthToken = "123";
   $client = new Services_Twilio($AccountSid, $AuthToken);
   try {
      $message = $client->account->messages->create(array(
         "From" => "+14843342829",// my trial number
         "To" => "+524921445609", // itinajero phone
         "Body" => "Hola Ivan. ¿Que hiciste en la materia de Proyecto con la Industria el día de ayer?",
      ));      
      // Display a confirmation message on the screen
      echo "Sent message Sid={$message->sid}";
      
   } catch (Services_Twilio_RestException $e) {
      echo $e->getMessage();
   } 
 
