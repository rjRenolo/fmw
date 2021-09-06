<?php 
/*
Template Name: Listing Information
*/
acf_form_head();
?>

<?php Embers_Utilities::get_template_parts( array( 'parts/html-header', 'parts/header' ) ); ?>

<div class="row dashboard-container">
    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; ?>

    <div class="g_grid_3 has-white-background-color dashboard-sidebar">
        <?php include THEME_DIR . '/parts/dashboard-navigation.php'; ?>
    </div>

    <div class="g_grid_9 dashboard-content-wrap">
        <h2>WEDMATCH<sup><small>TM</small></sup></h2>
        <?php
            $user_subscription_expiry = get_user_meta( $current_user->ID, 'user_subscription_expiry' , true );

           // if($user_subscription_expiry){

                include THEME_DIR . '/parts/listing-information.php';

           // }else{ ?>

                <p>Please subscribe to edit/view your listing.</p>
                <a class="wp-block-button__link has-pink-background-color" href='/subscribe-now'>Subscribe Now</a>

            <?php //} ?>
    </div>



</div>



<?php Embers_Utilities::get_template_parts( array( 'parts/footer','parts/html-footer' ) ); ?>