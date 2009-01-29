<?php
/*
Plugin Name: Greg's Threaded Comment Numbering
Plugin URI: http://counsellingresource.com/features/2009/01/27/threaded-comment-numbering-plugin-for-wordpress/
Description: For WordPress 2.7 and above, this plugin numbers comments sequentially, including an hierarchical count for the first level of threaded comments (e.g., replies to comment number 2 will be numbered as 2.1, 2.2, 2.3 etc.).
Version: 1.0.2
Author: Greg Mulhauser
Author URI: http://counsellingresource.com/
*/

/*  Copyright (c) 2009 Greg Mulhauser

	A special request to theme designers and developers: I'd like to encourage you to add support for comment numbering in your theme using the simple function call described in the README. However, I'd also be grateful if you could please point your users to the official plugin page at CounsellingResource.com rather than bundling it with your theme files. Thank you!

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 3 as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
function gtcn_init() {
	add_option("gtcn_nesting_replacement", "1");
	add_option("gtcn_orphan_replacement", "0");
	add_option("gtcn_use_styles", "1");
	add_option("gtcn_thank_you", "0");
	add_option("gtcn_thank_you_message", "Thanks to %THIS_PLUGIN%.");
}
function gtcn_admin_init(){
	register_setting('gtcn_options', 'gtcn_nesting_replacement', 'intval');
	register_setting('gtcn_options', 'gtcn_orphan_replacement', 'intval');
	register_setting('gtcn_options', 'gtcn_use_styles', 'intval');
	register_setting('gtcn_options', 'gtcn_thank_you', 'intval');
	register_setting('gtcn_options', 'gtcn_thank_you_message', 'wp_filter_nohtml_kses');
}
function gtcn_menu() {
  add_options_page(__('Threaded Comment Numbering Options', 'gtcn-plugin'), __('Threaded Comment Numbering', 'gtcn-plugin'), 'manage_options', 'gregs-threaded-comment-numbering/gtcn-options.php') ;
}
### Function: Greg's Threaded Comment Numbering CSS
function gtcn_css() {
  if (get_option('gtcn_use_styles') == 1) { 
	if(@file_exists(TEMPLATEPATH.'/gtcn-css.css')) {
	  wp_register_style('gtcn-plugin', get_stylesheet_directory_uri().'/gtcn-css.css', false, '1.0.2', 'all');		
	} else {
	  wp_register_style('gtcn-plugin', plugins_url('gregs-threaded-comment-numbering/gtcn-css.css'), false, '1.0.2', 'all');
	}
	echo "\n".'<!-- Start Of Additions Generated By Greg\'s Threaded Comment Numbering Plugin 1.0.2 -->'."\n";
	wp_print_styles('gtcn-plugin');
	echo '<!-- End Of Additions Generated By Greg\'s Threaded Comment Numbering Plugin 1.0.2 -->'."\n";
  } 
  return;
} 
### Function: Thank you
function gtcn_thanks() {
  if ((get_option('gtcn_thank_you') == 1) && is_single() ){ 
   $message = str_replace('%THIS_PLUGIN%','<a href="http://counsellingresource.com/features/2009/01/27/threaded-comment-numbering-plugin-for-wordpress/">Greg&#8217;s Threaded Comment Numbering plugin</a>',get_option('gtcn_thank_you_message'));
   echo '<p>' . $message . '</p>';
  } 
  return;
} 
### Function: Greg's Threaded Comment Numbering Lookup
function gtcn_comment_counter_db_lookup ($comment_ID,$args = array()) { 
  global $wpdb;
  if ( !$comment = get_comment( $comment_ID ) ) 
	return;
  $allowedtypes = array(
	'comment' => '',
	'pingback' => 'pingback',
	'trackback' => 'trackback',
  );
  $comtypewhere = ( 'all' != $args['type'] && isset($allowedtypes[$args['type']]) ) ? " AND comment_type = '" . $allowedtypes[$args['type']] . "'" : '';
  if (!(get_option('thread_comments'))) { 
	$oldercoms = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(comment_ID) FROM $wpdb->comments WHERE comment_approved = 1 AND comment_post_ID = %d AND comment_date_gmt < '%s'" . $comtypewhere, $comment->comment_post_ID, $comment->comment_date_gmt ) );
	}
  else { 
	$oldercoms = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(comment_ID) FROM $wpdb->comments WHERE comment_approved = 1 AND comment_post_ID = %d AND comment_parent = 0 AND comment_date_gmt < '%s'" . $comtypewhere, $comment->comment_post_ID, $comment->comment_date_gmt ) );	  
  } 
  return $oldercoms + 1;
} 
### Function: Greg's Threaded Comment Numbering Core
function gtcn_comment_numbering( $comment_ID, $args = array(), $wrapclass = '' ) {
  global $wpdb,
		 $gtcn_parenttrap, 
		 $gtcn_childcount,
		 $gtcn_currentnumber;
  if ( $wrapclass == '' ) 
	$before = '<div class="commentnumber">';
  else
	$before = "<div class=\"$wrapclass\">";
  $after = '</div>';
  if ( !$comment = get_comment( $comment_ID ) ) 
	return; 
  if ( !( 1 == $comment->comment_approved )) 
	return;
  if ( get_option('gtcn_nesting_replacement') == 1)
	$gtcn_nesting_replacement = '&#8230;';
  else
	$gtcn_nesting_replacement = '';
  if ( get_option('gtcn_orphan_replacement') == 1)
	$gtcn_orphan_replacement = '[]';
  else
	$gtcn_orphan_replacement = '';
  if ( '' === $args['per_page'] && get_option('page_comments') )
	$args['per_page'] = get_query_var('comments_per_page');
  if ( empty($args['per_page']) ) {
	$args['per_page'] = 0;
	$args['page'] = 0;
  }
  if ( '' === $args['max_depth'] ) {
	if ( get_option('thread_comments') )
	  $args['max_depth'] = get_option('thread_comments_depth');
	else
	  $args['max_depth'] = -1;
  }
  if ( $args['max_depth'] <= 1 ) { 
	if (!isset($gtcn_currentnumber)) { 
	  $gtcn_currentnumber = gtcn_comment_counter_db_lookup ($comment_ID,$args);
	  return $before . $gtcn_currentnumber . $after;
	} 
	if ($args['reverse_top_level'] == 1) 
	  $gtcn_currentnumber--;
	else
	  $gtcn_currentnumber++;
	return $before . $gtcn_currentnumber . $after;
	} 
  if ( $args['max_depth'] > 1 && 0 == $comment->comment_parent ) { 
	if ( !isset($gtcn_currentnumber) ) { 
	  $gtcn_currentnumber = gtcn_comment_counter_db_lookup ($comment_ID,$args);
	  }
	else { 
	  $dot = strpos($gtcn_currentnumber, '.'); 
	  if (!($dot === false))
	  $gtcn_currentnumber = substr($gtcn_currentnumber,0,$dot); 
	  if ($args['reverse_top_level'] == 1) 
		$gtcn_currentnumber--;
	  else
		$gtcn_currentnumber++;
	  } 
	$gtcn_parenttrap = array($comment_ID, $gtcn_currentnumber);
	$gtcn_childcount = '1';
	return $before . $gtcn_currentnumber . $after;
	} 
  else { 
	if ( $args['max_depth'] > 1 && 0 != $comment->comment_parent )
	   $myparent = $comment->comment_parent; 
	if ( $myparent == $gtcn_parenttrap[0]) { 
	   if (!isset($gtcn_childcount)) $gtcn_childcount = 1; 
			$gtcn_currentnumber = $gtcn_parenttrap[1] . "." . $gtcn_childcount;
	   $gtcn_childcount ++;
	   } 
	else { 
	   if ( $args['max_depth'] > 2) { 
		  $gtcn_currentnumber = $gtcn_nesting_replacement;
		  }
	   else
		  { 
		  $gtcn_currentnumber = $gtcn_orphan_replacement;
		  } 
		 } 
	return $before . $gtcn_currentnumber . $after;
	} 
} 
### Function: Basic Callback Function From WP Codex (http://codex.wordpress.org/Template_Tags/wp_list_comments), January 2009
function gtcn_basic_callback($comment, $args, $depth) {
  $GLOBALS['comment'] = $comment; ?>
  <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
	<?php echo gtcn_comment_numbering($comment->comment_ID, $args); ?>
	<div id="comment-<?php comment_ID(); ?>">
	 <div class="comment-author vcard">
		<?php echo get_avatar($comment,$size='48',$default='<path_to_url>' ); ?>
		<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
	 </div>
	 <?php if ($comment->comment_approved == '0') : ?>
		<em><?php _e('Your comment is awaiting moderation.') ?></em>
		<br />
	 <?php endif; ?>
	 <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','') ?></div>
	 <?php comment_text() ?>
	 <div class="reply">
		<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	 </div>
	</div>
<?php
} 
add_action('admin_menu', 'gtcn_menu');
add_action('admin_init', 'gtcn_admin_init' );
register_activation_hook( __FILE__, 'gtcn_init' );
add_action('wp_head', 'gtcn_css');
add_action('wp_footer', 'gtcn_thanks');
?>