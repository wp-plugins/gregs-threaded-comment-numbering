=== Greg's Threaded Comment Numbering ===
Contributors: GregMulhauser
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=2799661
Tags: comments, count, numbering, threading, paging, paged comments, threaded comments, pingback, trackback, display, callback function, comments.php, greg mulhauser, comment number, comment counter, listing comments
Requires at least: 2.7
Tested up to: 2.7
Stable tag: 1.0.2

Numbers comments sequentially and hierarchically; handles comments which are threaded, paged and/or reversed. Coders can call the function directly.

== Description ==

The introduction of WordPress 2.7 brought with it significant new capabilities for threading and paging comments, but these same changes in WordPress mean that well established methods for numbering comments -- like including a basic incrementing counter within your template code -- no longer do the trick. Fortunately, taking advantage of modern comment handling features like paging and threading doesn't have to mean giving up comment numbering.

Coupled with a new template function for displaying comments which debuted in WordPress 2.7, Greg's Threaded Comment Numbering plugin provides accurate sequential numbering for each comment, including hierarchical numbering for the first level of threaded comments (e.g., comment number 2 and its replies numbered 2.1, 2.2, 2.3, etc.).

The plugin numbers comments accurately whether you choose to display them in ascending or descending date order, on multiple pages or on one long page, and with or without threading enabled. It also handles pingback and trackback numbering.

For coders, the plugin provides additional configuration options via direct calls to the function that handles the numbering.

For more information, please see this plugin's information page: [Greg's Threaded Comment Numbering Plugin](http://counsellingresource.com/features/2009/01/27/threaded-comment-numbering-plugin-for-wordpress/)

== Installation ==

1. Unzip the plugin archive
2. Upload the entire folder `gregs-threaded-comment-numbering` to `/wp-content/plugins/`
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Go to Settings -> Threaded Comment Numbering to configure your preferences
5. Update your template's `comments.php` or `functions.php` to incorporate numbering, as described below

= Usage =

With a single line of code -- either within `comments.php` or within a callback function defined in `functions.php` -- most themes which support WordPress 2.7 will also support the comment numbering provided by this plugin. 

*Basic Usage*

If you are using the default theme, or another theme which already supports the new WordPress 2.7 comments features but does not use its own callback function, just replace `wp_list_comments()` in your theme's `comments.php` file with `wp_list_comments('callback=gtcn_basic_callback')`. (See below for a note on safe wrapping of plugin-dependent function calls.)

The plugin includes some basic styling information suitable for the default theme, but if you'd rather style numbers yourself, you can disable this feature in the plugin's settings page and provide your own within your template's CSS file.

*Advanced Usage*

If your theme already uses a custom callback function, it probably lives in `functions.php`, and you will see the name of your callback function specified in the call to `wp_list_comments()` in your `comments.php` file. You can modify the callback function to incorporate comment numbering wherever you would like it to appear by just adding the following:

`<?php echo gtcn_comment_numbering($comment->comment_ID, $args); ?>`

(See below for a note on safe wrapping of plugin-dependent function calls.)

If you're not already using a callback function, but you would like to, creating one is very straightforward. If you'd like, you can use the `gtcn_basic_callback()` included in the plugin as a starting point for creating your own. Just give your function a new name, drop it into your `functions.php` file, and specify it as the callback for `wp_list_comments()` in your `comments.php` file.

The plugin will automatically detect and respond appropriately if it is asked to provide numbering for a callback function that was itself called to handle pingbacks or trackbacks rather than ordinary comments.

As described above, the plugin provides some basic styling information suitable for the default theme, but you can disable this easily and style comment numbers yourself. In addition to providing your own CSS, you can also specify the class of the `<div>` wrapper for the comment number by adding an argument to the numbering function call with the name of your preferred class:

`<?php echo gtcn_comment_numbering($comment->comment_ID, $args, 'mynumberclass'); ?>`

The default `<div>` wrapper class is `commentnumber`.

*Safe Wrapping of Plugin-Dependent Function Calls*

When updating your theme with any function call that is dependent upon the presence of a plugin, it is good practice to wrap the call within a conditional that checks whether the function is available, as in the following:

`<?php if (function_exists('gtcn_basic_callback'))
		  wp_list_comments('callback=gtcn_basic_callback')
	   else wp_list_comments(); ?>`

Or:

`<?php if (function_exists('gtcn_comment_numbering'))
		  echo gtcn_comment_numbering($comment->comment_ID, $args); ?>`

= Deactivating and Uninstalling =

You can deactivate Greg's Threaded Comment Numbering plugin via the plugins administration page, and your preferences will be saved for the next time you enable it.

However, if you would like to remove the plugin completely, just disable it via the plugins administration page, then select it from the list of recently deactivated plugins and choose "Delete" from the admin menu. This will not only delete the plugin, but it will also run a special routine included with the plugin which will completely remove its preferences from the database.

== Frequently Asked Questions ==

= How does Greg's Threaded Comment Numbering plugin work for pingbacks and trackbacks? =

The plugin will automatically detect and respond appropriately, depending on whether the callback function itself is handling all types of comments, just pingbacks, just trackbacks, etc.

= What if I call the plugin functions from somewhere in my template other than a callback for the `wp_list_comments()` function? =

The plugin is designed to work in conjunction with a callback function for `wp_list_comments()`, and it is only in that context that it will have anything to number.

= Does this plugin work with versions of WordPress earlier than 2.7? =

No. The plugin is designed specifically to work with new comment handling features introduced in version 2.7.

= Do you provide support for this plugin? =

No. This plugin is provided in the hopes it might be useful, but without warranty or support of any kind.

== Screenshots ==

1. Basic threaded comment numbering configuration options
2. Hierarchical comment numbering using the default theme and the provided styling

== Revision History ==

**1.0.2, 29 January 2009**

* Fixed a nested comment counter bug -- thanks to Philip S

**1.0.1, 28 January 2009**

* Fixed directory references to accommodate the WordPress Plugins Repository's automatic choice of name for the download archive

**1.0, 27 January 2009**

* Initial public release

== More Information ==

For more information, please see this plugin's information page: [Greg's Threaded Comment Numbering Plugin](http://counsellingresource.com/features/2009/01/27/threaded-comment-numbering-plugin-for-wordpress/)

== Fine Print ==

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License version 3 as published by the Free Software Foundation.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.