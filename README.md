twilio-podium
=============

This is an app designed to make the comms side of a event flow more easily.

When you have an event like a conference, you have people all over the place. They could be spread out among different rooms, floors of a building, or even different buildings. If you need to make time-sensitive announcements like events starting, schedule changes, etc email fails because not everyone is checking and wifi might be down. By switching to SMS, you can deliver messages to anyone regardless of where they are or network connectivity. Even with mediocre cellular coverage, messages should get through.

The setup is quite simple:

-  Create a database, user, etc and load the contents of setup.sql into it.

-  Set up the creds.php file with each of the variables. The whitelist array is key.

-  Upload the entire system to your friendly neighborhood web server.

-  Purchase a Twilio number and set the Voice and SMS Urls to point at the app.

Using the system is even simpler:

-  To subscribe, anyone can either call and follow the instructions. Alternatively, you can text the Twilio number. That number will be immediately subscribed.

-  To unsubscribe, simple call and follow the instructions or text STOP.

-  Whenever someone with a phone number in the whitelist array sends a message, the sender's initials are appended and the message is rebroadcast to all subscribers.

Notes:

-  The '+' prefix for all numbers - such as +15125551212 - will always be removed. No compelling reason other than it was an easy regular expression and is not necessary for sending messages.


Wishlist:

-  TODO: Web interface for subscribing/unsubscribing

-  TODO: Integrate with a schedule system to replace the hard coding in get_info_message()

-  TODO: Integrate with a schedule system to allow people to mark the sessions they care about and get realtime reminders/updates

-  TODO: calculate the scheduled message count vs time available and purchase additional appropriate numbers as needed

-  TODO: Admin ability to schedule messages for later broadcasting

-  TODO: Accept incoming messages & generate winners for raffles or prize drawings

-  TODO: Collect stats on the system/traffic