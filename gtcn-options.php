<?php
/*
	 WordPress 2.7 Plugin: Greg's Threaded Comment Numbering 1.0.2
	 Copyright (c) 2009 Greg Mulhauser
	 
	 File Written By:
	 - Greg Mulhauser
	 - http://counsellingresource.com
	 - http://mulhauser.net
	 
	 Information:
	 - Greg's Threaded Comment Numbering Options Page
	 - wp-content/plugins/gregs-threaded-comment-numbering/gtcn-options.php
*/
//register_setting('gtcn_options', 'gtcn_nesting_replacement', 'intval');
//register_setting('gtcn_options', 'gtcn_orphan_replacement', 'intval');
//register_setting('gtcn_options', 'gtcn_use_styles', 'intval');

$site_link = ' <a href="http://counsellingresource.com/">CounsellingResource.com</a>';
$plugin_page = ' <a href="http://counsellingresource.com/features/2009/01/27/threaded-comment-numbering-plugin-for-wordpress/">Greg&#8217;s Threaded Comment Numbering plugin</a>';

?>

<div class="wrap">
<form method="post" action="options.php"> 
<?php settings_fields('gtcn_options'); ?>
<?php screen_icon(); ?>
<h2><?php _e('Greg&#8217;s Threaded Comment Numbering Settings and Usage', 'gtcn-plugin'); ?></h2>
<p><?php _e('For usage instructions, please see the README file distributed with this plugin, and for more details please see the plugin page at:', 'gtcn-plugin'); echo $plugin_page; ?>.</p>
<h3><?php _e('Styling Comment Numbers', 'gtcn-plugin'); ?></h3>
<p><?php printf(__('Greg&#8217;s Threaded Comment Numbering plugin can provide some basic styling for comment numbers via a small additional stylesheet. But if you&#8217;d rather provide your own comment number styling, just indicate that here, and include styling for %s in your theme&#8217;s stylesheet.', 'gtcn-plugin'), '<code>div.commentnumber</code>'); ?></p>
<table class="form-table">
  <tr>
	  <th scope="row" valign="top"><?php _e('Use Built-In Styles?', 'gtcn-plugin'); ?></th>
	  <td>
	  <ul>
		  <li><input type="radio" name="gtcn_use_styles" value="1"<?php checked('1', get_option('gtcn_use_styles')); ?> /> <?php _e('Yes - Load an Extra Numbering Stylesheet', 'gtcn-plugin'); ?></li>
		  <li><input type="radio" name="gtcn_use_styles" value="0"<?php checked('0', get_option('gtcn_use_styles')); ?> /> <?php _e('No - I Will Provide My Own Number Styling', 'gtcn-plugin'); ?></li>
	  </ul>
	  </td> 
  </tr>
