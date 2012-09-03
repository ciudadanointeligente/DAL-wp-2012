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
          
        <?php get_sidebar('pais'); ?>


<?php get_footer(); ?>