<?php
/*
 *
 * Template Name: country_page
 * Description: Page template for country pages
 *
 * @package WordPress
 * @subpackage WP-Bootstrap/ dal2012
 * @since WP-Bootstrap 0.1
 */

get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
  <div class="row">
  <div class="container countryPage">
  	thhis is country page, welcome!
   <?php if (function_exists('bootstrapwp_breadcrumbs')) bootstrapwp_breadcrumbs(); ?>
   </div><!--/.container -->
   </div><!--/.row -->
   <div class="container">

      
 <!-- Masthead
      ================================================== -->
      <header class="jumbotron subhead" id="overview">
        <h1 class="country"><?php the_title();?></h1> 
      </header>
         
        <div class="row content">
			<div class="span8">
				<?php the_content();?>
				<?php endwhile; // end of the loop. ?>
	        </div><!-- /.span8 -->
          
        <?php get_sidebar(); 

        	// calling the sponsors area
        	get_template_part( 'local-sponsors' );

        	// calling the latest post area
        	get_template_part( 'country-posts-list' );



	    ?>

	    <!-- aside con sibling menu --> 
		<aside>
			aside menu
			<?php

			if($post->post_parent) { // page is a child

			wp_list_pages('sort_column=menu_order&title_li= &child_of='.$post->post_parent);

			}

			elseif(wp_list_pages("child_of=".$post->ID."&echo=0")) { // page has children

			wp_list_pages('sort_column=menu_order&title_li= &child_of='.$post->ID);
			}
			?>

			-----
			-----

			<?php

			$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

			if ($term->parent == 0) { 

			wp_list_categories('taxonomy=pais&depth=1&show_count=0

			&title_li=&child_of=' . $term->term_id);

			} else {

			wp_list_categories('taxonomy=pais&show_count=0

			&title_li=&child_of=' . $term->parent); 

			}

			?>


		</aside>


<?php get_footer(); ?>