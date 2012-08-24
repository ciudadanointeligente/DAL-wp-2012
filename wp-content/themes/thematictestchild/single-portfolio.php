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
	            ?>
     				
					<div class="">
			
					<article class="entryApp entry-content">
						<?php 
						// creating the post header
	            			thematic_postheader();
						// thematic_content(); 
	            		//getting post meta data
							$post_meta_data = get_post_custom($post->ID);
						?>

						<section class="infoApp">
							<div class="theThumbail">
								<?php the_post_thumbnail( $size, $attr ); ?> 
							</div>	
							<div class="detailsApp" style="float: right;"> 
								<ul id="infoAppUl">
									<li> 
										<strong>Equipo:</strong><span><?php echo $post_meta_data[custom_equipo][0]; ?></span>
									</li>
									<li> 
										<strong>País:</strong><span><?php echo $post_meta_data[custom_apppais][0]; ?></span>
									</li>
									<li> 
										<strong>Tema:</strong><span><?php echo $post_meta_data[custom_apps_tracks][0]; ?></span>
									</li>
									<li> 
										<strong>Github:</strong>
										<span>
											<?php echo'<a href="'.$post_meta_data[custom_github][0].'">'.$post_meta_data[custom_github][0].'</a>'; ?>
										</span>
									</li>
									<li><strong>Integrantes:</strong>
										<ul>
											<?php  $custom_integrantes = get_post_meta($post->ID, 'custom_integrante', true);
												foreach ($custom_integrantes as $key => $custom_integrante) {
												  	echo '<li>'.$custom_integrante.'</li>'; // echo out the url description of a post >	
												}  
									 		?>	
										</ul>
									</li>
								</ul>	
							</div>

							<div class="botonApp" style="clear: both; display: block; background: lightgrey; padding: 10px; text-align: center;">
								<?php 
								echo'<a href="'.$post_meta_data[custom_urlapp][0].'">Ver la app <br /><span>'.$post_meta_data[custom_urlapp][0].'</span></a>';?>
							</div>
			
						</section>
						<section class="descApp" style="float: left; width: 50%;">
							<?php 

								

								echo '<h3>Problemática</h3>';
								echo apply_filters('the_content', $post_meta_data['custom_problema'][0]);
								echo '<h3>Solución planteada</h3>';
								echo apply_filters('the_content', $post_meta_data['custom_solucion'][0]);  
								echo '<h3>Screencast</h3>';
								echo $post_meta_data[custom_screencast][0];  
								echo '<h3> Datos Utilizados</h3><ul class="databaseList">';

									$custom_databases = get_post_meta($post->ID, 'custom_database', true);
									
									foreach ($custom_databases as $key => $custom_database) {
										
										 echo '<li><a href="http://'. $custom_database .'">'. $custom_database .'</a></li>'; 
									}  
							
								echo '</ul>';

							?>
						</section>

						<aside>
							<h4> Sobre el equipo </h4>
							<ul>

							</ul>

						</aside>
-------<br/>
							

							

							
							
							<br />
							
							<br />
							
							
						</article>



						<?php wp_link_pages('before=<div class="page-link">' . __('Pages:', 'thematic') . '&after=</div>') ?>
						
					</div><!-- .entry-content -->
					
					<?php thematic_postfooter(); ?>
					
				</div><!-- #post -->
		<?php
			// action hook for insterting content below #post
			thematic_belowpost();
    	        ?>
				<h1>Below post h1 </h1>		
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