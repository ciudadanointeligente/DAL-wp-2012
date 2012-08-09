<?php
/**
 * Single Post Template
 *
 * …
 * 
 * @package Thematic
 * @subpackage Templates
 */

    // calling the header.php
    get_header();

    // action hook for placing content above #container
    thematic_abovecontainer();
?>

		<div id="container">
			hola portfolioooooo
			
			<?php
				// action hook for placing content above #content
				thematic_abovecontent();
						
				// filter for manipulating the element that wraps the content 
				echo apply_filters( 'thematic_open_id_content', '<div id="content">' . "\n\n" );
							
	            // start the loop
	            while ( have_posts() ) : the_post(); 

    	        // create the navigation above the content
				thematic_navigation_above();
		
    	        // calling the widget area 'single-top'
    	        get_sidebar('single-top');
		
    	        // action hook creating the single post
    	        //
    	        //
    	        thematic_abovepost();
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
	            	thematic_postheader();
	            ?>
     				
					<div class="entry-content">
						<?php the_post_thumbnail( $size, $attr ); ?> 
						<?php thematic_content(); ?>

						<?php wp_link_pages('before=<div class="page-link">' . __('Pages:', 'thematic') . '&after=</div>') ?>
						
					</div><!-- .entry-content -->
					
					<?php// thematic_postfooter(); ?>
					
				</div><!-- #post -->
		<?php
			// action hook for insterting content below #post
			thematic_belowpost();
    	        ?>
				<h1>eeeeee</h1>		
    	        <?php
			
    	        // calling the widget area 'single-insert'
    	        get_sidebar('single-insert');
		
    	        // create the navigation below the content
				thematic_navigation_below();
		
       			// action hook for calling the comments_template
    	        thematic_comments_template();
    	        
    	        // end the loop
        		endwhile;
		
    	        // calling the widget area 'single-bottom'
    	        get_sidebar('single-bottom');
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