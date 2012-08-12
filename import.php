<?php

include 'functions.php';

$eventbrite = new Eventbrite(array('user_key' => $ebUserKey, 'app_key' => $ebAppKey));

//TODO: load event list from creds
//TODO: display event list
//TODO: pick one event
/*
 * The above three items are what would eventually replace the $ebEventId variable below
 */

//DONE: retrieve attendees from event
//DONE: parse attendee list, subscribe each person with a phone number
//DONE: send welcome message w/ opt out info

//$events = $eventbrite->userListEvents();
$results = $eventbrite->eventListAttendees(array('id' => $ebEventId));

foreach($results as $attendeeList) {
    foreach ($attendeeList as $attendees) {
        foreach ($attendees as $attendee) {
            $name = trim($attendee['first_name']). ' ' . trim($attendee['last_name']);
            $phone = (isset($attendee['cell_phone'])) ? $attendee['cell_phone'] : '';
            $phone = preg_replace("/[^0-9]/", "", $phone );

            switch(strlen($phone)) {
                case 10:
                    // Most likely we're just missing the +1, so let's add the 1
                    $phone = '1'.$phone;
                    break;
                case 11:
                    // Most likely we're just missing the +, but it's not necessary, so do nothing
                    break;
                default:
                    // Something is broken, blank out the number so we don't trigger anything:
                    $phone = '';
            }
            
            if ('' == $phone) {
                $msg = "No valid cell phone listed for attendee: $name";
            } else {
                
                if (is_subscribed($phone)) {
                    $msg = "Already subscribed: $name";
                } else {
                    $msg = "Now subscribing $phone -- $name";
                    subscribe($phone);
                }
            }
            
            echo $msg."\n";
        }
    }
}