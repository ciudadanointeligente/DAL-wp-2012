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


//test paises con dropdown

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

	remove_meta_box('paisdiv','page','side');

	add_meta_box('pais_box_ID', __('Pais'), 'your_styling_function', 'page', 'side', 'core');

}	
 

//
//
//
//
//define funcion para guardar tax

function save_taxonomy_data($thispage_id) {
// verify this came from our screen and with proper authorization.
$myFile = "testFile.txt";
$fh = fopen($myFile, 'w') or die("can't open file");
$stringData = "Bobby Bopper\n";
fwrite($fh, $stringData);
fclose($fh);
/* 	if ( !wp_verify_nonce( $_POST['taxonomy_noncename'], 'taxonomy_pais' )) {
    	return $thispage_id;
  	}
 
  	// verify if this is an auto save routine. If it is our form has not been submitted, so we dont want to do anything
  	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
    	return $thispage_id;
 
 
  	// Check permissions
  	if ( 'page' == $_POST['post_type'] ) {
    	if ( !current_user_can( 'edit_page', $thispage_id ) )
      		return $thispage_id;
  	} else {
    	if ( !current_user_can( 'edit_post', $thispage_id ) )
      	return $thispage_id;
  	}*/
 
  	// OK, we're authenticated: we need to find and save the data
	$post = get_post($thispage_id);
	//if (($post->post_type == 'post') || ($post->post_type == 'page')) { 
           // OR $post->post_type != 'revision'
           $pais = $_POST['page_pais'];

	   //wp_set_object_terms( $thispage_id, $pais, 'pais' );
       wp_set_object_terms( $thispage_id, $pais, 'pais' );
        //}

	return $pais;
 
}


// añade menu de paises

function add_pais_menus() {
 
	// if ( ! is_admin() )
	// 	return;
 
	add_action('admin_menu', 'add_pais_box');
	add_action('save_page', 'save_taxonomy_data');
	//print_r($_POST);
	//echo $_POST['page_pais'];

}
 
add_pais_menus();



// This function gets called in edit-form-advanced.php
function your_styling_function($page) {
 
	echo '<input type="hidden" name="taxonomy_noncename" id="taxonomy_noncename" value="' . 
    		wp_create_nonce( 'taxonomy_pais' ) . '" />';
 
 
	// Get all pais taxonomy terms
	$paises = get_terms('pais', 'hide_empty=0'); 
 
?>
<select name='page_pais' id='page_pais'>
	<!-- Display paises as options -->
    <?php 
        $names = wp_get_object_terms($page->ID, 'pais'); 
        ?>
        <option class='pais-option' value='' 
        <?php if (!count($names)) echo "selected";?>>Ninguno</option>
        <?php
	foreach ($paises as $pais) {
		if (!is_wp_error($names) && !empty($names) && !strcmp($pais->slug, $names[0]->slug)) 
			echo "<option class='pais-option' value='" . $pais->slug . "' selected>" . $pais->name . "</option>\n"; 
		else
			echo "<option class='pais-option' value='" . $pais->slug . "'>" . $pais->name . "</option>\n"; 
	}
   ?>
</select>  

<?php

}







