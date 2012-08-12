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
        $message = $messages['voice-subscribe'];
        break;
    case 9:
        unsubscribe($from);
        $message = $messages['voice-unsubscribe'];
        break;
    default:
        $message = $messages['voice-noclue'];
        $redirect = true;
}

//TODO: convert to using the proper library response methods
header('Content-type: text/xml');
?>
<Response>
    <Say><?php echo $message; ?></Say>
    <?php if ($redirect) { ?>
        <Redirect>voice.php</Redirect>
    <?php } ?>
</Response>