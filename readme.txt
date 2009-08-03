=== Greg's Threaded Comment Numbering ===
Contributors: GregMulhauser
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=2799661
Tags: comments, count, numbering, threading, paging, paged comments, threaded comments, pingback, trackback, display, callback function, comments.php, greg mulhauser, comment number, comment counter, listing comments
Requires at least: 2.7
Tested up to: 2.8.2
Stable tag: 1.2.4

Numbers comments sequentially and hierarchically; handles comments which are threaded, paged and/or reversed. Coders can call the function directly.

== Description ==

This plugin numbers your comments sequentially and hierarchically, with full support for the new comment features available in WordPress 2.7 and later -- including threading, paging, and your choice of ascending or descending date order.

= New in This Version =

* Option to display comment number without a `div` wrapper 
* Documentation tweaks
* Added support for [Sustainable Plugins Sponsorship Network](http://pluginsponsors.com/)

For more details on what's new in the latest main release, version 1.2, please see the update announcement: [WordPress Threaded Comment Numbering Plugin Updated](http://counsellingresource.com/features/2009/03/31/threaded-comment-plugin-updated)

= Background =

The introduction of WordPress 2.7 brought with it significant new capabilities for threading and paging comments, but these same changes in WordPress mean that well established methods for numbering comments -- like including a basic incrementing counter within your template code -- no longer do the trick. Fortunately, taking advantage of modern comment handling features like paging and threading doesn't have to mean giving up comment numbering altogether.

Coupled with a new template function for displaying comments which debuted in WordPress 2.7, Greg's Threaded Comment Numbering plugin provides accurate sequential numbering for each comment, including hierarchical numbering up to the full 10 levels supported by WordPress.

The plugin numbers comments accurately whether you choose to display them in ascending or descending date order, on multiple pages or on one long page, and with or without threading enabled. It also handles pingback and trackback numbering.

For coders, the plugin provides additional configuration options via direct calls to the function that handles the numbering.

For more information, please see this plugin's original information page: [Greg's Threaded Comment Numbering Plugin](http://counsellingresource.com/features/2009/01/27/threaded-comment-numbering-plugin-for-wordpress/)

== Installation ==

1. Unzip the plugin archive
2. Upload the entire folder `gregs-threaded-comment-numbering` to `/wp-content/plugins/`
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Go to Settings -> Threaded Comment Numbering to configure your preferences
5. Update your template's `comments.php` or `functions.php` to incorporate numbering, as described below

= Usage =

Please see the Instructions page of the plugin settings for usage details.

= Deactivating and Uninstalling =

You can deactivate Greg's Threaded Comment Numbering plugin via the plugins administration page, and your preferences will be saved for the next time you enable it.

However, if you would like to remove the plugin completely, just disable it via the plugins administration page, then select it from the list of recently deactivated plugins and choose "Delete" from the admin menu. This will not only delete the plugin, but it will also run a special routine included with the plugin which will completely remove its preferences from the database.

== Frequently Asked Questions ==

I've moved this section of the README to the main information page for the plugin, where it can be updated independently of new releases.

== Screenshots ==

1. Basic threaded comment numbering configuration options
2. Hierarchical comment numbering using the default theme and the provided styling

== Known Issues ==

The version of the Intense Debate plugin which is current as of this writing overrides themes' existing comment code, rendering it incompatible with any theme or plugin designed to use the full capabilities of the new `wp_list_comments` introduced in WordPress 2.7. This means that regardless of what changes you make to your theme's comment code (such as calling this plugin), those changes won't show up while your comments are being controlled by Intense Debate.

== Changelog ==

= 1.2.4, 3 August 2009 =
* Option to display comment number without `div` wrapper -- thanks to Gabriel
* Documentation tweaks
* Added support for [Plugin Sponsorship](http://pluginsponsors.com/)

= 1.2.3, 11 June 2009 =
* Fully tested with final release of WordPress 2.8

= 1.2.2, 4 June 2009 =
* Updated documentation
* Support for WordPress 2.8

= 1.2.1, 15 April 2009 =
* Fixed a minor typo which would have interfered with translations for this plugin -- thanks to Nikolay

= 1.2, 31 March 2009 =
* This version brings higher performance, several minor enhancements, and a revamped administrative interface; it is recommended for all users.

= 1.1.2, 13 February 2009 =
* In return for a slight performance hit, Greg's Threaded Comment Numbering plugin can now check explicitly whether a threaded comment has been orphaned by having its parent comment deleted -- in which case, WordPress may display the comment in the wrong order. Due to the slight decrease in performance, this feature should only be enabled if you are experiencing problems with orphaned comment ordering.

= 1.1.1, 3 February 2009 =
* Folks who didn't notice the README note to update their preferred level of hierarchical numbering will find that the code now does it for them

= 1.1, 2 February 2009 =
* New feature: increased hierarchical numbering from 2 levels to 10 levels
* New feature: 'jumble count' mode for time-ordered numbering
* Enhancement: rewritten core numbering routines for significantly improved efficiency
* Fixed: cleaned up 'path to url' text (left over from WordPress Codex) in the provided basic callback function, restoring default avatar features for users calling the basic function

= 1.0.3, 30 January 2009 =
* Fixed another bug with deep nesting -- thanks to Marina

= 1.0.2, 29 January 2009 =
* Fixed a nested comment counter bug -- thanks to Philip S

= 1.0.1, 28 January 2009 =
* Fixed directory references to accommodate the WordPress Plugins Repository's automatic choice of name for the download archive

= 1.0, 27 January 2009 =
* Initial public release

== Fine Print ==

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License version 3 as published by the Free Software Foundation.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.