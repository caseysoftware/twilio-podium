twilio-podium
=============

This is an app designed to make the comms side of a event (like a conference) flow more easily.

The setup is quite simple:

-  Create a database, user, etc and load the contents of setup.sql into it.

-  Set up the creds.php file with each of the variables. The whitelist array is key.

-  Upload the entire system to your friendly neighborhood web server.

-  Purchase a Twilio number and set the Voice and SMS Urls to point at the app.


Using the system is even simpler:

-  To subscribe, anyone can either call and follow the instructions. Alternatively, you can text the Twilio number. That number will be immediately subscribed.

-  To unsubscribe, simple call and follow the instructions or text STOP.

-  Whenever someone with a phone number in the whitelist array sends a message, the sender's initials are appended and the message is rebroadcast to all subscribers.

-  