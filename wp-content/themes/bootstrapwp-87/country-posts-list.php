
<?php
$term = get_the_terms($post->ID, 'pais');
//print_r($term);

query_posts( array( 'post_type' => 'post', 'pais'=>array_pop($term)->name, 'paged' => get_query_var('taxonomy'), 'posts_per_page' => 30, 'orderby' => 'title', 'order' => 'DESC' ) ); 
?>



    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <div class=" well">  
    <div class="row"> 
        <div class="span4">  
    <h3> Ultimos posts</h3>
        <ul>
            <li>
           
                    <a href=" <?php the_permalink(); ?> "> <?php the_title(); ?> </a>
                
            
            </li>
         
       </ul>      
         </div>
    </div>
</div>
   
     <?php endwhile; else: ?>
    <?php endif; ?>
    
   
<?php wp_reset_query();  ?>
   



