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
  <header class="jumbotron masthead nolist">
    <div class="inner">
      <div class="row">
        <div class="span7">
          <div class="row">
            <div class="span5">
               <?php
                if ( function_exists('dynamic_sidebar')) dynamic_sidebar("hero-left");
                ?>
            </div>
            <div class="span2">
              a
            </div>    
          </div>  
        </div><!--/span4-->

        <div class="span5">

          <?php
              if ( function_exists('dynamic_sidebar'));
              echo '<div class="row">'.dynamic_sidebar("hero-right").'</div>';
          ?>
          <div class="row">
           <?php wp_nav_menu( array( 'theme_location' => 'hero-menu', 'container_class' => 'hero-menu' ) ); ?>
         </div><!--/row-->

        </div><!--/span4-->
      </div><!--/row-->
      <hr class="soften">
      <?php the_content();?>
      <hr class="soften">
    </div>


  </header>
<?php endwhile; endif; ?>

<div class="marketing">
  <div class="row">
    <div class="span4">a
      <?php
      if ( function_exists('dynamic_sidebar')) dynamic_sidebar("home-left");
      ?>
    </div>
    <div class="span4">b
      <?php
      if ( function_exists('dynamic_sidebar')) dynamic_sidebar("home-middle");
      ?>
    </div>
    <div class="span4">c
      <?php
      if ( function_exists('dynamic_sidebar')) dynamic_sidebar("home-right");
      ?>
    </div>
  </div>
</div><!-- /.marketing -->
<?php get_footer();?>
