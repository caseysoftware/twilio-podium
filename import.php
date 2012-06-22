<?php

include 'functions.php';

$eventbrite = new Eventbrite(array('user_key' => $userKey, 'app_key' => $appKey));

//TODO: load event list from creds
//TODO: display event list
//TODO: pick one event
//TODO: retrieve attendees from event
//TODO: parse attendee list, subscribe each person with a phone number
//TODO: send welcome message w/ opt out info


//$events = $eventbrite->userListEvents();
//$attendees = $eventbrite->eventListAttendees(array('id' => $eventId));
//echo '<pre>'; print_r($events);
//print_r($attendees);