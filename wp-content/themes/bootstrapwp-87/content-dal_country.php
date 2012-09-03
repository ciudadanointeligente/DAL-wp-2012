 <article>
	<div class="infoApp row" >
			<div class="fullcentered" > 
				
				<?php 
				$post_meta_data = get_post_custom($post->ID); 
				echo'<a class= "btn btn-large btn-primary span2" href="'.$post_meta_data[country_inscribete][0].'" ><i class="icon-pencil icon-white"></i>  Inscríbete en '.get_the_title().'</a>';?>	
				
				<ul class='span'>
					</br>
					<li>
						<?php
							$terms = get_the_terms( $post->ID, 'apps_tracks' );
													
							if ( $terms && ! is_wp_error( $terms ) ) : 

								$apps_tracks_terms = array();

								foreach ( $terms as $term ) {
									$apps_tracks_terms[] = $term->name;
								}
													
								$apps_tracks = join( ", ", $apps_tracks_terms );
							?>

							<p class="tracks">
								<span> (Tracks)</span><br />
								<span><em><?php echo $apps_tracks; ?></em></span>
							</p>

							<?php endif; ?>
						
					</li>
					<hr/>
					<li>
							<?php  $country_venue = get_post_meta($post->ID, 'country_venue', true);
							if (!empty($country_venue)){
								foreach ($country_venue as $key => $venue) {
								  	echo '<p class="venue">'.$venue.'</p>'; // echo out the member	
								}  
							}
					 		?>	
					</li>
				</ul>
				<?php echo'<a class= "btn btn-small btn-alert span2" href="'.$post_meta_data[country_datasets][0].'" >Datos disponibles en '.get_the_title().'</a>';?>	

			</div><!--/details-->

	</div>
</article>


