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
	<div class="well sidebar-nav ">
          <?php

		$termpais = get_the_terms($post->ID, 'pais');
		//print_r($term);

	        query_posts( array( 'post_type' => 'dal_country', 'pais'=>array_pop($termpais)->name, 'paged' => get_query_var('taxonomy'), 'posts_per_page' => 1, 'orderby' => 'date_add()', 'order' => 'DESC' ) ); ?>
	       
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	                    <?php get_template_part('content','dal_country')?>

	                      
	             <?php endwhile; else: ?>
	            <?php endif; ?>
	            </ul>  
	           
	   	 	<?php wp_reset_query();  ?>
<script>
		$("li.pagenav ul").addClass("nav nav-pills nav-stacked");
</script>
	    <!-- aside con sibling menu --> 
		<ul class="nav nav-pills nav-stacked">
			<?php


			if($post->post_parent) { // page is a child

			wp_list_pages('sort_column=menu_order&title_li= &child_of='.$post->post_parent);

			}

			elseif(wp_list_pages("child_of=".$post->ID."&echo=0")) { // page has children

			wp_list_pages('sort_column=menu_order&title_li= &child_of='.$post->ID);
			}
			?>

		</ul>
		<?php // calling the sponsors area
        	get_template_part( 'local-sponsors' );

        	//calling the organizers
        	get_template_part( 'local-organizers' );

        	// calling the latest post area
        	get_template_part( 'country-posts-list' );
        	
        	// Get country page basic info 
        	?>
	</div><!--/.well .sidebar-nav -->
</div><!-- /.span4 -->
</div><!-- /.row .content -->

