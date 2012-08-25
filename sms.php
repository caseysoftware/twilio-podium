<?php
include 'functions.php';

$from = $_POST['From'];
$from = preg_replace("/[^0-9]/", "", $from);
$subscribed = is_subscribed($from);

$body = $_POST['Body'];
$body = strtolower($body);
$body = preg_replace("/[^A-Za-z0-9]/", "", $body );
$keyword = substr($body, 0, 4);

switch ($keyword) {
    case 'stop':
        unsubscribe($from);
        break;
    case 'help':
        sendMessage($from, $twilioNumber, $messages['sms-help']);
        break;
    case 'prev':
    case 'next':
    case 'now':
        sendMessage($from, $twilioNumber, get_info_message($keyword));
        break;
    case 'join':
        subscribe($from);
        break;
    default:
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
            sendMessage($from, $twilioNumber, 'Sorry, I didn\t recognize that command. Please try again.');
        }
}

header('Content-type: text/xml');
?>
<Response />