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

$body = $_POST['Body'];
$message = '';

if (isset($whitelist[$from])) {
    $body .= (strlen($body) <= 156) ? ' ~'.$whitelist[$from] : '';
    $subscribers = get_subscribers();

    $i = 0;
    $client = new Services_Twilio($AccountSid, $AuthToken);
    foreach($subscribers as $number) {

//    $sms = $client->account->sms_messages->create(
//            $twilioNumber,
//$testNumber,
//            $body
//    );
        $i++;
    }
    $message = "Your message was sent to $i subscribers";

} else {
    $body = strtolower($body);
    $subscribed = is_subscribed($from);

    $stop = strpos($body, 'stop');
    if ($stop === false) {
        if ($subscribed) {
            $message = get_info_message();
        } else {
            subscribe($from);
            $message = 'Welcome to "podium" the php|tek 2012 text notification system powered by Twilio.';
        }
    } else {
        unsubscribe($from);
        $message = 'You have been opted out. To opt back in, send any message to this number';
    }
}

//header('Content-type: text/xml');
?>
<Response><?php echo $message; ?></Response>