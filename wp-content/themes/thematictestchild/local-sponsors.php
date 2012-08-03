<div class ="sponsorFooter">
	 


	 <ul class="displaySponsorsLocales"> 
        <?php  
        $term = get_term_by( 'slug', get_query_var('term'), get_query_var('taxonomy') );
        query_posts( array( 'post_type' => 'dal_country_sponsor', 'pais'=>$term->name, 'paged' => get_query_var('taxonomy'), 'posts_per_page' => 30, 'orderby' => 'title', 'order' => 'DESC' ) ); ?>
       
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                    <li>
                        <?php 

							if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
								?>
							<a href="<?php the_permalink(); ?>"> <?php  the_post_thumbnail(); ?></a>
							
						<?php 
								}  
							else
								{
						?>

							<a href=" <?php the_permalink(); ?> "> <?php the_title(); ?> </a>
						
						<?php

							}	
						?>
                	
                    </li>
                  
                      
             <?php endwhile; else: ?>
            <?php endif; ?>
			
   	 	<?php wp_reset_query();  ?>
     </ul>   
	

</div>

