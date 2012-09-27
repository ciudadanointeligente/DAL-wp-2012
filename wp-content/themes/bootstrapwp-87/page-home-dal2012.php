<?php
/**
 *
 * Template Name: Home DAL 2012
 *
 *
 * @package WP-Bootstrap
 * @subpackage Default_Theme
 * @since WP-Bootstrap 0.5
 *
 * Last Revised: March 4, 2012
 */
get_header(); ?>
<div class="container">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <header class="jumbotron nolist">
  
       
            <div class="row">
              <div class="blackground span">
                <div class="span5">
                  <?php
                    if ( function_exists('dynamic_sidebar')) dynamic_sidebar("hero-left");
                  ?>
         
                  <?php
                      if ( function_exists('dynamic_sidebar'));
                      echo '<div class="row">'.dynamic_sidebar("hero-right").'</div>';
                  ?>
                </div>
                <div class="span5">
                  <?php wp_nav_menu( array( 'theme_location' => 'hero-menu', 'container_class' => 'hero-menu' ) ); ?> 
                </div><!--/row-->
             
               
            </div>  
         <div class="blackbottom span"> 
              </div>
                
</header>

    <div class="row wrapper">
       <div class="row">
        
             <?php
              if ( function_exists('dynamic_sidebar')) dynamic_sidebar("home-left");
              ?>
     
              <?php
              if ( function_exists('dynamic_sidebar')) dynamic_sidebar("home-middle");
              ?>
      
      
             <?php
              if ( function_exists('dynamic_sidebar')) dynamic_sidebar("home-right");
              ?>
             
      </div>
    </div>  
       <hr class="soften">
      <?php the_content();?>
      <?php endwhile; endif; ?>
      <hr class="soften">
  </div>  
<?php get_footer();?>
