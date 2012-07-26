<?php
/**
 * Custom Child Pais Functions
 *
 *Editado por @montselobos 
 *This file's parent directory can be moved to the wp-content/paiss directory 
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
function childpais_menu_args($args) {
    $args = array(
        'show_home' => 'Home',
        'sort_column' => 'menu_order',
        'menu_class' => 'menu',
        'echo' => false
   );
	return $args;
}
add_filter('wp_page_menu_args','childpais_menu_args');

//Add custom taxonomies
/*
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
			add_meta_box( "tagsdiv-{$tax_name}", $tax->label, 'page_tags_meta_box', 'page', 'side', 'core' );
		}
	}
}*/

//test dragons con dropdown

add_action( 'init', 'create_pais_taxonomy', 0 );
 
function create_pais_taxonomy() {
	if (!taxonomy_exists('pais')) {
		register_taxonomy( 'pais', 'page', array( 'hierarchical' => true, 'label' => __('Pais'), 'query_var' => 'pais', 'rewrite' => array( 'slug' => 'pais' ) ) );
 
		wp_insert_term('Chile', 'pais');
		wp_insert_term('Perú', 'pais');
		wp_insert_term('Argentina', 'pais');
	}
}

function add_pais_box() {
	add_meta_box('pais_box_ID', __('Pais'), 'your_styling_function', 'page', 'side', 'core');
	remove_meta_box('pais','page','core');  
}	
 
function add_pais_menus() {
 
	if ( ! is_admin() )
		return;
 
	add_action('admin_menu', 'add_pais_box');
}
 
add_pais_menus();

// This function gets called in edit-form-advanced.php
function your_styling_function($page) {
 
	echo '<input type="hidden" name="taxonomy_noncename" id="taxonomy_noncename" value="' . 
    		wp_create_nonce( 'taxonomy_pais' ) . '" />';
 
 
	// Get all pais taxonomy terms
	$paiss = get_terms('pais', 'hide_empty=0'); 
 
?>
<select name='page_pais' id='page_pais'>
	<!-- Display paiss as options -->
    <?php 
        $names = wp_get_object_terms($page->ID, 'pais'); 
        ?>
        <option class='pais-option' value='' 
        <?php if (!count($names)) echo "selected";?>>None</option>
        <?php
	foreach ($paiss as $pais) {
		if (!is_wp_error($names) && !empty($names) && !strcmp($pais->slug, $names[0]->slug)) 
			echo "<option class='pais-option' value='" . $pais->slug . "' selected>" . $pais->name . "</option>\n"; 
		else
			echo "<option class='pais-option' value='" . $pais->slug . "'>" . $pais->name . "</option>\n"; 
	}
   ?>
</select>  

<?php
}

