<?php
include 'functions.php';

$from = $_POST['From'];
$from = preg_replace("/[^0-9]/", "", $from);

$digits = $_POST['Digits'];
$digits = preg_replace("/[^0-9]/", "", $digits);

$redirect = false;

switch ($digits) {
    case 1:
        subscribe($from);
        $message = 'You are now opted into the P H P tech 2012 text notification system powered by Twilio. You will now receive text updates as they become available. Goodbye.';
        break;
    case 9:
        unsubscribe($from);
        $message = 'You have been opted out of P H P tech notification system. To opt back in, send any message to this number. Goodbye.';
        break;
    default:
        $message = "I'm sorry, I didn't understand that option. Let's try again.";
        $redirect = true;
}
header('Content-type: text/xml');
?>
<Response>
    <Say><?php echo $message; ?></Say>
    <?php if ($redirect) { ?>
        <Redirect>voice.php</Redirect>
    <?php } ?>
</Response>