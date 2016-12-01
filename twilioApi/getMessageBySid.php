<?php

// https://www.twilio.com/docs/api/rest/message

// Get the PHP helper library from twilio.com/docs/php/install
require "./twilio-php/Services/Twilio.php"; // Loads the library
// Your Account Sid and Auth Token from twilio.com/user/account
$AccountSid = "AC0afebea49d21b6c6066b393941bf7843";
$AuthToken = "123";
$client = new Services_Twilio($AccountSid, $AuthToken);
// Get an object from its sid. If you do not have a sid,
// check out the list resource examples on this page
$message = $client->account->messages->get("SMc339553c70de90db524e14dbb4753fa7");
echo $message->body;
print_r($message);
