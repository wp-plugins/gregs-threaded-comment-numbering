<?php
/*
Plugin Name: Greg's Threaded Comment Numbering
Plugin URI: http://counsellingresource.com/features/2009/01/27/threaded-comment-numbering-plugin-for-wordpress/
Description: For WordPress 2.7 and above, this plugin numbers comments sequentially, including an hierarchical count up to ten levels deep (e.g., replies to comment number 2 will be numbered as 2.1, 2.2, 2.3 etc.).
Version: 1.3
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

class gregsThreadedCommentNumbering {

var $plugin_prefix; // prefix for option names
var $plugin_version; // what's our version number?
var $our_name; // who are we?
// These are global vars for keeping an efficient running tally
var $currentnumber = array();
var $currentnumber_simple;
var $parenttrap = array();

function gregsThreadedCommentNumbering($plugin_prefix='',$plugin_version='',$our_name='') {
$this->__construct($plugin_prefix,$plugin_version,$our_name);
return;
} 

function __construct($plugin_prefix='',$plugin_version='',$our_name='') {
$this->plugin_prefix = $plugin_prefix;
$this->plugin_version = $plugin_version;
$this->our_name = $our_name;
if ($this->opt('use_styles')) add_action('wp_head', array(&$this,'do_css'));
if ($this->opt('thank_you')) add_action('wp_footer', array(&$this,'do_thank_you'));
return;
} // end constructor

function opt($name) {
return get_option($this->plugin_prefix . '_' . $name);
} // end option retriever

function opt_clean($name) {
return stripslashes(wp_specialchars_decode($this->opt($name),ENT_QUOTES));
} // end clean option retriever

### Function: Greg's Threaded Comment Numbering CSS
function do_css() {
$prefix = $this->plugin_prefix;
$version = $this->plugin_version;
$here = str_replace(basename( __FILE__),"",plugin_basename(__FILE__)); // get plugin folder name
$name = $this->our_name;
if(@file_exists(TEMPLATEPATH."/{$prefix}-css.css")) {
	wp_register_style("{$prefix}-plugin", get_stylesheet_directory_uri()."/{$prefix}-css.css", false, $version, 'all');		
} else {
	wp_register_style("{$prefix}-plugin", plugins_url("{$here}{$prefix}-css.css"), false, $version, 'all');
}
echo "\n<!-- Start Of Additions Generated By {$name} Plugin {$version} -->\n";
wp_print_styles("{$prefix}-plugin");
echo "<!-- End Of Additions Generated By {$name} Plugin {$version} -->\n";
return;
} // end css

### Function: Thank you
function do_thank_you() {
if ( is_single() ){ // only show on individual post pages
	$name = $this->our_name;
	$message = str_replace('%THIS_PLUGIN%','<a href="http://counsellingresource.com">' . $name . ' plugin</a>',$this->opt_clean('thank_you_message'));
	echo '<p>' . wptexturize($message) . '</p>';
} // end check whether thank you should be shown
return;
} // end thanks


### Function: Greg's Threaded Comment Numbering Lookup
function comment_counter_db_lookup ($comment_ID,$args = array(),$forcesimple=false) { // count comments older than current one
	  global $wpdb;
	  if ( !$comment = get_comment( $comment_ID ) ) // check also grabs $comment
		return;
	  $allowedtypes = array(
		  'comment' => '',
		  'pingback' => 'pingback',
		  'trackback' => 'trackback',
	  );
  
	  $comtypewhere = ( 'all' != $args['type'] && isset($allowedtypes[$args['type']]) ) ? " AND comment_type = '" . $allowedtypes[$args['type']] . "'" : '';
  
	  if (!(get_option('thread_comments')) || $forcesimple) { // if not displaying threaded comments, count all older comments
		   $oldercoms = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(comment_ID) FROM $wpdb->comments WHERE comment_approved = 1 AND comment_post_ID = %d AND comment_date_gmt < '%s'" . $comtypewhere, $comment->comment_post_ID, $comment->comment_date_gmt ) );
		   }
	  else { // if displaying threaded comments, count only top level older comments
		   $oldercoms = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(comment_ID) FROM $wpdb->comments WHERE comment_approved = 1 AND comment_post_ID = %d AND comment_parent = 0 AND comment_date_gmt < '%s'" . $comtypewhere, $comment->comment_post_ID, $comment->comment_date_gmt ) );	  
	  } // end check for threading
	  return $oldercoms + 1;
} // end comment_counter_db_lookup

### Function: Determine Comment Depth
function get_depth($comment_ID = 0) { // recursive depth check
global $wpdb;
$comment = get_comment( $comment_ID );
$parent = $comment->comment_parent;
if ((0 == $parent) || ($this->parent_trashed($comment))) // must NOT use '===' because empty result, where we do not have a comment parent at all because it has been deleted, needs to evaluate as true
return '1'; 
else return $this->get_depth($parent) + 1;
}

### Function: Do parents actually exist?
function parents_exist($comment_ID = 0) { // explicit check for comments with deleted parents
if ($this->opt('do_parent_check')) {
	global $wpdb;
	$comment = get_comment( $comment_ID );
	$parent = $comment->comment_parent;
	if ($parent == '') return false;
	elseif ($this->parent_trashed($comment)) return false;
	elseif (0 == $parent) return true;
	else return $this->parents_exist($parent);
	} else {return true;}
}

### Function: Is parent in the trash?
function parent_trashed($comment) { // check if comment's immediate parent is in trash
global $wpdb;
$parent = $comment->comment_parent;
if ('' == $parent) return false; // no parent, no trash
$approval = get_comment($parent)->comment_approved;
if ($approval == 'trash') return true;
else return false;
}

### Function: Build output
function build_output($number = array(),$placeholder=1) { // recursively build the number to display
if ($number[$placeholder + 1] == '')
return $number[$placeholder];
else return $number[$placeholder] . '.' . $this->build_output($number,$placeholder + 1);
}

### Function: Do simple count
function do_simple_count($comment_ID, $args = array(), $before='', $after='' ) {
global $wpdb;

	 if (empty($this->currentnumber_simple)) { // have not started yet, so get number for first comment

	 $this->currentnumber_simple = $this->comment_counter_db_lookup ($comment_ID,$args,true);
	 echo $before . $this->currentnumber_simple . $after;
	 return;
	 } // end getting first number

 if ($args['reverse_top_level']) // bump up or down, depending on order
	 $this->currentnumber_simple --;
 else
	 $this->currentnumber_simple ++;
	 echo $before . $this->currentnumber_simple . $after;
return;
}

### Function: Do jumble count
function do_jumble_count($comment_ID, $args = array(), $before='', $after='' ) {
global $wpdb;
$this->currentnumber = $this->comment_counter_db_lookup ($comment_ID,$args,true);
echo $before . $this->currentnumber . $after;
return;
}


### Function: Greg's Threaded Comment Numbering Core
function comment_numbering( $comment_ID, $args = array(), $wrapclass = 'commentnumber' ) {
// this would all be so easy, were it not for threading and paging and reversing, which make counting go all funky

	global $wpdb;

	$prefix = $this->plugin_prefix;

	$comment = get_comment($comment_ID);
	
	if ( !( 1 == $comment->comment_approved )) // quick test for the case where a user has entered a comment which is in moderation, but that same user's subsequent comment is approved, in which case do not do anything with the number for the moderated comment
		 return;

	$before = "<div class=\"$wrapclass\">";

	$after = '</div>';
	
	if ($this->opt('no_wrapper')) $before = $after = '';

	if ($this->opt('deepest_display') == '0') // for folks who don't read the readme
		 update_option("{$prefix}_deepest_display",'2');
	
	$nesting_replacement = (1 == $this->opt('nesting_replacement')) ? '&#8230;' : '';
	
	$orphan_replacement = (1 == $this->opt('orphan_replacement')) ? '[]' : '';
		
	if ( '' === $args['max_depth'] ) {
		 if ( get_option('thread_comments') )
			 $args['max_depth'] = get_option('thread_comments_depth');
		 else
			 $args['max_depth'] = -1;
	}

	if ( $args['max_depth'] <= 1 )  { // no threading
	   $this->do_simple_count($comment_ID,$args,$before,$after);
	   return;
	   } // end of counting where there is no threading

// Jumble count instead?

	if (($this->opt('jumble_count') == 1)) {
	   $this->do_jumble_count($comment_ID,$args,$before,$after);
	   return;
	   } // end jumble count

// Some quick traps

	$depth = $this->get_depth($comment_ID);

	if (($depth > $args['max_depth']) || ! $this->parents_exist($comment_ID) || $this->parent_trashed($comment)) { // trap for comment orphaned by too low a depth or by deleted or trashed parent
		echo $before . $orphan_replacement . $after;
		return;
		}
	if ($depth > $this->opt('deepest_display')) { // trap for no more nesting
		echo $before . $nesting_replacement . $after;
		return;
		}
		 

// Begin the real stuff

	if ( 0 == $comment->comment_parent ) { // we are at top level so just grab a count for first on page and then bump it up or down for each successive comment

		if (empty($this->currentnumber)) { // have not started yet, so get number for first comment
		
			 $this->currentnumber[$depth] = $this->comment_counter_db_lookup ($comment_ID,$args);

			 } // end getting first number
		
		else { // we're not on first comment of page

			 if ($args['reverse_top_level']) // bump up or down, depending on order
				 $this->currentnumber[$depth]--;
			 else
				 $this->currentnumber[$depth]++;
			 
			 } // finished updating counter for other than first comment
	
		 } // end handling for top level

	else { // handle children
	
		 if ( $args['max_depth'] > 1 && 0 != $comment->comment_parent )
			  $myparent = $comment->comment_parent; // get parent

		 if ( $myparent == $this->parenttrap[$depth - 1]) { // check whether current comment's parent matches saved parent at next higher level, in which case this is a reply to that previous comment: re-use and increment its count
			  $this->currentnumber[$depth] ++;
			  } // end case where we already have a count for the parent
			  
		 else { // if we don't have a match that means we are in a reply to a reply, changing two depths one after the other
			  $this->currentnumber[$depth] = 1; // set initial count
			 
 			  } // end handling of reply to reply

		 } // end handling of children

	// Finish up with things we need to do on each run-through

	$this->currentnumber[$depth + 1] = ''; // and start over for the next lower
	$this->parenttrap[$depth] = $comment_ID; // save this ID in case of use by further children

	echo $before . $this->build_output($this->currentnumber) . $after;
	return;
	
} // end comment_numbering

} // end class definition

### Function: Basic Callback Function From WP Codex (http://codex.wordpress.org/Template_Tags/wp_list_comments), January 2009
function gtcn_basic_callback($comment, $args, $depth) {
// no changes here except that we have added in the call to gtcn_comment_numbering
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
	 <?php echo gtcn_comment_numbering($comment->comment_ID, $args); ?>
     <div id="comment-<?php comment_ID(); ?>">
      <div class="comment-author vcard">
         <?php echo get_avatar($comment,$size='48'); ?>

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
} // end basic callback function

if (is_admin()) {
   include ('gtcn-setup-functions.php');
   function gtcn_setup_setngo() {
	  $prefix = 'gtcn';
	  $location_full = __FILE__;
	  $location_local = plugin_basename(__FILE__);
	  $options_page_details = array ('Greg&#8217;s Threaded Comment Numbering Options','Threaded Comment Numbering','gregs-threaded-comment-numbering/gtcn-options.php');
	  new gtcnSetupHandler($prefix,$location_full,$location_local,$options_page_details);
	  } // end setup function
   gtcn_setup_setngo();
   } // end admin-only stuff
else
   {
   $gtcn = new gregsThreadedCommentNumbering('gtcn', '1.3', "Greg's Threaded Comment Numbering");
   function gtcn_comment_numbering($comment_ID, $args, $wrapclass = 'commentnumber') {
	  global $gtcn;
	  return $gtcn->comment_numbering($comment_ID, $args, $wrapclass);
	  }
   } // end non-admin stuff

?>