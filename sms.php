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
    if ($body != '') {
        $body .= (strlen($body) <= 156) ? ' ~'.$whitelist[$from] : '';
        $subscribers = get_subscribers();

        $i = 0;
        $client = new Services_Twilio($AccountSid, $AuthToken);
        foreach($subscribers as $subscriber) {

            $sms = $client->account->sms_messages->create(
                    $twilioNumber,
                    $subscriber,
                    $body
            );
            $i++;
        }
        $message = "Your message was sent to $i subscribers";
    } else {
        $message = "You can't send an empty message to everyone. That's just rude!";
    }

} else {
    $body = strtolower($body);
    $subscribed = is_subscribed($from);

    $stop = strpos($body, 'stop');
    if ($stop === false) {
        if ($subscribed) {
            $message = get_info_message();
        } else {
            subscribe($from);
            $message = 'You are now opted into "Podium" the php|tek 2012 text notification system powered by Twilio. Send STOP to opt out at any time';
        }
    } else {
        unsubscribe($from);
        $message = 'You have been opted out of Podium. To opt back in, send any message to this number';
    }
}

header('Content-type: text/xml');
?>
<Response><Sms><?php echo $message; ?></Sms></Response>