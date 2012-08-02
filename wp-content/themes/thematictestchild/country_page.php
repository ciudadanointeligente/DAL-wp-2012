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

		<!-- aside con sibling menu --> 
		<aside>
			aside menu
			<?php

			if($post->post_parent) { // page is a child

			wp_list_pages('sort_column=menu_order&title_li= &child_of='.$post->post_parent);

			}

			elseif(wp_list_pages("child_of=".$post->ID."&echo=0")) { // page has children

			wp_list_pages('sort_column=menu_order&title_li= &child_of='.$post->ID);
			}
			?>

			-----
			-----

			<?php

			$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

			if ($term->parent == 0) { 

			wp_list_categories('taxonomy=pais&depth=1&show_count=0

			&title_li=&child_of=' . $term->term_id);

			} else {

			wp_list_categories('taxonomy=pais&show_count=0

			&title_li=&child_of=' . $term->parent); 

			}

			?>


		</aside>




<?php 
    // action hook for placing content below #container
    thematic_belowcontainer();

    // calling the standard sidebar 
    //thematic_sidebar();
    
    // calling footer.php
    get_footer();
?>