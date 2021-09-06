<?php if(!is_admin()) { ?>
	<div class="sidebar sidebarCats g_grid_3">
				<div class="sideWidget">
					<h3>Filter By: Category</h3>
					<ul class="listing-cat">
						<li class="current_menu_item deskFilter">
							<a href="#">
								<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
									 viewBox="0 0 41.5 42.7" style="enable-background:new 0 0 41.5 42.7;" xml:space="preserve">
								<style type="text/css">
									.st0{fill:#EC6C84;}
								</style>
								<path id="heart" class="st0" d="M20.8,15.3c0,0-1.6-3.3-5.1-3.3c-3.9,0-5.9,3.3-5.9,6.5c0,5.4,11,12.2,11,12.2S31.7,24,31.7,18.5
									c0-3.3-2.1-6.5-5.8-6.5C23.7,12,21.7,13.3,20.8,15.3z"/>
								</svg>
								All Categories
							</a>
						</li>

						<li class="current_menu_item toggleMobFilter">
							<a href="#">
								<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
									 viewBox="0 0 41.5 42.7" style="enable-background:new 0 0 41.5 42.7;" xml:space="preserve">
								<style type="text/css">
									.st0{fill:#EC6C84;}
								</style>
								<path id="heart" class="st0" d="M20.8,15.3c0,0-1.6-3.3-5.1-3.3c-3.9,0-5.9,3.3-5.9,6.5c0,5.4,11,12.2,11,12.2S31.7,24,31.7,18.5
									c0-3.3-2.1-6.5-5.8-6.5C23.7,12,21.7,13.3,20.8,15.3z"/>
								</svg>
								All Categories
							</a>
						</li>
						<div>
						<?php 
						$args = array( 'hide_empty=0' );
		 
						$terms = get_terms( 'listing-category', $args );
						if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
						    $count = count( $terms );
						    $i = 0;
						    foreach ( $terms as $term ) {
						        $i++;
						        $term_list .= '<li><a href="' . esc_url( get_term_link( $term ) ) . '" alt="' . esc_attr( sprintf( __( 'View all listings in %s', 'atw' ), $term->name ) ) . '">' . $term->name . '</a></li>';
						        
						    }
						    echo $term_list;
						}
						?>
						</div>
					</ul>
				</div>

				<div class="sideWidget">
					<h3>Filter By: Location</h3>

					<div class="select">
						<div class="defaultoption" data-value="locationFilter">
							<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
									 viewBox="0 0 41.5 42.7" style="enable-background:new 0 0 41.5 42.7;" xml:space="preserve">
								<style type="text/css">
									.st0{fill:#EC6C84;}
								</style>
								<path id="heart" class="st0" d="M20.8,15.3c0,0-1.6-3.3-5.1-3.3c-3.9,0-5.9,3.3-5.9,6.5c0,5.4,11,12.2,11,12.2S31.7,24,31.7,18.5
									c0-3.3-2.1-6.5-5.8-6.5C23.7,12,21.7,13.3,20.8,15.3z"/>
								</svg>
								Select Location
						</div>
						<div class="options" id="locationFilter">
							<?php 
							$taxonomies = get_terms( array(
							    'taxonomy' => 'listing-location',
							    'hide_empty' => false
							) );
							 
							if ( !empty($taxonomies) ) :
							    $output = '<select>';
							    foreach( $taxonomies as $category ) { ?>

							        <a class="option" href="<?php echo get_bloginfo('url') . '/listing-location/' . $category->slug;?>"><?php echo esc_attr( $category->name );?></a>

							    <?php }
							endif;?>

						</div>
					</div>
				</div>
			</div>

<?php } ?>