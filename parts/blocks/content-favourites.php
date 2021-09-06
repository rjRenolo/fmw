<?php
/**
 * Block Name: Favourites Listings
 *
 */

// create id attribute for specific styling
$id = 'favlistings-' . $block['id'];

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';
$class = $block['className'];
?>

<!-- <div class="favlistings-block has-black-background-color has-white-color"> -->
<!-- <div class="favlistings-block has-primary-bg-color has-white-color"> -->
<div class="favlistings-block has-linear-gradient has-white-color">
	<div class="container row">

		<?php if(!is_admin()) { 
			get_sidebar();
		} ?>

		<div class="g_grid_9">
			<h2 class="sectionTitle"><?php echo get_field('section_title');?></h2>

			<?php
			if( have_rows('listings') ):?>
				<div class="row listings-container">
			    	<?php while( have_rows('listings') ) : the_row();?>


			    		<?php if(!is_admin()) { ?>

				       		<div class="listing-cat g_grid_4 has-white-color" data-aos="fade-up">
				       			<a href="<?php echo get_the_permalink(get_sub_field('listing'));?>">

				       				<?php if(get_field('listing_category_image',get_sub_field('listing')) == "") {
				       					$url = HOLDING_CAT_IMAGE;
				       				} else { 
				       					$url = acf_image_output_url(get_field('listing_category_image',get_sub_field('listing')), 'thumbnail');
				       				} ?>
				       				<div class="listing-cat-image" style="background-image:url( <?php echo $url;?> )">
				       				</div>
				       				<div class="listing-cat-content">
				       					<h3><?php echo get_the_title(get_sub_field('listing'));?></h3>
				       					<?php $term_list = wp_get_post_terms( get_sub_field('listing'), 'listing-category', array( 'fields' => 'all' ) );?>
				       					<p class="listing-cat-cat"><?php echo $term_list[0]->name;?></p>
				       					<p class="listing-cat-address"><?php echo get_field('address',get_sub_field('listing'));?>, <?php echo get_field('town',get_sub_field('listing'));?></p>
				       					<p class="has-green-color listing-link">See Listing</p>
				       				</div>
				       			</a>
				       		</div>

				       	<?php } else { ?>
							<h3><?php echo get_the_title(get_sub_field('listing'));?></h3>
				       	<?php } ?>

					<?php endwhile; ?>
				</div>

				<p class="textcenter pt40"><a href="<?php echo get_the_permalink(get_field('listings_page','option'));?>" class="wp-block-button__link has-green-background-color">See all listings</a></p>
			<?php endif;?>
		</div>
	</div>
</div>

	