<?php

/*
 * The creds.php file sets values for these variables:
 *      $AccountSid, $AuthToken, $whitelist,  $twilioNumber, $testNumber,
 *      $dbhost, $dbuser, $dbpass, $dbname
 * There is no business logic or other code within it.
 */

$AccountSid = 'ACxxxx';
$AuthToken  = 'abcdef';

/*
 * Outbound phone number
 */
$twilioNumber = '15125551212';

/*
 * This array consists of 'phonenumber' => 'initials'  Whenever someone sends
 *   a message in from one of these numbers, if there is room, the initials are
 *   appended and the message is rebroadcast to all active subscribers.
 * 
 * To subscribe these numbers to the service, you must enter them directly
 *   into the database or have the user place a voice call into the number.
 */
$whitelist = array('12025551212' => 'mr', '13015551212' => 'zw', 
                    '15125551212' => 'hw', '17035551212' => 'is', 
                    '18125551212' => 'jc', '18155551212' => 'kf');

$dbhost = 'database-host';
$dbuser = 'database-user';
$dbpass = 'database-pass';
$dbname = 'database-name';

$messages = array();
$messages['event']              = 'php|tek 2012';
$messages['event-phonetic']     = 'P H P tech 2012';
$messages['sms-subscribe']      = 'You are now opted into "Podium" the '.$messages['event'].' text notification system powered by Twilio. Send STOP to opt out at any time';
$messages['sms-unsubscribe']    = 'You have been opted out of Podium. To opt back in, send any message to this number';

$messages['voice-welcome']      = "Hello. You've reached the ".$messages['event-phonetic']." notification system powered by Twilio.";
$messages['voice-status-in']    = "You are currently opted into the text message notification system for ".$messages['event-phonetic'].". Press 9 or text STOP to opt out.";
$messages['voice-status-out']   = "You are not opted in to receive text updates about ".$messages['event-phonetic'].". Press 1 or send a text to this number to opt in.";

$messages['voice-subscribe']    = 'You are now opted into the '.$messages['event-phonetic'].' text notification system powered by Twilio. You will now receive text updates as they become available. Goodbye.';
$messages['voice-unsubscribe']  = 'You have been opted out of '.$messages['event-phonetic'].' notification system. To opt back in, send any message to this number. Goodbye.';
$messages['voice-noclue']       = "I'm sorry, I didn't understand that option. Let's try again.";