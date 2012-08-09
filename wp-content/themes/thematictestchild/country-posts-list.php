
<div class ="latestCountryPosts">
    <?php
        $term = get_the_terms($post->ID, 'pais');
        //print_r($term);

        query_posts( array( 'post_type' => 'post', 'pais'=>array_pop($term)->name, 'paged' => get_query_var('taxonomy'), 'posts_per_page' => 30, 'orderby' => 'title', 'order' => 'DESC' ) ); ?>
       
    <h3> Ultimos posts</h3>
    <ul>
    
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                    <li>
                   
                            <a href=" <?php the_permalink(); ?> "> <?php the_title(); ?> </a>
                        
                    
                    </li>
                 
                      
             <?php endwhile; else: ?>
            <?php endif; ?>
            </ul>  
           
        <?php wp_reset_query();  ?>

</div>



