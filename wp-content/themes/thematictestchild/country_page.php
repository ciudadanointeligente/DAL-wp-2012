<?php
/*
Template Name: country_page
*/
?>
<?php
 
    // calling the header.php
    get_header();

?>

		<div id="container" class="countryPage">
			thhis is country page, welcome!
		
			<?php

				// filter for manipulating the element that wraps the content 
				echo apply_filters( 'thematic_open_id_content', '<div id="content">' . "\n" );
	
	            // start the loop
	            while ( have_posts() ) : the_post();

	        ?>
    	        
				<?php
					echo '<div id="post-' . get_the_ID() . '" ';
					// Checking for defined constant to enable Thematic's post classes
					if ( ! ( THEMATIC_COMPATIBLE_POST_CLASS ) ) {
						post_class();
						echo '>';
					} else {
						echo 'class="';
						thematic_post_class();
						echo '">';
					}
	                
	                // creating the post header
	                 
				?>
	                
	                <h2 class="entry-title country"><?php the_title(); ?></h2>
					<div class="entry-content">
	
						<?php
	                    	the_content();
	                    
	                    	wp_link_pages( "\t\t\t\t\t<div class='page-link'>" . __( 'Pages: ', 'thematic' ), "</div>\n", 'number' );
	                  
	                    ?>

					</div><!-- .entry-content -->
					
				</div><!-- #post -->
	
			<?php
				
       			// action hook for calling the comments_template
       			thematic_comments_template();
        		
	        	// end loop
        		endwhile;
	        
	        	// calling the sponsors area
	        	get_template_part( 'local-sponsors' );
	        ?>
	
			</div><!-- #content -->
			
			<?php 
				// action hook for placing content below #content
				thematic_belowcontent(); 
			?> 
			
		</div><!-- #container -->

<?php 
    // action hook for placing content below #container
    thematic_belowcontainer();

    // calling the standard sidebar 
    thematic_sidebar();
    
    // calling footer.php
    get_footer();
?>