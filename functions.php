<?php
/**
 * The creds.php file sets values for these variables:
 *      $AccountSid, $AuthToken, $whitelist,  $twilioNumber, $testNumber,
 *      $dbhost, $dbuser, $dbpass, $dbname
 * There is no business logic or other code within it.
 */
include 'creds.php';
include 'vendor/autoload.php';
include 'vendor/eventbrite/eventbrite.php';


$link = new PDO('sqlite:messaging.sqlite3');
$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$link->exec("CREATE TABLE IF NOT EXISTS subscribers (
                            id INTEGER PRIMARY KEY,
                            phone TEXT,
                            status INT(1))");

function is_subscribed($phone) {
    $phone = preg_replace("/[^0-9]/", "", $phone );

    $sql = "SELECT * FROM subscribers WHERE phone = '$phone' AND status = 1";
    $result = mysql_query($sql);

    return mysql_num_rows($result);
}

function get_subscribers() {
    $subscribers = array();
    $sql = "SELECT DISTINCT(phone) FROM subscribers WHERE status = 1";
    $results = mysql_query($sql);

    while ($row = mysql_fetch_assoc($results)) {
        $subscribers[$row['phone']] = $row['phone'];
    }

    return $subscribers;
}

function subscribe($phone) {
    global $twilioNumber, $messages;
    $phone = preg_replace("/[^0-9]/", "", $phone );

    $sql = "INSERT INTO subscribers (phone, status, opt_in) VALUES ('$phone', 1, NOW())";
    $result = mysql_query($sql);

    $body = $messages['sms-subscribe'];
    sendMessage($phone, $twilioNumber, $body);
}

function unsubscribe($phone) {
    global $twilioNumber, $messages;
    $phone = preg_replace("/[^0-9]/", "", $phone );

    $sql = "UPDATE subscribers SET status = 0, opt_out = NOW() WHERE phone = '$phone'";
    $result = mysql_query($sql);

    $body = $messages['sms-unsubscribe'];
    sendMessage($phone, $twilioNumber, $body);
}

/**
 * NOTE: Although we feed the parameters into the function with "to" first and
 *   "from" second, the sms_messages->create() method takes the "from" first
 *   and the "to" second.
 */
function sendMessage($to, $from, $body) {
    global $AccountSid, $AuthToken;

    $client = new Services_Twilio($AccountSid, $AuthToken);
    $sms = $client->account->sms_messages->create(
            $from,
            $to,
            $body
    );
}

function get_info_message($keyword) {
    $hours = date('H');
    $minutes = date('i');
    
    $current_time = 60*$hours + $minutes;
    if ('prev' == $keyword) {
        $current_time -= 60;
    }
    if ('next' == $keyword) {
        $current_time += 60;
    }

    return 'This is not yet implemented';
}