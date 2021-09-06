<?php Embers_Utilities::get_template_parts( array( 'parts/html-header', 'parts/header' ) ); ?>

<?php 
$term = get_term_by( 'slug', get_query_var('term'), get_query_var('taxonomy') );
$termid = $term->term_taxonomy_id;
$topad = get_field('top_banner_image', 'listing-category_' . $termid);
$bottomad = get_field('bottom_banner_image', 'listing-category_' . $termid);
$topadlink = get_field('top_banner_link', 'listing-category_' . $termid);
$bottomadlink = get_field('bottom_banner_link', 'listing-category_' . $termid);
$bannerimg = get_field('banner_image', 'listing-category_' . $termid);

?>


<?php if($bannerimg == "") {?>
	<div class="wp-block-cover has-background-dim-20 has-background-dim is-style-narrow" style="min-height:550px">

		<img loading="lazy" width="2560" height="1176" class="wp-block-cover__image-background wp-image-321" alt="" 
		src="<?=site_url()?>/wp-content/uploads/2021/05/homepage-cover-scaled.jpg" data-object-fit="cover" 
		srcset="<?=site_url()?>/wp-content/uploads/2021/05/homepage-cover-scaled.jpg 2560w, 
		<?=site_url()?>/wp-content/uploads/2021/05/homepage-cover-800x367.jpg 800w, 
		<?=site_url()?>/wp-content/uploads/2021/05/homepage-cover-2000x919.jpg 2000w, 
		<?=site_url()?>/wp-content/uploads/2021/05/homepage-cover-768x353.jpg 768w, 
		<?=site_url()?>/wp-content/uploads/2021/05/homepage-cover-1536x705.jpg 1536w, 
		<?=site_url()?>/wp-content/uploads/2021/05/homepage-cover-2048x941.jpg 2048w" 
		sizes="(max-width: 2560px) 100vw, 2560px">

		<div class="wp-block-cover__inner-container">
			<p class="has-text-align-center is-style-script has-pale-pink-color has-text-color has-large-font-size">Find My Wedding</p>
			<h1 class="has-text-align-center"><?php echo single_cat_title( '', false ); ?></h1>

			<?php Embers_Utilities::get_template_parts( array( 'parts/blocks/content-fmwsearchvenue' ) ); ?>
		</div>
	</div>

<?php } else { ?>

	<div class="wp-block-cover has-background-dim-20 has-background-dim is-style-narrow" style="min-height:550px">

		<img loading="lazy" class="wp-block-cover__image-background wp-image-321" alt="" 
		src="<?php echo acf_image_output_url($bannerimg,'large');?>" data-object-fit="cover" />

		<div class="wp-block-cover__inner-container">
			<p class="has-text-align-center is-style-script has-pale-pink-color has-text-color has-large-font-size">Find My Wedding</p>
			<h1 class="has-text-align-center"><?php echo single_cat_title( '', false ); ?></h1>

			<?php Embers_Utilities::get_template_parts( array( 'parts/blocks/content-fmwsearchvenue' ) ); ?>
		</div>
	</div>

<?php }?>

