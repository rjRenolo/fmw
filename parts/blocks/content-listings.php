<?php
/**
 * Block Name: All Listings
 *
 */

// create id attribute for specific styling
$id = 'favlistings-' . $block['id'];

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';
$class = $block['className'];
?>

<div class="listings-blockcover atwcover-block textcenter">
	<div class="container">
	</div>
	<img src="<?php echo get_bloginfo('template_directory');?>/images/global/landscape.svg" alt="All things Wales" >
</div>


<div class="favlistings-block has-black-background-color has-white-color">
	<div class="container row">

			<div class="row listings-container">
			<?php 
			get_sidebar();

			$paged = (get_query_var('paged')) ? get_query_var('paged') : 0;

			$postsPerPage = 2;
			$postOffset = $paged * $postsPerPage;

			$args = array(
			    'posts_per_page'  => $postsPerPage,
			    'post_type'       => 'listing',
			    'paged'			  => $paged,
			    'orderby'		  => 'name',
			    'order'           => 'ASC'
			);

			$postslist = new WP_Query( $args );?>

				<div class="g_grid_9" role="main">
					<div class="row">
		    			<?php if ( $postslist->have_posts() ) :
		        		while ( $postslist->have_posts() ) : $postslist->the_post(); 
						?>
						

					    		<?php if(!is_admin()) { ?>

						       		<div class="listing-cat g_grid_4 has-white-color" data-aos="fade-up">
						       			<a href="<?php echo get_the_permalink(get_sub_field('blog'));?>">

						       				<?php if(get_field('listing_category_image',get_sub_field('blog')) == "") {
						       					$url = HOLDING_CAT_IMAGE;
						       				} else { 
						       					$url = acf_image_output_url(get_field('listing_category_image',get_sub_field('listing')), 'thumbnail');
						       				} ?>
						       				<div class="listing-cat-image" style="background-image:url( <?php echo $url;?> )">
						       				</div>
						       				<div class="listing-cat-content">
						       					<h3><?php echo get_the_title($post->ID);?></h3>

						       					<?php 
						       					$loop = 1;
						       					$cats = "";
						       					foreach((get_the_category(get_sub_field('blog'))) as $category){
						       						if($loop > 1) {
						       							$cats .= $cat . ', ';
						       						}
										        	$cats .= $category->name;
										        	$loop++;
										        }
												?>
						       					<?php if(!get_field('listing_selection', get_sub_field('blog')) == "") { ?>
						       						<p class="listing-cat-supplier"><span>From:</span> <?php echo get_the_title(get_field('listing_selection',get_sub_field('blog')));?></p>
						       					<?php } ?>
						       					<p class="listing-cat-cat"><span>Posted in:</span> <?php echo $cats;?></p>
						       					<p class="has-red-color listing-link">See Article</p>
						       				</div>
						       			</a>
						       		</div>

						       	<?php } else { ?>
									<h3><?php echo get_the_title(get_sub_field('blog'));?></h3>
						       	<?php } ?>

						<?php endwhile; endif?>
					</div>
					<div class="pagination row">
						<span class="pagNext">
							<?php next_posts_link( 'Next', $postslist->max_num_pages );?>
						</span>
						<span class="pagBack">
		             		<?php previous_posts_link( 'Back' ); ?>
		             	</span>
		        		<?php wp_reset_postdata(); ?>
        			</div>
				</div>

			</div>

			
		</div>
	</div>
</div>

	