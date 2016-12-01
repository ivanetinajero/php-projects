<?php

   // Get the PHP helper library from twilio.com/docs/php/install
   require "./twilio-php/Services/Twilio.php"; // Loads the library
   
   // Your Account Sid and Auth Token from twilio.com/user/account
   $AccountSid = "AC0afebea49d21b6c6066b393941bf7843";
   $AuthToken = "123";
   $client = new Services_Twilio($AccountSid, $AuthToken);

   EXTRACT($_POST);
   EXTRACT($_GET);

   $page = $_GET['page']; // get the requested page
   $limit = $_GET['rows']; // get how many rows we want to have into the grid
   $sidx = $_GET['sidx']; // get index row - i.e. user click to sort
   $sord = $_GET['sord']; // get the direction   
   //https://www.twilio.com/docs/api/rest/message#list   
   $response = $client->retrieveData("/2010-04-01/Accounts/AC0afebea49d21b6c6066b393941bf7843/Messages", 
       array(
         'Page' => $page-1,
         'PageSize' => $limit)
       );
      
   header("Content-type: text/xml;charset=utf-8");

   if (!$sidx)
      $sidx = 1;

   $et = ">";
   echo "<?xml version='1.0' encoding='utf-8'?$et\n";
   echo "<rows>";
   echo "<page>" . $page . "</page>";
   echo "<total>" . $response->num_pages . "</total>";
   echo "<records>" . $response->total . "</records>";

   foreach ($response->messages as $message) {
      echo "<row id='" . $message->sid . "'>";
      echo "<cell><![CDATA[" . $message->sid . "]]></cell>";
      
      if ($message->direction == "inbound"){
         echo "<cell><![CDATA[<img src='images/answer.png'></img>]]></cell>";
      }   
      if ($message->direction == "outbound-reply"){
         echo "<cell><![CDATA[<img src='images/answeringMachine.png'></img>]]></cell>";
      }   
      if ($message->direction == "outbound-api"){
         echo "<cell><![CDATA[<img src='images/calling.png'></img>]]></cell>";      
      }  
      
      $dateRFC822 = new DateTime($message->date_created);
      
      echo "<cell><![CDATA[" . $dateRFC822->format('Y-m-d H:i') . "]]></cell>";
      echo "<cell><![CDATA[" . $message->from . "]]></cell>";
      echo "<cell><![CDATA[" . $message->to . "]]></cell>";
      echo "<cell><![CDATA[" . $message->body . "]]></cell>";
      echo "<cell><![CDATA[" . $message->status . "]]></cell>";   
      // Delete icon
      echo "<cell><![CDATA[<a href=\"javascript:deleteSms(" . $message->sid . ")\"><img src=images/delete.png border=0></a>]]></cell>";
       
      echo "</row>";
   }
   echo "</rows>";