<div class="container row tax-wrapper">
        <div class="filter-container g_grid_3" >
            
            <?php Embers_Utilities::get_template_parts( array( 'parts/sidebar-filter' ) ); ?>

        </div>

        <div class="g_grid_9 ">

        	<div class="main-result-container">
        		<p class="result-title kristi-face has-pink-color">Find My Wedding</p>
		            
		        <h1><?php echo single_cat_title( '', false ); ?></h1>
		        <?php if(category_description() =="") {

		        	echo "<p>Searching for a wedding " . single_cat_title( '', false ) . " in Wales? We understand the importance in selecting the right wedding supplier for you, so have brought together the very best wedding " . single_cat_title( '', false ) . " in Wales.</p>";

		        } else {
		        	echo single_cat_title( '', false );
		        }?>

		        <?php if(!$topad == "") { ?>
		        	<div class="topAdBanner adBanner">
		        		<?php if(!$topadlink == "") { ?>
		        			<a href="<?php echo $topadlink;?>" target="_blank">
		        		<?php } ?>
		        			<img src="<?php echo $topad;?>" alt="Advert" >
		        		<?php if(!$topadlink == "") { ?> 
		        			</a>
		        		<?php } ?>
		        	</div>
		        <?php } ?>


				<?php

					$theCurrentTerm = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

					
					
					

					$refineCounty = [];
					$refineStyle = [];
					$refineAccommodation = [];
					$refineVenueFeatures = [];
					$venueDescription = [];
					if(isset($_GET['county'])){
						$refineCounty = explode("fmw", $_GET['county']); 
					}
					if(isset($_GET['style'])){
						$refineStyle = explode("fmw", $_GET['style']);
					}
					if(isset($_GET['accommodation'])){
						$refineAccommodation = explode("fmw", $_GET['accommodation']);
					}
					if(isset($_GET['features'])){
						$refineVenueFeatures = explode("fmw", $_GET['features']);
					}
					if(isset($_GET['venueDescription'])){
						$venueDescription = explode("fmw", $_GET['venueDescription']);
					}



					// $lookingForTax = apply_filters( 'service_venue_identifyer', $lookingfor );
					$taxQuery = array(
						'relation' => 'AND',
					);

					$lookingTaxQuery = array(
						// 'taxonomy' => $lookingForTax,
						'taxonomy' => $theCurrentTerm->taxonomy,
						// 'taxonomy' => 'listing-category',
						'field' => 'slug', 
						'terms' => $theCurrentTerm->slug,
						// 'terms' => 'bridalwear',
						'include_children' => true, 
						'operator' => 'IN' 
					);
					array_push($taxQuery, $lookingTaxQuery);

					if(count($refineCounty) > 0 && $refineCounty[0] !== ""){ //location tax query
						$locationTaxQuery = array(
							'taxonomy' => 'listing-location',
							'field' => 'name', 
							'terms' => $refineCounty,
							'include_children' => true, 
							'operator' => 'IN' 
						);
						array_push($taxQuery, $locationTaxQuery);
					}

					if(count($refineStyle) > 0 && $refineStyle[0] !== ""){
						$styleTaxQuery = array(
							'taxonomy' => 'listing-style',
							'field' => 'name', 
							'terms' => $refineStyle,
							'include_children' => true, 
							'operator' => 'IN' 
						);
						array_push($taxQuery, $styleTaxQuery);
					}

					if(count($refineAccommodation) > 0 && $refineAccommodation[0] !== ""){
						$accommodationTaxQuery = array(
							'taxonomy' => 'listing-capacity',
							'field' => 'name', 
							'terms' => $refineAccommodation,
							'include_children' => true, 
							'operator' => 'IN' 
						);
						array_push($taxQuery, $accommodationTaxQuery);
					}

					if(count($refineVenueFeatures) > 0 && $refineVenueFeatures[0] !== ""){
						$venueFeaturesTaxQuery = array(
							'taxonomy' => 'listing-features',
							'field' => 'name', 
							'terms' => $refineVenueFeatures,
							'include_children' => true, 
							'operator' => 'IN' 
						);
						array_push($taxQuery, $venueFeaturesTaxQuery);
					}

					if(count($venueDescription) > 0 && $venueDescription[0] !== ""){
						$venueDescTaxQuery = array(
							'taxonomy' => 'listing-venue-type',
							'field' => 'name', 
							'terms' => $venueDescription,
							'include_children' => true, 
							'operator' => 'IN' 
						);
						array_push($taxQuery, $venueDescTaxQuery);
					}

					$args = array(
						'post_type' => 'listing',
						'paged' => get_query_var( 'paged', 1 ),
						'posts_per_page' =>6,
						'tax_query' => $taxQuery
					);

					$the_query = new WP_Query( $args );
					
					// echo '<pre>';
					// print_r($the_query);
					// echo '</pre>';
					// die();
	

				?>

        		<div class="main-result-container-results row">
		        	

					<!-- < ?php if ( have_posts() ): ?>
						< ?php while ( have_posts() ) : the_post(); 
							get_template_part('parts/blocks/card', 'listing');
						endwhile; ?>
					< ?php else: ?>
					<h2>No posts to display</h2>
					< ?php endif; ?> -->

					<?php if( $the_query->have_posts() ): ?>
						<?php while( $the_query->have_posts() ) : $the_query->the_post(); ?>
							<?php get_template_part('parts/blocks/card', 'listing'); ?> 
						<?php endwhile;?>
					<?php else: ?>
						<h2>No listing available for your search query.</h2>
					<?php endif; ?>

				</div>

				<?php if(!$topad == "") { ?>
		        	<div class="adBanner">
		        		<?php if(!$bottomadlink == "") { ?>
		        			<a href="<?php echo $topadlink;?>" target="_blank">
		        		<?php } ?>
		        			<img src="<?php echo $topad;?>" alt="Advert" >
		        		<?php if(!$bottomadlink == "") { ?>
		        			</a>
		        		<?php } ?>
		        	</div>
		        <?php } ?>

			</div>

			<div class="navigation row">
		        <?php wa_numeric_posts_nav();?>
		    </div>
		</div>

</div>

<?php Embers_Utilities::get_template_parts( array( 'parts/footer','parts/html-footer') ); ?>