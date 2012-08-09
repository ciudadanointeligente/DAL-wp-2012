<?php
/**
 * This file contains the Dal_apps_Portfolio class.
 *
 * This class handles the creation of the "Portfolio" post type, and creates a
 * UI to display the Portfolio-specific data on the admin screens.
 */

class Dal_apps_Portfolio {

    /**
     * Construct Method
     */
    function __construct() {

        /** Post Type and Taxonomy creation */
	add_action( 'init', array( $this, 'create_post_type' ) );
	add_action( 'init', array( $this, 'create_taxonomy' ) );

        /** Post Thumbnail Support */
        add_action( 'after_setup_theme', array( $this, 'add_post_thumbnail_support' ), '9999' );
	add_image_size( 'portfolio-mini', 125, 125, TRUE );
	add_image_size( 'portfolio-thumb', 275, 200, TRUE );
	add_image_size( 'portfolio-large', 620, 9999 );

        /** Modify the Post Type Admin Screen */
        add_action( 'admin_head', array( $this, 'admin_style' ) );
	add_filter( 'manage_edit-portfolio_columns', array( $this, 'columns_filter' ) );
	add_action( 'manage_posts_custom_column', array( $this, 'columns_data' ) );
	add_filter( 'post_updated_messages', array( $this, 'updated_messages' ) );

        /** Add our Scripts */
	add_action( 'init', array( $this , 'register_script' ) );
	add_action( 'wp_footer', array( $this , 'print_script' ) );
	add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_css' ) );

        /** Create/Modify Dashboard Widgets */
	add_action( 'right_now_content_table_end', array( $this, 'right_now' ) );
	add_action( 'wp_dashboard_setup', array( $this, 'register_dashboard_widget' ) );

        /** Add Shortcode */
	add_shortcode( 'dal_portfolio', array( $this, 'dal_portfolio_shortcode' ) );
        add_filter( 'widget_text', 'do_shortcode' );

    }

    /**
     * This var is used in the shortcode to flag the loading of javascript
     * @var type boolean
     */
    static $load_js;


    /**
     * Create Portfolio Post Type
     *
     * @since 0.9
     */
    function create_post_type() {

	$args = apply_filters( 'dal_apps_portfolio_post_type_args',
	    array(
		'labels' => array(
		    'name' => __( 'dal_portfolio', 'acp' ),
		    'singular_name' => __( 'dal_portfolio', 'acp' ),
		    'add_new' => __( 'Add New', 'acp' ),
		    'add_new_item' => __( 'Add New dal_portfolio Item', 'acp' ),
		    'edit' => __( 'Edit', 'acp' ),
		    'edit_item' => __( 'Edit dal_portfolio Item', 'acp' ),
		    'new_item' => __( 'New Item', 'acp' ),
		    'view' => __( 'View dal_portfolio', 'acp' ),
		    'view_item' => __( 'View dal_portfolio Item', 'acp' ),
		    'search_items' => __( 'Search dal_portfolio', 'acp' ),
		    'not_found' => __( 'No dal_portfolio items found', 'acp' ),
		    'not_found_in_trash' => __( 'No dal_portfolio items found in Trash', 'acp' )
		),
		'public' => true,
		'query_var' => true,
		'menu_position' => 20,
		'menu_icon' => ACP_URL . 'images/portfolio-icon-16x16.png',
		'has_archive' => false,
		'supports' => array( 'title', 'editor', 'thumbnail' ),
		'rewrite' => array( 'slug' => 'dal_portfolio', 'with_front' => false )
	    )
	);

	register_post_type( 'dal_portfolio' , $args);
    }

    /**
     * Create the Custom Taxonomy
     *
     * @since 0.9
     */
    function create_taxonomy() {

	$args = apply_filters( 'dal_apps_portfolio_taxonomy_args',
	    array(
		'labels' => array(
		    'name' => __( 'Features', 'acp' ),
		    'singular_name' => __( 'Feature', 'acp' ),
		    'search_items' =>  __( 'Search Features', 'acp' ),
		    'popular_items' => __( 'Popular Features', 'acp' ),
		    'all_items' => __( 'All Features', 'acp' ),
		    'parent_item' => null,
		    'parent_item_colon' => null,
		    'edit_item' => __( 'Edit Feature' , 'acp' ),
		    'update_item' => __( 'Update Feature', 'acp' ),
		    'add_new_item' => __( 'Add New Feature', 'acp' ),
		    'new_item_name' => __( 'New Feature Name', 'acp' ),
		    'separate_items_with_commas' => __( 'Separate features with commas', 'acp' ),
		    'add_or_remove_items' => __( 'Add or remove features', 'acp' ),
		    'choose_from_most_used' => __( 'Choose from the most used features', 'acp' ),
		    'menu_name' => __( 'Features', 'acp' ),
		),
		'hierarchical' => false,
		'show_ui' => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var' => true,
		'rewrite' => array( 'slug' => 'feature' )
	    )
	);


	register_taxonomy( 'feature', 'portfolio', $args );

    }

