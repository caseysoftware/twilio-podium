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