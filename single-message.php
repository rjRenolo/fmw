<?php acf_form_head(); ?>
<?php Embers_Utilities::get_template_parts( array( 'parts/html-header', 'parts/header' ) ); ?>

<?php
    global $current_user; 
    wp_get_current_user();
    $userPageId = $current_user->user_page_id;
    
    ?>

<article class="container dashboard-container row">
    <?php $listingOwnerEmail; $coupleId ?>

	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); 

        $listingOwnerEmail = get_post_meta(get_the_ID(), 'business_email', true);
        $coupleEmail = get_post_meta(get_the_ID(), 'couple_email', true);
    ?>
        <?php 
        if(is_user_logged_in()){ 
            global $current_user; 
            wp_get_current_user();
            $canAccess;
        ?>

            <?php if(current_user_can('administrator') || current_user_can('couple') || current_user_can('business')){ ?>

                <?php if(current_user_can('business')){
                            $businessEmail = $current_user->user_email;
                            $canAccess = $businessEmail == $listingOwnerEmail;

                        }else if(current_user_can('couple')){
                            $coupleEmailToCompare = $current_user->user_email;
                            $canAccess = $coupleEmailToCompare == $coupleEmail;
                        } ?>

                <div class="row">
                    <div class="g_grid_3">
                        <?php 
                        if(current_user_can('business') || current_user_can('administrator')){ 

                            include THEME_DIR . '/parts/dashboard-navigation.php'; 

                        } else {

                            include THEME_DIR . '/parts/couple-dashboard-navigation.php'; 

                        } ?>
                    </div>
                    <div class="g_grid_9">
                        <?php

                        if(isset($_GET['new'])){update_post_meta( get_the_ID(), 'new_message', 0, true); }
                        if(isset($_GET['listing-owner-new-reponse'])){update_post_meta( get_the_ID(), 'listing_new_reply', 0, true); }

                        if(current_user_can('administrator') || $canAccess){ ?>
                            <?php if(current_user_can('couple')) : ?>

                                <h2><?php echo get_post_meta(get_the_ID(), 'listing_name', true); ?></h2>	
                                
                                <?php elseif(current_user_can('business')): ?>

                                <h2><?php the_title(); ?></h2>	
                                
                            <?php endif; ?>

                            <?php foreach(wp_get_post_terms(get_the_ID(), 'enquiry-type', true) as $t){ ?>
                                <p class="messageType">Message Type: <?=$t->name?></p>
                            <?php } ?>

                            <p><strong><?php the_content(); ?></strong></p>

                            <?php if(is_single()) comments_template(); ?>
                    </div>
                </div>

                <script>
                    jQuery('input[type="submit').click(function() {
                        jQuery(this).css('opacity','0.3');
                        jQuery(this).prop('value','Sending...');
                    })
                </script>

            <?php }else{ ?>

                        <p>You don't have permission to access this page.</p>

            <?php }?>

            

            <?php }else{ ?>

                <p>You don't have permission to access this page.</p>

            <?php } ?>

        <?php } else { ?>

            <?php include THEME_DIR . '/parts/registration-form.php' ?>

        <?php } ?>

		
	<?php endwhile; ?>




</article>
<?php Embers_Utilities::get_template_parts( array( 'parts/footer','parts/html-footer' ) ); ?>