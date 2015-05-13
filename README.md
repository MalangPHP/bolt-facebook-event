Facebook Event
===

Twig extension to show facebook event details

Installation
===

Enable extension in main configuration and use BoltCMS extension installer to install.

Configuration
===

You have to create Facebook App in order to use this extension. This extension require `APP_ID`, `APP_SECRET` and `ACCESS_TOKEN`.

Usage
===

Event
---

~~~
{% set event = facebook_event(your_event_id) %}
{{ dump(event) }}
~~~

Event Attendee
---

~~~
{% set attendee = facebook_event_attendee(your_event_id) %}
{{ dump(attendee) }}
~~~

Event Feed
---

~~~
{% set feed = facebook_event_feed(your_event_id) %}
{{ dump(feed) }}
~~~

Event Photos
---

~~~
{% set photos = facebook_event_feed(photos) %}
{{ dump(photos) }}
~~~

License
===
MIT, see LICENSE