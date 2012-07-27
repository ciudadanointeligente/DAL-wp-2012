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

