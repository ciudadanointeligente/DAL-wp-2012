<?php
/**
 * COUNTRY PAGE TEMPLATE
 * In this theme this is the default template for displaying pages.
 *
 * 
 * Description: Page template with a content container and right sidebar. 
 * Sidebar automatically loads: 
 * -A siblings menu 
 * -Organizers CPT called by taxonomy "Pais"
 * -A sponsors footer called by taxonomy "Pais"
 * -Latest posts on the same "Pais" taxonomy.
 * 
 *
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
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
          <?php 
            $termstax = get_the_terms($post->ID, 'pais');
            $count = count($termstax);
            if ( is_array($termstax) && $count > 0 ){
                get_sidebar('pais');
              }
            else {
                 echo get_sidebar();
                }    
        ?>


<?php get_footer(); ?>