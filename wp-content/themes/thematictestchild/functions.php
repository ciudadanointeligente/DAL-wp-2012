<?php
/**
 * Custom Child Theme Functions
 *
 *Editado por @montselobos 
 *This file's parent directory can be moved to the wp-content/themes directory 
 * to allow this Child theme to be activated in the Appearance - Themes section of the WP-Admin.
 *
 * Included are a set of constants that can be defined to customize aspects of Thematic's 
 * functionality, as well as a sample function that will add a home link to your menu.
 * "Uncomment" or add more to cusomize the functionality of your Child Theme.
 *
 * More ideas can be found in the community documentation for Thematic
 * @link http://docs.thematictheme.com
 *
 * @package ThematicTestChild
 * @subpackage ThemeInit
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

//Add custom taxonomies
function taxonomias_propias() {
register_taxonomy(
	 'paises',
	 'page',
	 array(
	 'hierarchical' => true, 
	 'label' => __( 'Pais' ),
	 'query_var' => true,
	 'rewrite' => array( 'slug' => 'pais' ),
	 'capabilities' => array('assign_terms'=>'edit_guides', 'edit_terms'=>'publish_guides')
	 )

	);
}

add_action('init', 'taxonomias_propias', 0);

add_action( 'admin_menu', 'my_page_taxonomy_meta_boxes' );

function my_page_taxonomy_meta_boxes() {
	foreach ( get_object_taxonomies( 'page' ) as $tax_name ) {
		if ( !is_taxonomy_hierarchical( $tax_name ) ) {
			$tax = get_taxonomy( $tax_name );
			add_meta_box( "tagsdiv-{$tax_name}", $tax->label, 'post_tags_meta_box', 'page', 'side', 'core' );
		}
	}
}