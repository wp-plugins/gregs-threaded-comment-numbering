<?php
if( !defined( 'ABSPATH' ) && !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
} else {
if (!class_exists('gtcnSetupHandler')) include ('gtcn-setup-functions.php');
$gtcn_options_set = gtcnSetupHandler::grab_settings();

	   if (current_user_can('delete_plugins')) {
		   echo '<div id="message" class="updated fade">';
		   foreach ($gtcn_options_set as $optionset=>$optionarray) {
			 foreach ($optionarray as $setting) {
			   $delete_setting = delete_option('gtcn_' . $setting[0]);
			   if($delete_setting) {
				   echo '<p style="color:green">';
				   printf(__('Setting \'%s\' has been deleted.', 'gtcn-plugin'), "<strong><em>{$setting[0]}</em></strong>");
				   echo '</p>';
			   } else {
				   echo '<p style="color:red">';
				   printf(__('Error deleting setting \'%s\'.', 'gtcn-plugin'), "<strong><em>{$setting[0]}</em></strong>");
				   echo '</p>';
			   }
			 } // end inner loop over individual settings
		   }
		   echo '<strong>Thank you for using Greg&#8217;s Threaded Comment Numbering plugin!</strong>';
		   echo '</div>'; 
	  }
}

?>