<?php

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
    $sql = "SELECT * FROM subscribers WHERE status = 1";
    $results = mysql_query($sql);

    while ($row = mysql_fetch_assoc($results)) {
        $subscribers[] = $row['phone'];
    }

    return $subscribers;
}

function subscribe($phone) {
    $sql = "INSERT INTO subscribers (phone, status) VALUES ('$phone', 1)";
    $result = mysql_query($sql);
}

function unsubscribe($phone) {
    $sql = "UPDATE subscribers SET status = 0 WHERE phone = '$phone'";
    $result = mysql_query($sql);
}

function get_info_message() {
    //TODO: get timestamp
    //TODO: adjust for timezone
    //TODO: get data for timeslot
}