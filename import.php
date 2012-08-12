<?php

include 'functions.php';

$eventbrite = new Eventbrite(array('user_key' => $ebUserKey, 'app_key' => $ebAppKey));

if((int) $argv[1]) {
    $ebEventId = $argv[1];
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
} else {
    $results = $eventbrite->userListEvents();

    foreach($results as $eventList) {
        echo "Here are the events you may choose from: \n";
        foreach ($eventList as $events) {
            foreach ($events as $event) {
                $strlength = 5 - (int) (strlen($event['title']) / 10);
                $spacing = str_repeat("\t", $strlength);
                echo $event['title'] . $spacing . $event['id'] . "\t\t\t" . $event['start_date'] . "\n";
            }
        }

        echo "Simply re-run this script with the id of the event you want to import\n";
    }
}