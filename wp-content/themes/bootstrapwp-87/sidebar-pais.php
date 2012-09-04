<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 * @since WP-Bootstrap 0.1
 */
?>
	<div class="span4">
		<div class="sidebar-nav row">         	 	
		    <!-- aside con sibling menu --> 
			
				<?php
	        	//print_r($term);
				$termpais = get_the_terms($post->ID, 'pais');?>
				<nav class="span4">
					<ul class="nav nav-tabs nav-stacked ">
		        		<?php query_posts( array( 'post_type' => 'page', 'pais'=>array_pop($termpais)->name, 'paged' => get_query_var('taxonomy'), 'posts_per_page' => 30, 'orderby' => 'title', 'order' => 'DESC' ) ); ?>
		      			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	                 	    <li>
								<a href=" <?php the_permalink(); ?> "> <i class="icon-chevron-left light"></i>  <?php the_title(); ?> </a>
							</li>	
						<?php endwhile; else: ?>
	            		<?php endif; ?>
	           		</ul>  
	           <br/>
	   	 		<?php wp_reset_query();  ?>
		</div>
		<div class="well sidebar-nav ">
          <?php

        	// Get country page basic info 
			$termpais = get_the_terms($post->ID, 'pais');
	        query_posts( array( 'post_type' => 'dal_country', 'pais'=>array_pop($termpais)->name, 'paged' => get_query_var('taxonomy'), 'posts_per_page' => 1, 'orderby' => 'date_add()', 'order' => 'DESC' ) ); ?>
	       
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	                    <?php get_template_part('content','dal_country')?>

	                      
	             <?php endwhile; else: ?>
	            <?php endif; ?>
	          
		</div>  
		
			<?php // calling the latest post area
	    		get_template_part( 'country-posts-list' ); 
	    	?>
	</div><!-- /.span4 -->
</div><!-- /.row .content -->

