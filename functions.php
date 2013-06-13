<?php
/*
 * The creds.php file sets values for these variables:
 *      $AccountSid, $AuthToken, $whitelist,  $twilioNumber, $testNumber,
 *      $dbhost, $dbuser, $dbpass, $dbname
 * There is no business logic or other code within it.
 */
include 'creds.php';
include 'libs/Services/Twilio.php';
include 'libs/eventbrite.php';


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

/*
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

    if($current_time < 420) {
        return '8:45 Opening Remarks – Cal Evans';
    }
    if($current_time >= 420 && $current_time < 480) {
        return '9am Develop with Purpose – Jon Shearer';
    }
    if($current_time >= 480 && $current_time < 540) {
        return '10:10 Grokking HTTP – Ben Ramsey, Going Deeper w/ jQuery Mobile – Andy Matthews, Concurrent Updates w/o Locks – Robert Bauer';
    }
    if($current_time >= 540 && $current_time < 600) {
        return '11:10 Automated Understanding in the Cloud–Steve Brownlee, Titanium Mobile Development–Andrew McElroy, Data Networking for Devs – Jason Myers';
    }
    if($current_time >= 600 && $current_time < 680) {
        return '12:10 Lunch! Go talk to some sponsors. They\'re awesome and make this whole thing possible.';
    }
    if($current_time >= 680 && $current_time < 750) {
        return '1:30 GUIs Come & Go, CLI is Forever – Brian Dailey, Mobile JS Frameworks 2012 – Lauren OMeara, Tools for Surviving the Zombie Apocalypse – Ian Lee';
    }
    if($current_time >= 750 && $current_time < 810) {
        return '2:30 Getting Results w/ Scrum & Kanban–Brendan Wovchko & Chris Hefley, LESS v SASS–CSS Precompiler Showdown–Kevin Powell, Codetastic P1 of 2–Jim Siegienski';
    }
    if($current_time >= 810 && $current_time < 870) {
        return '3:30 Intro to Erlang – Bryan Hunter, Redis For Fun and Profit – Matt George, Codetastic Part 2 of 2 – Testing needs Seams – Eli Tapolcsanyi';
    }
    if($current_time >= 870 && $current_time < 930) {
        return '4:30 Writing Code That is Easy to Change – Jesse Bunch, ElasticSearch – Andrew Raines, Adventures in Building Our Dream Interface – Tim Moses';
    }
    if($current_time >= 930) {
        return '6pm Tech-Mixer sponsored by Centresource at Nashville Zoo: 3777 Nolensville Pike Nashville, TN 37211';
    }

    return $current_time.' <- Sorry, there is nothing else on the schedule then!';
}