</table>
<h3><?php _e('Handling Orphaned and Deeply Nested Comments', 'gtcn-plugin'); ?></h3>
<p><?php _e('You can choose how deeply into nested replies Greg&#8217;s Threaded Comment Numbering plugin should display hierarchical numbering, up to the full 10 levels supported by WordPress. For example, hierarchical numbering up through a depth of 2 will display a number for comment 5 and its replies numbered 5.1, 5.2, etc). With more deeply nested replies, hierarchical numbering can become cumbersome (e.g., comment number 12.19.6.4), so if you choose to stop hierarchical numbering sooner than the level at which you permit comments, you can choose what to display in lieu of a number.', 'gtcn-plugin'); ?></p>
<p><?php _e('Finally, as of version 2.7, WordPress has severe problems handling orphaned comments &mdash; where threading is enabled at a given depth (say, 2), but comments exist which were previously entered at a deeper depth (say, 3) &mdash; especially when paging is also enabled. You can choose what to display when this happens. When threading is disabled completely in the WordPress discussion settings, all comments will be correctly ordered, regardless of the setting specified for orphaned replies. Note that for WordPress 2.7, disabling comment threading is very much not the same as setting threading to depth 1.', 'gtcn-plugin'); ?></p>
<table class="form-table">
  <tr>
	  <th scope="row" valign="top"><?php _e('Maximum Depth to Display Hierarchical Numbering', 'gtcn-plugin'); ?></th>
	  <td>
		  <select name="gtcn_deepest_display" size="1">
			  <option value="1"<?php selected('1', get_option('gtcn_deepest_display')); ?>><?php _e('1', 'gtcn-plugin'); ?></option>
			  <option value="2"<?php selected('2', get_option('gtcn_deepest_display')); ?>><?php _e('2', 'gtcn-plugin'); ?></option>
			  <option value="3"<?php selected('3', get_option('gtcn_deepest_display')); ?>><?php _e('3', 'gtcn-plugin'); ?></option>
			  <option value="4"<?php selected('4', get_option('gtcn_deepest_display')); ?>><?php _e('4', 'gtcn-plugin'); ?></option>
			  <option value="5"<?php selected('5', get_option('gtcn_deepest_display')); ?>><?php _e('5', 'gtcn-plugin'); ?></option>
			  <option value="6"<?php selected('6', get_option('gtcn_deepest_display')); ?>><?php _e('6', 'gtcn-plugin'); ?></option>
			  <option value="7"<?php selected('7', get_option('gtcn_deepest_display')); ?>><?php _e('7', 'gtcn-plugin'); ?></option>
			  <option value="8"<?php selected('8', get_option('gtcn_deepest_display')); ?>><?php _e('8', 'gtcn-plugin'); ?></option>
			  <option value="9"<?php selected('9', get_option('gtcn_deepest_display')); ?>><?php _e('9', 'gtcn-plugin'); ?></option>
			  <option value="10"<?php selected('10', get_option('gtcn_deepest_display')); ?>><?php _e('10', 'gtcn-plugin'); ?></option>
		  </select>

	</td> 
  </tr>
  <tr>
	  <th scope="row" valign="top"><?php _e('Indicator for More Deeply Nested Replies', 'gtcn-plugin'); ?></th>
	  <td>
		  <ul>
			  <li><input type="radio" name="gtcn_nesting_replacement" value="1"<?php checked('1', get_option('gtcn_nesting_replacement')); ?> /> <?php _e('Display Ellipsis: &#8230; (recommended)', 'gtcn-plugin'); ?></li>
			  <li><input type="radio" name="gtcn_nesting_replacement"  value="0"<?php checked('0', get_option('gtcn_nesting_replacement')); ?> /> <?php _e('Display Nothing', 'gtcn-plugin'); ?></li>
		  </ul>
	  </td> 
  </tr>
  <tr>
	  <th scope="row" valign="top"><?php _e('Indicator for Orphaned Threaded Replies', 'gtcn-plugin'); ?></th>
	  <td>
		  <ul>
			  <li><input type="radio" name="gtcn_orphan_replacement" value="0"<?php checked('0', get_option('gtcn_orphan_replacement')); ?> /> <?php _e('Display Nothing (recommended)', 'gtcn-plugin'); ?></li>
			  <li><input type="radio" name="gtcn_orphan_replacement" value="1"<?php checked('1', get_option('gtcn_orphan_replacement')); ?> /> <?php _e('Display Brackets: [ ]', 'gtcn-plugin'); ?></li>
		  </ul>
	  </td> 
  </tr>
</table>
<h3><?php _e('Perform a Jumble Count', 'gtcn-plugin'); ?></h3>
<p><?php _e('If you&#8217;re not big on hierarchical numbering, but you&#8217;d still like to see a number indicating the order in which comments were received, you can enable the &#8216;jumble count&#8217; mode. In this mode, all comments will be numbered strictly in the order in which they were posted. Note that if comments are threaded, the order of posting does not equal the order in which they are displayed. Thus the term &#8216;jumble count&#8217;: with threaded comments enabled, jumble count may yield a sequence of numbers which does not at all match the order in which the comments are displayed on the page.', 'gtcn-plugin'); ?></p>
<table class="form-table">
  <tr>
	  <th scope="row" valign="top"><?php _e('Enable Jumble Count?', 'gtcn-plugin'); ?></th>
	  <td>
		  <ul>
			  <li><input type="radio" name="gtcn_jumble_count" value="0"<?php checked('0', get_option('gtcn_jumble_count')); ?> /> <?php _e('Count Entries in Display Order (recommended)', 'gtcn-plugin'); ?></li>
			  <li><input type="radio" name="gtcn_jumble_count" value="1"<?php checked('1', get_option('gtcn_jumble_count')); ?> /> <?php _e('Do a Jumble Count', 'gtcn-plugin'); ?></li>
		  </ul>
	  </td> 
  </tr>
