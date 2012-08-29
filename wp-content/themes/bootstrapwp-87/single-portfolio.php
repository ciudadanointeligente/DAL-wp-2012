<?php
/**
 * Single app
 *
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 * @since WP-Bootstrap 0.1
 */

get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
  <div class="row">
  <div class="container">
   <?php if (function_exists('bootstrapwp_breadcrumbs')) bootstrapwp_breadcrumbs(); ?>
   </div><!--/.container -->
   </div><!--/.row -->
   <div class="container entryApp">
     
 <!-- Masthead
      ================================================== -->
      <header class="jumbotron subhead" id="overview">
        <h1><?php the_title();?></h1>
      </header>
         
        <div class="row content entryApp">
<div class="span8">
   <p class="meta"><?php echo bootstrapwp_posted_on();?></p>
            <?php 
            //getting the content
            the_content();

            //getting post meta data
			$post_meta_data = get_post_custom($post->ID);?>

             <!--the custom portfolio content-->

           		 <article class="">
						<section class="infoApp well">
							<div class="theThumbail">
								<?php the_post_thumbnail( $size, $attr ); ?> 
							</div>	
							<div class="detailsApp" > 
								<ul id="infoAppUl">
									<li> 
										<strong>Equipo:</strong><span><?php echo $post_meta_data[custom_equipo][0]; ?></span>
									</li>
									<li> 
										<strong>País:</strong><span><?php echo $post_meta_data[custom_apppais][0]; ?></span>
									</li>
									<li> 
										<strong>Tema:</strong><span><?php echo $post_meta_data[custom_apps_tracks][0]; ?></span>
									</li>
									<li> 
										<strong>Github:</strong>
										<span>
											<?php echo'<a href="'.$post_meta_data[custom_github][0].'">'.$post_meta_data[custom_github][0].'</a>'; ?>
										</span>
									</li>
									<li><strong>Integrantes:</strong>
										<ul> 
											<?php  $custom_integrantes = get_post_meta($post->ID, 'custom_integrante', true);
											if (!empty($custom_integrantes)){
												foreach ($custom_integrantes as $key => $custom_integrante) {
												  	echo '<li>'.$custom_integrante.'</li>'; // echo out the member	
												}  
											}
									 		?>	
										</ul>
									</li>
								</ul>	
							</div>

							<div class="well">

							<?php 
								echo'<a class= "btn .btn-large btn-primary" href="'.$post_meta_data[custom_urlapp][0].'">Ver la app <br /><small>'.$post_meta_data[custom_urlapp][0].'</small></a>';?>
							</div>
			
						</section>
						<section class="descApp">
							<?php 

								

								echo '<h3>Problemática</h3>';
								echo apply_filters('the_content', $post_meta_data[custom_problema][0]);
								echo '<h3>Solución planteada</h3>';
								echo apply_filters('the_content', $post_meta_data[custom_solucion][0]);  
								echo '<h3>Screencast</h3>';
								echo $post_meta_data[custom_screencast][0];  
								echo '<h3> Datos Utilizados</h3><ul class="databaseList">';

								$custom_databases = get_post_meta($post->ID, 'custom_database', true);
								if (!empty($custom_databases )){
									foreach ($custom_databases as $key => $custom_database) {
										
										 echo '<li><a href="http://'. $custom_database .'">'. $custom_database .'</a></li>'; 
									}  
								}
							
								echo '</ul>';

							?>
						</section>

						<aside>
							<h4> Sobre el equipo </h4>
							<ul>

							</ul>

						</aside>
-------<br/>
							

							

							
							
							<br />
							
							<br />
							
							
						</article>


        




            <?php the_tags( '<p>Tags: ', ', ', '</p>'); ?>
<?php endwhile; // end of the loop. ?>
<hr />
 <?php comments_template(); ?>

 <?php bootstrapwp_content_nav('nav-below');?>

          </div><!-- /.span8 -->
          <?php get_sidebar('blog'); ?>


<?php get_footer(); ?>

