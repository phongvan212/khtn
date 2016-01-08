=== Visits counter ===
Contributors: slawek1082
Tags: counter, users, count users, online users, simple counter
Requires at least: 3.0
Tested up to: 3.6
Stable tag: 1.5.4

This plugin counts current online users and overall users on Your page.

== Description ==

This is simple counter of users which are on Your page at this time (within time which You specify). 
It also counts overall how many users was on Your page all time.
You can display those values anywhere You want on Your page.
Now there is also simple sidebar widget which You can add to Your page's sidebar and it displays those counters.

If You have any problem with plugin after upgrade to newer version, please first turn plugin off and than turn it on again in wp-admin panel
if you upgrade from version earlier than 1.5.3 to this one or newer than Your widget will probably dissapear from sidebar and You need to add it to sidebar again in same place

== Installation ==

1. Install plugin by simple copy it to /wp-content/plugins folder
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Customize it on "General" setting tab in wp-admin panel
3. Place 
    `<?php 
        $counter = new visits_counter(); 
        $count_values = $counter->vc_count_users();
        echo "Online users: ".$count_values['online_users'];
        echo "Overall users visited on page since ".$count_values['counterStartTime'].": ".$count_values['overall_counter'];
    ?>`
 in your template

== Changelog ==
= 1.5.4 =
* Added possibility to customize widget title and labels in admin panel (this was requested by few users in comments on my webpage)
* Added shorttag 'visits_counter' which You can add Your pages or posts content and display widget in that way.
* Fixed bug with saving value in database when day and week was changed

= 1.5.3 =
* Added German translation - thanks to Andre Lohan who made this translation :)
* Fixed error with w3c validation of widget id name - thanks to Mario Campanile who found this bug :)

= 1.5.2 =
* Fixed some css bugs in settings page of plugin

= 1.5.1 =
* Click on IP address on admin panel check and display whois data about this IP

= 1.5 =
* Added own settings page for plugin
* In wp-admin panel now are displayed IPs of users whose are currently on website

= 1.4.2 = 
* Fixed some few small bugs in polish translations

= 1.4.1 =
* Now plugin should works also with multisite configuration and network activation

= 1.4 =
* Added possibility to not count admin users on page (by default admins are counted as any user)
* Fixed bug with setting default option value when it was not set in db or when it was set to 0 (false)

= 1.3.1 =
* Fixed bug with not correct refreshing daily and weekly counter when day or week was change to next

= 1.3 =
* Added daily and weekly counters
* Added possibility to choose which counters should be displayed in widget (current online users, overall, daily, weekly)

= 1.2.3 =
* Fixed bug with setiing "count BOTs" option in wp-admin panel

= 1.2.2 =
* Fixed bug with error of translation widget title in wp-admin panel

= 1.2.1 =
* Fixed bug that sometimes user was not counted to overall counter value

= 1.2 =
* Added simple sidebar widget with counter
* Required tables in db are now created properly

= 1.1 =
* Added option to count only 'normal' users and not count Bots (e.g. GoogleBot)

= 1.0 =
* First release.
