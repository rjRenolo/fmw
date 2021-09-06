<?php
/**
 * Block Name: Blog Favourites 
 *
 */

// create id attribute for specific styling
$id = 'favlistings-' . $block['id'];

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';
$class = $block['className'];
?>

<div class="bloglistings-block ">
	<div class="container row">

			<h2 class="sectionTitle textcenter"><?php echo get_field('section_title');?> 
				<?php if(!is_admin()) { ?>
						<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
									 viewBox="0 0 41.5 42.7" style="enable-background:new 0 0 41.5 42.7;" xml:space="preserve">
								<style type="text/css">
									.st0{fill:#EC6C84;}
								</style>
								<path id="heart" class="st0" d="M20.8,15.3c0,0-1.6-3.3-5.1-3.3c-3.9,0-5.9,3.3-5.9,6.5c0,5.4,11,12.2,11,12.2S31.7,24,31.7,18.5
									c0-3.3-2.1-6.5-5.8-6.5C23.7,12,21.7,13.3,20.8,15.3z"/>
								</svg>
				<?php } ?>
			</h2>

			<?php
			if( have_rows('blog_items') ):?>
				<div class="row listings-container">
			    	<?php while( have_rows('blog_items') ) : the_row();?>


			    		<?php if(!is_admin()) { ?>

				       		<div class="listing-cat blog-listing g_grid_3 has-white-color" data-aos="fade-up">
				       			<a href="<?php echo get_the_permalink(get_sub_field('blog'));?>">

				       				<?php if(get_field('listing_category_image',get_sub_field('blog')) == "") {
				       					$url = HOLDING_CAT_IMAGE;
				       				} else { 
				       					$url = acf_image_output_url(get_field('listing_category_image',get_sub_field('listing')), 'thumbnail');
				       				} ?>
				       				<div class="listing-cat-image" style="background-image:url( <?php echo $url;?> )">
				       				</div>
				       				<div class="listing-cat-content">
				       					<h3><?php echo get_the_title(get_sub_field('blog'));?></h3>

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

					<?php endwhile; ?>
				</div>

				<p class="textcenter pt40"><a href="<?php echo get_the_permalink(get_option( 'page_for_posts' ));?>" class="wp-block-button__link has-green-background-color">More of what we love</a></p>
			<?php endif;?>
		</div>
	</div>
</div>

	