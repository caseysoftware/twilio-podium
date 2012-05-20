<?php
/*
 * The creds.php file sets values for these variables:
 *      $AccountSid, $AuthToken, $whitelist,  $twilioNumber, $testNumber,
 *      $dbhost, $dbuser, $dbpass, $dbname
 * There is no business logic or other code within it.
 */
include 'creds.php';
include 'functions.php';
include 'Services/Twilio.php';

$from = $_POST['From'];
$from = preg_replace("/[^0-9]/", "", $from);

$subscribed = is_subscribed($from);
if ($subscribed) {
    $optmsg = "You are currently opted in to receive text notifications. Press 9 or text STOP to opt out.";
} else {
    $optmsg = "You are not opted in to receive text notifications. Press 1 or send a text to this number to opt in.";
}

header('Content-type: text/xml');
?>
<Response>
    <Gather action="gather.php" numDigits="1">
        <Say>Hello. You've reached the P H P tech 2012 text notification system powered by Twilio.</Say>
        <Say><?php echo $optmsg; ?></Say>
    </Gather>
</Response>