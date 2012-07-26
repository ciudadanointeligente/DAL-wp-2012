<?php
/**
 * Custom Child Pais Functions
 *
 *Editado por @montselobos 
 *This file's parent directory can be moved to the wp-content/paises directory 
 * to allow this Child pais to be activated in the Appearance - Paiss section of the WP-Admin.
 *
 * Included are a set of constants that can be defined to customize aspects of Thematic's 
 * functionality, as well as a sample function that will add a home link to your menu.
 * "Uncomment" or add more to cusomize the functionality of your Child Pais.
 *
 * More ideas can be found in the community documentation for Thematic
 * @link http://docs.thematicpais.com
 *
 * @package ThematicTestChild
 * @subpackage PaisInit
 */


// Unleash the power of Thematic's dynamic classes
// 
// define('THEMATIC_COMPATIBLE_BODY_CLASS', true);
// define('THEMATIC_COMPATIBLE_POST_CLASS', true);

// Unleash the power of Thematic's comment form
//
// define('THEMATIC_COMPATIBLE_COMMENT_FORM', true);

// Unleash the power of Thematic's feed link functions
//
// define('THEMATIC_COMPATIBLE_FEEDLINKS', true);


// Adds a home link to your menu
// http://codex.wordpress.org/Template_Tags/wp_page_menu
function childtheme_menu_args($args) {
    $args = array(
        'show_home' => 'Home',
        'sort_column' => 'menu_order',
        'menu_class' => 'menu',
        'echo' => false
   );
	return $args;
}
add_filter('wp_page_menu_args','childtheme_menu_args');


//test themes con dropdown on posts

add_action( 'init', 'create_theme_taxonomy', 0 );
 
function create_theme_taxonomy() {
	if (!taxonomy_exists('theme')) {
		register_taxonomy( 'theme', 'post', array( 'hierarchical' => false, 'label' => __('Theme'), 'query_var' => 'theme', 'rewrite' => array( 'slug' => 'theme' ) ) );
 
		wp_insert_term('Beauty', 'theme');
		wp_insert_term('Dragons', 'theme');
		wp_insert_term('Halloween', 'theme');
	}
}
 

 function add_theme_box() {
 	remove_meta_box('tagsdiv-theme','post','core');
	add_meta_box('theme_box_ID', __('Theme'), 'your_styling_function', 'post', 'side', 'core');
}	
 
function add_theme_menus() {
 
	if ( ! is_admin() )
		return;
 
	add_action('admin_menu', 'add_theme_box');

	/* Use the save_post action to save new post data */
	add_action('save_post', 'save_taxonomy_data');
}
 
add_theme_menus();


// This function gets called in edit-form-advanced.php
function your_styling_function($post) {
 
	echo '<input type="hidden" name="taxonomy_noncename" id="taxonomy_noncename" value="' . 
    		wp_create_nonce( 'taxonomy_theme' ) . '" />';
 
 
	// Get all theme taxonomy terms
	$themes = get_terms('theme', 'hide_empty=0'); 
 
?>
<select name='post_theme' id='post_theme'>
	<!-- Display themes as options -->
    <?php 
        $names = wp_get_object_terms($post->ID, 'theme'); 
        ?>
        <option class='theme-option' value='' 
        <?php if (!count($names)) echo "selected";?>>None</option>
        <?php
	foreach ($themes as $theme) {
		if (!is_wp_error($names) && !empty($names) && !strcmp($theme->slug, $names[0]->slug)) 
			echo "<option class='theme-option' value='" . $theme->slug . "' selected>" . $theme->name . "</option>\n"; 
		
		else
			echo "<option class='theme-option' value='" . $theme->slug . "'>" . $theme->name . "</option>\n"; 
	}

   ?>
</select>    
<?php
}

function save_taxonomy_data($post_id) {
// verify this came from our screen and with proper authorization.
 
 	if ( !wp_verify_nonce( $_POST['taxonomy_noncename'], 'taxonomy_theme' )) {
    	return $post_id;
  	}
 
  	// verify if this is an auto save routine. If it is our form has not been submitted, so we dont want to do anything
  	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
    	return $post_id;
 
 
  	// Check permissions
  	if ( 'page' == $_POST['post_type'] ) {
    	if ( !current_user_can( 'edit_page', $post_id ) )
      		return $post_id;
  	} else {
    	if ( !current_user_can( 'edit_post', $post_id ) )
      	return $post_id;
  	}
 
  	// OK, we're authenticated: we need to find and save the data
	$post = get_post($post_id);
	if (($post->post_type == 'post') || ($post->post_type == 'page')) { 
           // OR $post->post_type != 'revision'
           $theme = $_POST['post_theme'];
	   wp_set_object_terms( $post_id, $theme, 'theme' );
        }
	return $theme;
 
}