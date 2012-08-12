<?php
include 'functions.php';

$from = $_POST['From'];
$from = preg_replace("/[^0-9]/", "", $from);

$subscribed = is_subscribed($from);
if ($subscribed) {
    $optmsg = $messages['voice-status-in'];
} else {
    $optmsg = $messages['voice-status-out'];
}

//TODO: convert to using the proper library response methods
header('Content-type: text/xml');
?>
<Response>
    <Gather action="gather.php" numDigits="1">
        <Say><?php echo $messages['voice-welcome']; ?></Say>
        <Say><?php echo $optmsg; ?></Say>
    </Gather>
</Response>