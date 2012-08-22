<?php
/*
Plugin Name: DAL Functionality Plugin
Description: Crea países
Version: 0.1
License: GPL
Author: Montserrat Lobos for Ciudadano Inteligente
Author URI: http://ciudadanointeligente.org
*/


//
// 1- Agrega taxonomía "paises" con dropdown para pages.
//

add_action( 'init', 'create_pais_taxonomy', 0 );

 
function create_pais_taxonomy() {
	if (!taxonomy_exists('pais')) {
		register_taxonomy( 'pais', array( 'page','dal_country_sponsor', 'post' ), array( 'hierarchical' => false, 'label' => __('Pais'), 'query_var' => 'pais', 'rewrite' => array( 'slug' => 'pais' ) ) );
 
		  wp_insert_term('Argentina', 'pais');
      wp_insert_term('Bolivia', 'pais');
      wp_insert_term('Brasil', 'pais');
      wp_insert_term('Chile', 'pais');
      wp_insert_term('Colombia', 'pais');
      wp_insert_term('Costa Rica', 'pais');
      wp_insert_term('Cuba', 'pais');
      wp_insert_term('Ecuador', 'pais');
      wp_insert_term('El Salvador', 'pais');
      wp_insert_term('Guatemala', 'pais');
      wp_insert_term('Haití', 'pais');
      wp_insert_term('Honduras', 'pais');
      wp_insert_term('México', 'pais');
      wp_insert_term('Nicaragua', 'pais');
      wp_insert_term('Panamá', 'pais');
      wp_insert_term('Paraguay', 'pais');
      wp_insert_term('Perú', 'pais');
      wp_insert_term('República Dominicana', 'pais');
      wp_insert_term('Uruguay', 'pais');
      wp_insert_term('Venezuela', 'pais');
	}
}


 

 function add_pais_box() {
 	remove_meta_box('tagsdiv-pais', 'page','core');
  remove_meta_box('tagsdiv-pais', 'post','core');
  remove_meta_box('tagsdiv-pais', 'dal_country_sponsor','core');
	add_meta_box('pais_box_ID', __('Pais'), 'your_styling_function','page', 'side', 'core');
  add_meta_box('pais_box_ID', __('Pais'), 'your_styling_function','post', 'side', 'core');
  add_meta_box('pais_box_ID', __('Pais'), 'your_styling_function','dal_country_sponsor', 'side', 'core');
}	
 
function add_pais_menus() {
 
	if ( ! is_admin() )
		return;
 
	add_action('admin_menu', 'add_pais_box');

	//Use the save_post action to save new post data 
	add_action('save_post', 'save_taxonomy_data');
}
 
add_pais_menus();

