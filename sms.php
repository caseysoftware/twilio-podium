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
        foreach($subscribers as $subscriber) {
            sendMessage($subscriber, $twilioNumber, $body);
            $i++;
        }
        $body = "Your message was sent to $i subscribers";
    } else {
        $body = "You can't send an empty message to everyone. That's just rude!";
    }
    //NOTE: The variable is 'from' but this is who the message is sent *to*
    sendMessage($from, $twilioNumber, $body);

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

//TODO: convert to using the proper library response methods
header('Content-type: text/xml');
?>
<Response />