<div class ="sponsorFooter">
	 


	 <ul class="displayEquipo"> 
        <?php  query_posts( array( 'post_type' => 'dal_country_sponsor', 'pais'=>'chile', 'paged' => get_query_var('page'), 'posts_per_page' => 30, 'orderby' => 'title', 'order' => 'DESC' ) ); ?>
       
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                
               
                    <li>
                        
    					<h3 class="archivePostTitle"><a href= <?php the_permalink(); ?> ><?php the_title(); ?></a></h3>
                	
                    </li>
                
                      
             <?php endwhile; else: ?>
            <?php endif; ?>
    
   	 	<?php wp_reset_query();  ?>
     </ul>   



</div>

 

 