// This function gets called in edit-form-advanced.php
function your_styling_function($post) {
 
	echo '<input type="hidden" name="taxonomy_noncename" id="taxonomy_noncename" value="' . 
    		wp_create_nonce( 'taxonomy_pais' ) . '" />';
 
 
	// Get all pais taxonomy terms
	$paises = get_terms('pais', 'hide_empty=0'); 
 
?>
<select name='post_pais' id='post_pais'>
	<!-- Display paises as options -->
    <?php 
        $names = wp_get_object_terms($post->ID, 'pais'); 
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

function save_taxonomy_data($post_id) {
// verify this came from our screen and with proper authorization.
 
 	if ( !wp_verify_nonce( $_POST['taxonomy_noncename'], 'taxonomy_pais' )) {
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
	if (($post->post_type == 'dal_country_sponsor') || ($post->post_type == 'page') || ($post->post_type == 'post') || ($post->post_type == 'portfolio')){ 
           // OR $post->post_type != 'revision'
           $pais = $_POST['post_pais'];
	   wp_set_object_terms( $post_id, $pais, 'pais' );
        }
	return $pais;
 
}


//
//======== 2- Let's register aur cuntry page custom sidebar
//
if ( function_exists ('register_sidebar')) { 
   register_sidebar(array(
  'name' => __( 'Country page sidebar' ),
  'id' => 'right-sidebar',
  'description' => __( 'Widgets in this area will be shown on the country pages.' ),
  'before_title' => '<h3>',
  'after_title' => '</h3>'
  ));

}
/* Puts content above the asides
function my_above_asides() { ?>
put the code to display your content here
<?php }

add_action('thematic_abovemainasides', 'my_above_asides');
*/




//
//========3-Let's create our "sponsors" CPT
//



add_action( 'init', 'create_dal_post_type' );
function create_dal_post_type() {
  register_post_type( 'dal_country_sponsor',
    array(
      'labels' => array(
        'name' => __( 'Sponsors' ),
        'singular_name' => __( 'Sponsor' ),
        'add_new' => _x('Add New', 'Sponsor'),
        'add_new_item' => __('Add New Sponsor'),
        'edit_item' => __('Edit Sponsor'),
        'new_item' => __('New Sponsor'),
        'all_items' => __('All Sponsors'),
        'view_item' => __('View Sponsor'),
        'search_items' => __('Search Sponsors'),
        'not_found' =>  __('No Sponsors found'),
        'not_found_in_trash' => __('No Sponsors found in Trash'), 
        'parent_item_colon' => '',
        'menu_name' => __('Sponsors')
      ),
    'public' => true,
    'has_archive' => false,
    'supports' => array( 'title', 'thumbnail', 'excerpt' )
    )
  );
  register_post_type( 'dal_regional_sponsor',
    array(
      'labels' => array(
        'name' => __( 'Sponsors Regionales' ),
        'singular_name' => __( 'Sponsor Regional' ),
        'add_new' => _x('Add New', 'Sponsor Regional'),
        'add_new_item' => __('Add New Regional Sponsor'),
        'edit_item' => __('Edit Regional Sponsor'),
        'new_item' => __('New Regional Sponsor'),
        'all_items' => __('All Regional Sponsors'),
        'view_item' => __('View Regional Sponsor'),
        'search_items' => __('Search Regional Sponsors'),
        'not_found' =>  __('No Regional Sponsors found'),
        'not_found_in_trash' => __('No Regional Sponsors found in Trash'), 
        'parent_item_colon' => '',
        'menu_name' => __('Regional Sponsors')
      ),
    'public' => true,
    'has_archive' => false,
    'supports' => array( 'title', 'thumbnail', 'excerpt', 'custom-fields' )
    )
  );
}

//
//
//======================== add apppais
//
//
//
// 4- Agrega taxonomía "apppais" con dropdown para cpt apps./ importante para que no se confundan las queries de apps con las del blog
//

 

 function add_apppais_box() {
  remove_meta_box('tagsdiv-apppais', 'portfolio','core');
  add_meta_box('apppais_box_ID', __('apppais'), 'apppais_styling_function','portfolio','side','high');
} 
 
function add_apppais_menus() {
 
  if ( ! is_admin() )
    return;
 
  add_action('admin_menu', 'add_apppais_box');

  //Use the save_post action to save new post data 
  add_action('save_post', 'save_apppais_data');
}
 
add_apppais_menus();


// This function gets called in edit-form-advanced.php
function apppais_styling_function($post) {
 
  echo '<input type="hidden" name="taxonomy_noncename" id="taxonomy_noncename" value="' . 
        wp_create_nonce( 'taxonomy_apppais' ) . '" />';
 
 
  // Get all apppais taxonomy terms
  $apppaises = get_terms('apppais', 'hide_empty=0'); 
 
?>
<select name='post_apppais' id='post_apppais'>
  <!-- Display apppaises as options -->
    <?php 
        $names = wp_get_object_terms($post->ID, 'apppais'); 
        ?>
        <option class='apppais-option' value='' 
        <?php if (!count($names)) echo "selected";?>>Ninguno</option>
        <?php
  foreach ($apppaises as $apppais) {
    if (!is_wp_error($names) && !empty($names) && !strcmp($apppais->slug, $names[0]->slug)) 
      echo "<option class='apppais-option' value='" . $apppais->slug . "' selected>" . $apppais->name . "</option>\n"; 
    
    else
      echo "<option class='apppais-option' value='" . $apppais->slug . "'>" . $apppais->name . "</option>\n"; 
  }

   ?>
</select>    
<?php
}

function save_apppais_data($post_id) {
// verify this came from our screen and with proper authorization.
 
  if ( !wp_verify_nonce( $_POST['taxonomy_noncename'], 'taxonomy_apppais' )) {
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
  if (($post->post_type == 'dal_country_sponsor') || ($post->post_type == 'page') || ($post->post_type == 'post') || ($post->post_type == 'portfolio')){ 
           // OR $post->post_type != 'revision'
           $apppais = $_POST['post_apppais'];
     wp_set_object_terms( $post_id, $apppais, 'apppais' );
        }
  return $apppais;
 
}

//
//=========== 5- Include metaboxes for apppais

require_once( dirname( __FILE__ ) . '/includes/apppais_metaboxes.php' );






