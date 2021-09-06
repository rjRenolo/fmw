<?php Embers_Utilities::get_template_parts( array( 'parts/html-header', 'parts/header' ) ); ?>


<article class="container">
    <?php $listingOwnerEmail; $coupleId ?>
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); 

        $listingOwnerEmail = get_post_meta(get_the_ID(), 'to_listing_owner_email', true);
        $coupleId = get_post_meta(get_the_ID(), 'from_couple', true);
    ?>

		<h1><?php the_title(); ?></h1>	
	<?php endwhile; ?>


</article>
<?php Embers_Utilities::get_template_parts( array( 'parts/footer','parts/html-footer' ) ); ?>