<?php Embers_Utilities::get_template_parts( array( 'parts/html-header', 'parts/header' ) ); ?>



<article class="couple-page row">
	<div class="couple-page-info">
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

			<?php
			$couples = get_users( array( 'role__in' => array( 'couple' ) ) );
			foreach ( $couples as $user ) {

				$couplepage = get_user_meta( $user->ID, 'user_page_id' , true );
				if($couplepage == $post->ID) {
					$coupleid = $post->ID;
				}

			}
			?>

			<?php if(!get_field('profile_image', $coupleid) =="") { ?>
				<img src="<?php echo acf_image_output_url(get_field('profile_image', $coupleid), 'thumbnail');?>" class="couple-page-profile-img" alt="" />
				<!-- <img src="< ?php echo get_field('profile_image', $coupleid);?>" class="couple-page-profile-img" alt="" /> -->
			<?php } ?>
			<p class="is-style-script wereGettingMarried">We're getting married</p>
			<h1 class="couple-coupleName"><?php the_title(); ?></h1>

			<?php if(!get_field('wedding_date', $coupleid) =="") { ?>

				<p>Our big day is happening on <strong><?php echo substr(get_field('wedding_date', $coupleid), 6, 2);?>/<?php echo substr(get_field('wedding_date', $coupleid), 4, 2);?>/<?php echo substr(get_field('wedding_date', $coupleid), 0, 4);?></strong></p>

				<div class="date-counter">
					<div class="date-count-day">
						<?php 
						$date = get_field('wedding_date', $coupleid);
						$weddingdate = strtotime($date);
						$today = strtotime(date('Ymd'));

						$date1 = new DateTime(get_field('wedding_date', $coupleid));
						$date2 = new DateTime();
						$interval = $date1->diff($date2);

						echo $interval->days;

						?>
					</div>

					DAYS TO GO
				</div>

			<?php } ?>
					
		<?php endwhile; ?>
	</div>


	<?php if(get_field('couples_cover_photo', $coupleid) =="") { 
		$img = acf_image_output_url(get_field('profile_image', $coupleid), 'thumbnail');
	} else {
		$img = acf_image_output_url(get_field('couples_cover_photo', $coupleid), 'thumbnail');
	} ?>


	<div class="couple-page-image" style="background-image: url(<?php echo $img;?>);">
	</div>
</article>

<?php Embers_Utilities::get_template_parts( array( 'parts/footer','parts/html-footer' ) ); ?>