    /**
     * Correct messages when Portfolio post type is saved
     *
     * @global type $post
     * @global type $post_ID
     * @param type $messages
     * @return type
     * @since 0.9
     */
    function updated_messages( $messages ) {
	global $post, $post_ID;

	$messages['portfolio'] = array(
	    0 => '', // Unused. Messages start at index 1.
	    1 => sprintf( __('Portfolio Item updated. <a href="%s">View portfolio item</a>'), esc_url( get_permalink($post_ID) ) ),
	    2 => __('Custom field updated.'),
	    3 => __('Custom field deleted.'),
	    4 => __('Portfolio item updated.'),
	    /* translators: %s: date and time of the revision */
	    5 => isset($_GET['revision']) ? sprintf( __('Portfolio item restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
	    6 => sprintf( __('Portfolio item published. <a href="%s">View portfolio item</a>'), esc_url( get_permalink($post_ID) ) ),
	    7 => __('Portfolio item saved.'),
	    8 => sprintf( __('Portfolio item submitted. <a target="_blank" href="%s">Preview portfolio item</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	    9 => sprintf( __('Portfolio item scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview portfolio item</a>'),
	      // translators: Publish box date format, see http://php.net/date
	      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
	    10 => sprintf( __('Portfolio item draft updated. <a target="_blank" href="%s">Preview portfolio item</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);

      return $messages;
    }

    /**
     * Filter the columns on the admin screen and define our own
     *
     * @param type $columns
     * @return string
     * @since 0.9
     */
    function columns_filter ( $columns ) {

	$columns = array(
	    'cb' => '<input type="checkbox" />',
	    'portfolio_thumbnail' => __( 'Image', 'acp' ),
	    'title' => __( 'Title', 'acp' ),
	    'portfolio_description' => __( 'Description', 'acp' ),
	    'portfolio_features' => __( 'Features', 'acp' )
	);

	return $columns;
    }

    /**
     * Filter the data that shows up in the columns we defined above
     *
     * @global type $post
     * @param type $column
     * @since 0.9
     */
    function columns_data( $column ) {

	global $post;

	switch( $column ) {
	    case "portfolio_thumbnail":
		printf( '<p>%s</p>', the_post_thumbnail('portfolio-mini' ) );
		break;
	    case "portfolio_description":
		the_excerpt();
		break;
	    case "portfolio_features":
		echo get_the_term_list( $post->ID, 'feature', '', ', ', '' );
		break;
	}
    }

    /**
     * Check for post-thumbnails and add portfolio post type to it
     *
     * @global type $_wp_theme_features
     * @since 0.9
     */
    function add_post_thumbnail_support() {

	global $_wp_theme_features;

	if( !isset( $_wp_theme_features['post-thumbnails'] ) ) {

	    $_wp_theme_features['post-thumbnails'] = array( array( 'portfolio' ) );
	}

	elseif( is_array( $_wp_theme_features['post-thumbnails'] ) ) {

	    $_wp_theme_features['post-thumbnails'][0][] = 'portfolio';
	}
    }

    /**
     * Portfolio Shortcode
     *
     * @param type $atts
     * @param type $content
     * @since 0.9
     * @version 1.1
     */
    function dal_portfolio_shortcode( $atts, $content = null ) {
	/*
	Supported Attributes
	    link =>  page, image
	    thumb => any built-in image size
	    full => any built-in image size (this setting is ignored of 'link' is set to 'page')
            title => above, below or 'blank' ("yes" is converted to "above" for backwards compatibility)
	    display => content, excerpt (leave blank for nothing)
            heading => When displaying the 'feature' items in a row above the portfolio items, define the heading text for that section.
            orderby => date or any other orderby param available. http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters
            order => ASC (ascending), DESC (descending)
            terms => a 'feature' tag you want to filter on
            operator => 'IN', 'NOT IN' filter for the term tag above

	*/

	/**
	 * Currently 'image' is the only supported link option right now
	 *
	 * While 'page' is an available option, it can potentially require a lot of work on the part of the
	 * end user since the plugin can't possibly know what theme it's being used with and create the necessary
	 * page structure to properly integrate into the theme. Selecting page is only advised for advanced users.
	 */

	/** Load the javascript */
	self::$load_js = true;

	/** Shortcode defaults */
	$defaults = apply_filters( 'dal_apps_portfolio_shortcode_args',
	    array(
		'link' => 'image',
		'thumb' => 'portfolio-thumb',
		'full' => 'portfolio-large',
                'title' => 'above',
		'display' => '',
                'heading' => 'Display',
		'orderby' => 'date',
		'order' => 'desc',
                'terms' => '',
                'operator' => 'IN'
	    )
	);

	extract( shortcode_atts( $defaults, $atts ) );
        
        if( $title == "yes" ) $title == "above"; // For backwards compatibility

	/** Default Query arguments -- can be overridden by filter */
	$args = apply_filters( 'dal_apps_portfolio_shortcode_query_args',
	    array(
		'post_type' => 'dal_portfolio',
		'posts_per_page' => -1, // show all
                'meta_key' => '_thumbnail_id', // Should pull only items with featured images
		'orderby' => $orderby,
		'order' => $order,
	    )
	);

        /** If the user has defined any tax terms, then we create our tax_query and merge to our main query  */
        if( $terms ) {
            
            $tax_query_args = array(
                'tax_query' => array(
                    array(
                        'taxonomy' => 'feature',
                        'field' => 'slug',
                        'terms' => $terms,
                        'operator' => $operator  
                      )                    
                )            
            );
            
            /** Join the tax array to the general query */
            $args = array_merge( $args, $tax_query_args );
        }	

	$return = '';

        /** Create a new query based on our own arguments */
	$portfolio_query = new WP_Query( $args );

        if( $portfolio_query->have_posts() ) {
            
            $a ='';
            
            if( $terms ) {
                
                /** Change the get_terms argument based on the shortcode $operator */
                switch( $operator) {
                    case "IN":
                        $a = array( 'include' => $terms );
                        break;
                
                    case "NOT IN":
                        $a = array( 'exclude' => $terms );
                        break;
                
                    default:
                        break;
                }
                
            }

            /** We're simply recycling the variable at this point */
            $terms = get_terms( 'feature', $a );
            
            /** If there are multiple terms in use, then run through our display list */
            if( count( $terms ) > 1 )  {
                $return .= '<ul class="dal_apps-portfolio-features"><li class="dal_apps-portfolio-category-title">';
                $return .= $heading;
                $return .= '</li><li class="active"><a href="javascript:void(0)" class="all">all</a></li>';

                $term_list = '';

                /** break each of the items into individual elements and modify its output */
                foreach( $terms as $term ) {

                    $term_list .= '<li><a href="javascript:void(0)" class="' . $term->slug . '">' . $term->name . '</a></li>';
                }

                /** Return our modified list */
                $return .= $term_list . '</ul>';
            }

            $return .= '<ul class="dal_apps-portfolio-grid">';

            while( $portfolio_query->have_posts() ) : $portfolio_query->the_post();

                /** Get the terms list */
                $terms = get_the_terms( get_the_ID(), 'feature' );

                /** Add each term for a given portfolio item as a data type so it can be filtered by Quicksand */
                $return .= '<li data-id="id-' . get_the_ID() . '" data-type="';
                foreach ( $terms as $term ) {
                    $return .= $term->slug . ' ';
                }
                $return .= '">';

                /** Above image Title output */
                if( $title == "above" ) $return .= '<div class="dal_apps-portfolio-title">' . get_the_title() . '</div>';

                /** Handle the image link */
                switch( $link ) {
                    case "page" :
                        $return .= '<a href="' . get_permalink() . '" rel="bookmark">';
                        
			$return .= get_the_post_thumbnail( get_the_ID(), $thumb );
			$return .= '</a>';
                        break;

                    case "image" :
                        $_portfolio_img_url = wp_get_attachment_image_src( get_post_thumbnail_id(), $full );

                        $return .= '<a href="' . $_portfolio_img_url[0] . '" title="' . the_title_attribute( 'echo=0' ) . '" >';
                        $return .= get_the_post_thumbnail( get_the_ID(), $thumb );
                        $return .= '</a>';
                        break;

                    default : // If it's anything else, return nothing.
                        break;
                }

		/** Below image Title output */
                if( $title == "below" ) $return .= '<div class="dal_apps-portfolio-title">' . get_the_title() . '</div>';

                /** Display the content */
                switch( $display ) {
                    case "content" :
                        $return .= '<div class="dal_apps-portfolio-text">' . get_the_content() . '</div>';
                        break;

                    case "excerpt" :
                        $return .= '<div class="dal_apps-portfolio-text">' . get_the_excerpt() . '</div>';
                        break;

                    default : // If it's anything else, return nothing.
                        break;
                }

                $return .= '</li>';

            endwhile;

            $return .= '</ul>';
        }

	return $return;
    }


    /**
     * Add the Portfolio Post type to the "Right Now" Dashboard Widget
     *
     * @link http://bajada.net/2010/06/08/how-to-add-custom-post-types-and-taxonomies-to-the-wordpress-right-now-dashboard-widget
     * @since 0.9
     */
    function right_now() {
	include_once( dirname( __FILE__ ) . '/views/right-now.php' );
    }


    /**
     * Style the portfolio icon on the admin screen
     *
     * @since 0.9
     */
    function admin_style() {
	printf( '<style type="text/css" media="screen">.icon32-posts-portfolio { background: transparent url(%s) no-repeat !important; }</style>', ACP_URL . 'images/portfolio-icon-32x32.png' );
    }


    /**
     * Register the necessary javascript, which can be overriden by creating your own file and
     * placing it in the root of your theme's folder
     *
     * @since 1.0
     * @version 1.1.0
     */
    function register_script() {

        wp_register_script( 'jquery-quicksand', ACP_URL . 'includes/js/jquery.quicksand.js', array( 'jquery' ), '1.2.2', true );
        wp_register_script( 'jquery-easing', ACP_URL . 'includes/js/jquery.easing.1.3.js', array( 'jquery' ), '1.3', true );

	if( file_exists( get_stylesheet_directory() . "/dal_apps-portfolio.js" ) ) {
	    wp_register_script( 'dal_apps-portfolio-js', get_stylesheet_directory_uri() . '/dal_apps-portfolio.js', array( 'jquery-quicksand', 'jquery-easing' ), ACP_VERSION, true );
	}
	elseif( file_exists( get_template_directory() . "/dal_apps-portfolio.js" ) ) {
	    wp_register_script( 'dal_apps-portfolio-js', get_template_directory_uri() . '/dal_apps-portfolio.js', array( 'jquery-quicksand', 'jquery-easing' ), ACP_VERSION, true );
	}
	else {
            wp_register_script( 'dal_apps-portfolio-js', ACP_URL . 'includes/js/portfolio.js', array( 'jquery-quicksand', 'jquery-easing' ), ACP_VERSION, true );
	}
    }


    /**
     * Check the state of the variable. If true, load the registered javascript
     *
     * @since 1.0
     */
    function print_script() {

	if( ! self::$load_js )
	    return;

	wp_print_scripts( 'dal_apps-portfolio-js' );
    }


    /**
     * Load the plugin css. If the css file is present in the theme directory, it will be loaded instead,
     * allowing for an easy way to override the default template
     *
     * @since 0.9
     * @version 1.0
     */
    function enqueue_css() {

	if( file_exists( get_stylesheet_directory() . "/dal_apps-portfolio.css" ) ) {
	    wp_enqueue_style( 'dal_apps-portfolio', get_stylesheet_directory_uri() . '/dal_apps-portfolio.css', array(), ACP_VERSION );
	}
	elseif( file_exists( get_template_directory() . "/dal_apps-portfolio.css" ) ) {
	    wp_enqueue_style( 'dal_apps-portfolio', get_template_directory_uri() . '/dal_apps-portfolio.css', array(), ACP_VERSION );
	}
	else {
	    wp_enqueue_style( 'dal_apps-portfolio', plugins_url( '/portfolio.css', __FILE__), array(), ACP_VERSION );
	}
    }



}
?>