<?php
if( !defined( 'ABSPATH' ) && !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
} else {
	   if (current_user_can('delete_plugins')) {
		   $gtcn_settings = array ('gtcn_nesting_replacement','gtcn_orphan_replacement','gtcn_use_styles','gtcn_thank_you','gtcn_thank_you_message');
		   // Nuke the options
		   echo '<div id="message" class="updated fade">';
		   foreach($gtcn_settings as $setting) {
			   $delete_setting = delete_option($setting);
			   if($delete_setting) {
				   echo '<p style="color:green">';
				   printf(__('Setting \'%s\' has been deleted.', 'gtcn-plugin'), "<strong><em>{$setting}</em></strong>");
				   echo '</p>';
			   } else {
				   echo '<p style="color:red">';
				   printf(__('Error deleting setting \'%s\'.', 'gtcn-plugin'), "<strong><em>{$setting}</em></strong>");
				   echo '</p>';
			   }
		   }
		   echo '<strong>Thank you for using Greg&#8217;s Threaded Comment Numbering plugin!</strong>';
		   echo '</div>'; 
	  }
}

?>