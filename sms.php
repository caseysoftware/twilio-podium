<?php
include 'functions.php';

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
            $message = get_info_message($twilioNumber);
        } else {
            subscribe($from, $twilioNumber);
        }
    } else {
        unsubscribe($from, $twilioNumber);
    }
}

header('Content-type: text/xml');
?>
<Response />