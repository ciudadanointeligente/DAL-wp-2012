<div class ="sponsorFooter">
	 


	 <ul class="displayEquipo"> 
        <?php  
        $term = get_term_by( 'slug', get_query_var('term'), get_query_var('taxonomy') );
        query_posts( array( 'post_type' => 'dal_country_sponsor', 'pais'=>$term->name, 'paged' => get_query_var('taxonomy'), 'posts_per_page' => 30, 'orderby' => 'title', 'order' => 'DESC' ) ); ?>
       
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                
               
                    <li>
                        
    					<h3 class="archivePostTitle"><a href= <?php the_permalink(); ?> ><?php the_title(); ?></a></h3>
                	
                    </li>
                
                      
             <?php endwhile; else: ?>
            <?php endif; ?>
			
   	 	<?php wp_reset_query();  ?>
     </ul>   
	

</div>

 

 