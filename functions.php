<?php
/*
 * The creds.php file sets values for these variables:
 *      $AccountSid, $AuthToken, $whitelist,  $twilioNumber, $testNumber,
 *      $dbhost, $dbuser, $dbpass, $dbname
 * There is no business logic or other code within it.
 */
include 'creds.php';
include 'Services/Twilio.php';

$link = mysql_connect($dbhost, $dbuser, $dbpass);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

$db_selected = mysql_select_db($dbname, $link);
if (!$db_selected) {
    die ("Can't use $dbname : " . mysql_error());
}

function is_subscribed($phone) {
    $sql = "SELECT * FROM subscribers WHERE phone = '$phone'";
    $result = mysql_query($sql);

    return mysql_num_rows($result);
}

function get_subscribers() {
    $subscribers = array();
    $sql = "SELECT DISTINCT(phone) FROM subscribers WHERE status = 1";
    $results = mysql_query($sql);

    while ($row = mysql_fetch_assoc($results)) {
        $subscribers[] = $row['phone'];
    }

    return $subscribers;
}

function subscribe($phone, $twilioNumber) {
    $sql = "INSERT INTO subscribers (phone, status, opt_in) VALUES ('$phone', 1, NOW())";
    $result = mysql_query($sql);

    $body = 'You are now opted into "Podium" the php|tek 2012 text notification system powered by Twilio. Send STOP to opt out at any time';
    sendMessage($phone, $twilioNumber, $body);
}

function unsubscribe($phone, $twilioNumber) {
    $sql = "UPDATE subscribers SET status = 0, opt_out = NOW() WHERE phone = '$phone'";
    $result = mysql_query($sql);

    $body = 'You have been opted out of Podium. To opt back in, send any message to this number';
    sendMessage($phone, $twilioNumber, $body);
}

/*
 * NOTE: Although we feed the parameters into the function with "to" first and
 *   "from" second, the sms_messages->create() method takes the "from" first
 *   and the "to" second.
 */
function sendMessage($to, $from, $body) {
    $client = new Services_Twilio($AccountSid, $AuthToken);
    $sms = $client->account->sms_messages->create(
            $from,
            $to,
            $body
    );
}

function get_info_message($twilioNumber) {
    //TODO: get timestamp
    //TODO: adjust for timezone
    //TODO: get data for timeslot
    $message = 'TODO: get_info_message()';

    return $message;
}