</table>
<p><em><?php _e('Note that jumble counting is the most computationally intensive method of numbering: with jumble count enabled, every comment requires a database query to compute its number, whereas with the normal method, just one database query is required per page.', 'gtcn-plugin'); ?></em></p>
<h3><?php _e('Hat Tip?', 'gtcn-plugin'); ?></h3>
<p><?php _e('If you feel that Greg&#8217;s Threaded Comment Numbering plugin has improved your blog&#8217;s comments section, you can choose to display a small thank you message in the footer. This is NOT ENABLED by default, but you can enable it here:', 'gtcn-plugin'); ?></p>
<table class="form-table">
  <tr>
	  <th scope="row" valign="top"><?php _e('Display Thank You Message?', 'gtcn-plugin'); ?></th>
	  <td>
		  <ul>
			  <li><input type="radio" name="gtcn_thank_you" value="0"<?php checked('0', get_option('gtcn_thank_you')); ?> /> <?php _e('No - do not add anything to my footer', 'gtcn-plugin'); ?></li>
			  <li><input type="radio" name="gtcn_thank_you" value="1"<?php checked('1', get_option('gtcn_thank_you')); ?> /> <?php _e('Yes - display a thank you message as specified below', 'gtcn-plugin'); ?></li>
		  </ul>
	  </td> 
  </tr>
  <tr>
	  <th scope="row" valign="top"><?php _e('Message to Display (only if selected above):', 'gtcn-plugin'); ?></th>
	  <td>
			  <input type="text" size="40" name="gtcn_thank_you_message" value="<?php echo get_option('gtcn_thank_you_message'); ?>" /><br /><?php printf(__('(The text %s will be replaced with the name and link to the plugin.)', 'gtcn-plugin'), '<strong>%THIS_PLUGIN%</strong>'); ?>
	  </td> 
  </tr>
  <tr>
  <th></th>
  <td>   <p class="submit">
  <input type="submit" name="Submit" class="button" value="<?php _e('Save Changes', 'gtcn-plugin'); ?>" />
</p>
</td>
</tr>
</table>
</form>
  <h3><?php _e('Usage', 'gtcn-plugin'); ?></h3>
<p><?php _e('Please also see the README file distributed with this plugin, and for details on how to wrap the following functions in conditionals so your theme will only rely on this plugin when it is activated, please see the plugin page at: ', 'gtcn-plugin'); echo $plugin_page; ?>.</p>
<dl style="margin-left:1.5em;">
<dt style="margin-left:1em;font-weight:bold;"><?php _e('Basic Usage', 'gtcn-plugin'); ?></dt>
<dd style="margin-left:2em;"><?php printf(__('Replace %s in your theme&#8217;s %s file with %s.', 'gtcn-plugin'), '<code>wp_list_comments()</code>', '<code>comments.php</code>', '<code>wp_list_comments(\'callback=gtcn_basic_callback\')</code>'); ?></dd>
<dt style="margin-left:1em;font-weight:bold;"><?php _e('Advanced Usage', 'gtcn-plugin'); ?></dt>
<dd style="margin-left:2em;"><?php printf(__('Create your own callback function to display comments how you would like them, and insert %s within the callback function wherever you would like the comment number to appear.', 'gtcn-plugin'), '<code>echo gtcn_comment_numbering($comment->comment_ID, $args)</code>'); ?></dd>
</dl>
<p><em><?php _e('Please consider asking your theme developer to support this plugin out of the box: with the addition of just a single line of code, most themes can be ready to display hierarchical comment numbering as soon as this plugin is activated!', 'gtcn-plugin'); ?></em></p>
<h3><?php _e('Supporting Plugin Development', 'gtcn-plugin'); ?></h3>
<p><?php _e('If you find this plugin useful, please consider telling your friends with a quick post about it and/or a mention of our site:', 'gtcn-plugin'); echo $site_link; ?>.</p>
<p><?php _e('And of course, donations of any amount via PayPal won&#8217;t be refused! Please see the plugin page for details:', 'gtcn-plugin'); echo $plugin_page; ?>.</p>
<p><em><?php _e('Thank you!', 'gtcn-plugin'); ?></em></p>
<h3><?php _e('Fine Print', 'gtcn-plugin'); ?></h3>
<p style="font-size:.8em"><em><?php _e('This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License version 3 as published by the Free Software Foundation.', 'gtcn-plugin'); ?></em></p>
<p style="font-size:.8em"><em><?php _e('This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.', 'gtcn-plugin'); ?></em></p>
<p>&nbsp;</p>
</div>
<?php
?>