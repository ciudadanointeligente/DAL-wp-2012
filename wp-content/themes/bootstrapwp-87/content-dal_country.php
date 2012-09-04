<article>
	<div class="infoApp row" >
		<div class="fullcentered" > 
			
			<?php 
			$post_meta_data = get_post_custom($post->ID); 
			echo'<a class= "btn btn-large btn-action span2" href="'.$post_meta_data[country_inscribete][0].'" ><i class="icon-pencil icon-white"></i>  Inscríbete en '.get_the_title().'</a>';?>	
			
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
			<?php 
				$country_link_id = $post_meta_data[country_post_id][0];
				$country_link = get_permalink($country_link_id);
				if (is_single() || is_post_type_archive( 'dal_country' )){
				echo'<a id="masInfoPais'.$country_link_id.'" class= "btn btn-medium btn-warning span2" href="'.$country_link.'" ><i class="icon-chevron-right icon-white"></i>  Más info de DAL en '.get_the_title().' </a>';
				}
				else{
					echo '';
				}			
			?>
				
			<?php echo'<a class= "btn btn-small span2" href="'.$post_meta_data[country_datasets][0].'" ><i class="icon-th"></i>  Datos disponibles en '.get_the_title().'</a>';?>
			
			
		
		</div><!--/details-->

	</div>
</article>


