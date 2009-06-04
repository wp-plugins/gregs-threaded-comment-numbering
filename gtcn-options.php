<?php
require_once('gtcn-options-functions.php');

function gtcn_options_setngo() {
$name = "Greg's Threaded Comment Numbering";
$settings_prefix = 'gtcn_options_'; // prefix for each distinct set of options registered, used by WP's settings_fields to set up the form correctly
$domain = 'gtcn-plugin'; // text domain
$plugin_prefix = 'gtcn_'; // prefix for each option name, with underscore
$subdir = 'options-set'; // subdirectory where options ini files are stored
$instname = 'instructions'; // name of page holding instructions
$dofull = get_option('gtcn_abbreviate_options') ? false : true; // set this way so unitialized option default of zero will equate to "do not abbreviate, show us full options"
$donated = get_option('gtcn_donated');
$site_link = ' <a href="http://counsellingresource.com/">CounsellingResource.com</a>';
$plugin_page = " <a href=\"http://counsellingresource.com/features/2009/01/27/threaded-comment-numbering-plugin-for-wordpress/\">Greg's Threaded Comment Numbering plugin</a>";
$paypal_button = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=2799661"><img src="https://www.paypal.com/en_GB/i/btn/btn_donate_LG.gif" name="paypalsubmit" alt="" border="0" /></a>';
$replacements = array(
					 '%site_link%' => $site_link,
					 '%plugin_page%' => $plugin_page,
					 '%paypal_button%' => $paypal_button,
					 );
$problems = array();
$pages = array (
			   'default' => array(
			   "$name: " . __('Configuration',$domain),
			   __('Configuration',$domain),
			   ),
			   $instname => array(
			   "$name: " . __('Instructions and Setup',$domain),
			   __('Instructions',$domain),
			   ),
			   'donating' => array(
			   "$name: " . __('Supporting This Plugin',$domain),
			   __('Contribute',$domain),
			   ),
			   );

$options_handler = new gtcnOptionsHandler($replacements,$pages,$domain,$plugin_prefix,$subdir,$instname); // prepares settings
$options_handler->display_options($settings_prefix,$problems,$name,$dofull,$donated);

return;
} // end displaying the options

gtcn_options_setngo();

?>