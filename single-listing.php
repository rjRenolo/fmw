<?php 
$couples = get_users( array( 'role__in' => array( 'business' ) ) );
foreach ( $couples as $user ) {

    $userpage = get_user_meta( $user->ID, 'user_page_id' , true );
    if($userpage == $post->ID) {
        $userid = $user->ID;
    }

}
$subscription_status = get_user_meta( $userid, 'subscription_status' , true );
if(!$subscription_status == 'active') {
    wp_redirect(get_bloginfo('url'));
}


Embers_Utilities::get_template_parts( array( 'parts/html-header', 'parts/header' ) ); ?>

<article class="container single-listing-container">
    <?php 
        $listingId; 
        global $current_user; 
        wp_get_current_user();
    ?>

	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); 

        $postID = get_the_ID(  );
        
        $listingCategory = apply_filters('term_getter', $postID, 'listing-category');
        $listingType = apply_filters( 'term_getter', $postID, 'listing-license');
        $listingVenueType = apply_filters('term_getter', $postID, 'listing-license-type', 'array');
        $styleOptions = apply_filters('term_getter', $postID, 'listing-style', 'array');
        $venueFeature = apply_filters('term_getter', $postID, 'listing-features', 'array');
        $listingAddress = '';
        $address = get_field('address');
        $town = get_field('town');
        $county = get_field('county');
        $postcode = get_field('postcode');
        $listingAddress = $address . ', ' . $town . ', ' . $county . ', ' . $postcode;

        $term_list = get_the_terms( $postID, 'listing-capacity' );
        $imageRows = get_field('image_gallery');
        $videoURLs = get_field('video_urls');
    
    ?>

    <!-- Full white screen -->

    <div class="photo-gallery Modal">
        <div class="Close"><img src="<?=get_bloginfo('template_directory');?>/images/global/Close.svg" class="modalClose"></div>
        <h2 class="textcenter ">Photo Gallery</h2>
        <div class="container image-gallery-container row">

            <?php foreach($imageRows as $imageRow){ ?>
                <div class="gallery-image" style="background: url(<?php echo acf_image_output_url($imageRow['image'],'large');?>);"></div>
                <!-- <div class="gallery-image" style="background: url(< ?php echo wp_get_attachment_image($imageRow['image'],'large');?>);"></div> -->
                <!-- <div class="gallery-image" style="background: url(< ?php echo $imageRow['image']?>);"></div> -->
            <?php } ?>

        </div>
    </div>

 
    <div class="video-gallery videosModal" >
        <div class="Close"><img src="<?=get_bloginfo('template_directory');?>/images/global/Close.svg" class="modalClose"></div>
        <h2 class="textcenter">Video Gallery</h2>

        <div class="container">

            <?php foreach($videoURLs as $videoRow){ ?>
                <?php echo $videoRow['video_url']; ?>
            <?php } ?>

        </div>
    </div>
    
    <?php if(isset($_POST['Enquiry'])) { ?>
        <div class="message success messageSent">
            Your Message Has Been Sent
        </div>
        <script>
            jQuery(document).ready(function() {
                jQuery('.message.success.messageSent').delay(3000).slideUp()
            })
        </script>
    <?php } ?>

        <div class="listing-details-banner row">
            <div class="listing-details grid_9">
                <h1 class="listingTitle"><?php the_title(); ?></h1>

                <div class="starReviews">
                    <?php 
                    $reviewcount = count(get_field('reviews'));
                    if($reviewcount > 0) {
                    ?>

                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <title>star</title>
                        <path d="M12 17.25l-6.188 3.75 1.641-7.031-5.438-4.734 7.172-0.609 2.813-6.609 2.813 6.609 7.172 0.609-5.438 4.734 1.641 7.031z"></path>
                        </svg>
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <title>star</title>
                        <path d="M12 17.25l-6.188 3.75 1.641-7.031-5.438-4.734 7.172-0.609 2.813-6.609 2.813 6.609 7.172 0.609-5.438 4.734 1.641 7.031z"></path>
                        </svg>
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <title>star</title>
                        <path d="M12 17.25l-6.188 3.75 1.641-7.031-5.438-4.734 7.172-0.609 2.813-6.609 2.813 6.609 7.172 0.609-5.438 4.734 1.641 7.031z"></path>
                        </svg>
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <title>star</title>
                        <path d="M12 17.25l-6.188 3.75 1.641-7.031-5.438-4.734 7.172-0.609 2.813-6.609 2.813 6.609 7.172 0.609-5.438 4.734 1.641 7.031z"></path>
                        </svg>
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <title>star</title>
                        <path d="M12 17.25l-6.188 3.75 1.641-7.031-5.438-4.734 7.172-0.609 2.813-6.609 2.813 6.609 7.172 0.609-5.438 4.734 1.641 7.031z"></path>
                        </svg>
                    <?php } ?>

                    <a href="#reviews"><?php echo $reviewcount;?> Reviews</a>
                </div>
                <div class="location-container displayFlex" >
                    <p>
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="18.78px"
                         height="22.53px" viewBox="0 0 18.78 22.53" style="overflow:visible;enable-background:new 0 0 18.78 22.53;"
                         xml:space="preserve">
                    <defs>
                    </defs>
                    <path id="map-pin_1_" class="st0" d="M18.78,9.39C18.78,4.2,14.57,0,9.39,0C4.2,0,0,4.2,0,9.39c0,0.53,0.05,1.05,0.14,1.57
                        c0.28,1.44,0.81,2.81,1.58,4.05c1.88,2.89,4.31,5.39,7.15,7.36c0.32,0.21,0.73,0.21,1.04,0c2.84-1.96,5.27-4.46,7.15-7.36
                        c0.77-1.25,1.3-2.62,1.58-4.06C18.73,10.44,18.78,9.92,18.78,9.39L18.78,9.39z M16.9,9.39c0,0.42-0.04,0.84-0.11,1.25
                        c-0.24,1.21-0.69,2.37-1.34,3.42c-1.59,2.46-3.62,4.6-5.98,6.33c-2.45-1.67-4.54-3.82-6.13-6.33c-0.65-1.05-1.11-2.21-1.34-3.42
                        c-0.07-0.41-0.11-0.83-0.11-1.25c0-4.15,3.36-7.51,7.51-7.51S16.9,5.24,16.9,9.39z M13.14,9.39c0-2.07-1.68-3.76-3.76-3.76
                        c-2.07,0-3.76,1.68-3.76,3.76s1.68,3.76,3.76,3.76c1,0,1.95-0.4,2.66-1.1C12.75,11.34,13.15,10.38,13.14,9.39z M11.27,9.39
                        c0,1.04-0.84,1.88-1.88,1.88s-1.88-0.84-1.88-1.88c0-1.04,0.84-1.88,1.88-1.88c0.5,0,0.98,0.2,1.33,0.55
                        C11.07,8.41,11.27,8.89,11.27,9.39L11.27,9.39z"/>
                    </svg>

                    <?=$listingAddress?> <a href="#map" class="viewonmap">View on map</a></p>
                </div>
               
            </div>
            <div class="category-icon grid_3 alignright">
                <?php
                $taxId = apply_filters( 'termdID_getter', $post->ID, 'listing-category' );
                echo apply_filters( 'taxonomy_images_getter', $taxId );
                ?>
            </div>
        </div>


        <div class="listing-gallery row">

            <?php
            $theBadge = apply_filters( 'get_premiumbadge', $postID );
            echo $theBadge;?>

            <?php Embers_Utilities::get_template_parts(array(
                'parts/listing-gallery'
            )); ?>
        </div>

        <div class="wishlist_accommodation-container row">
            <div class="wishlist grid_4 displayFlex textcenter">
                <?php do_action('add_wishlist_button'); ?>
            </div>
            <div class="accommodation alignright" style="display:flex;">
                <img height="25px" width="25px" src="<?=get_bloginfo('template_directory');?>/images/global/fmw/person-group.svg" alt="" style="margin-right:4px;">
                <span><?=$term_list[0]->name?> Guests</span>
            </div>
        </div>
        <hr>

        <div class="content_sendmessage-container row">
            <div class="content-container g_grid_8">
                <h2 class="listing-about">About <?php echo $listingType === 'Supplier' ? 'the supplier' : 'the venue'?></h2>
                <?php echo get_field('listing_description');?>

            </div>
            <div class="sendmessage-container g_grid_4">

                <?php if((is_user_logged_in() && current_user_can( 'couple' )) || (is_user_logged_in() && current_user_can( 'administrator' ))){  ?>

                        <form method="post">
                            <h4 class="form-title">Send a Message</h4>
                            <select name="Enquiry" id="">
                                <option value="General Enquiry">General Enquiry</option>
                                <option value="Quote Enquiry">Quote Enquiry</option>
                            </select>
                            <textarea name="enquiry_message_content" id="message_input" cols="30" rows="10" placeholder="Enter message..." required></textarea>
                            <input type="submit" name="send" class="primary-btn" value="Send Message">
                        </form>

                <?php }else{ ?>

                    <p><a href="<?php echo get_the_permalink(get_field('login_page','option'));?>" target="_blank" class="primary-btn">Message This <?=$listingType?></a></p>

                    <p class="startYourMembership">Don't have a Find My Wedding account?<br /><a href="<?php echo get_the_permalink(get_field('couples_join_now_page','option'));?>">Start your free membership</a>.</p>

                <?php } ?>

                <div class="sociallinks-container">
                    <?php if(get_field('website_url') !== '' && get_field('website_url')){ ?>
                        <a href="<?=get_field('website_url')?>" target="_blank" class="primary-btn">Visit Their Website</a>
                    <?php } ?>
                    <div class="row">
                        <?php if(get_field('instagram') !== '' && get_field('instagram')){?>
                            <a href="<?=get_field('instagram')?>" target="_blank" class="primary-btn socmed-link g_grid_4"><img height="28px" width="28px" src="<?=get_bloginfo('template_directory');?>/images/global/fmw/brands-instagram.svg" alt=""></a>
                        <?php }?>
                        <?php if(get_field('facebook') !== '' && get_field('facebook')){?>

                            <a href="<?=get_field('facebook')?>" target="_blank" class="primary-btn socmed-link g_grid_4"><img height="28px" width="28px" src="<?=get_bloginfo('template_directory');?>/images/global/fmw/brands-facebook.svg" alt=""></a>
                        <?php } ?>
                        <?php if(get_field('twitter') !== '' && get_field('twitter')) { ?>
                            <a href="<?=get_field('twitter')?>" target="_blank" class="primary-btn socmed-link g_grid_4"><img height="28px" width="28px" src="<?=get_bloginfo('template_directory');?>/images/global/fmw/brands-twitter.svg" alt=""></a>
                        <?php } ?>
                    </div>
                </div>

                
            </div>
        </div>
     
        <div class="listing_information-container">
            <div class="row">

                <div class="listing-type-container row">
                    <div class="title-container g_grid_3">
                        <h4><?=$listingType?></h4>
                    </div>
                    <div class="g_grid_9">
                        <div class="details-container">
                            <?php if($listingType === "Supplier"){ ?>
                                <p><?php echo $listingCategory ?></p>
                            <?php }else{ ?>
                                <?php if($listingVenueType !== "" && isset($listingVenueType)){ ?>
                                    <?php foreach($listingVenueType as $lVenueType){ ?>
                                        <p><?=$lVenueType->name?></p>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="options-container row">
                    <div class="title-container g_grid_3">
                        <h4>Style Options</h4>
                    </div>
                    <div class=" g_grid_9 ">
                        <div class="details-container">
                            <?php if($styleOptions !== ''){
                                    foreach($styleOptions as $option){ ?>
                                        <p><?=$option->name?></p>
                                <?php } ?>
                            <?php }else{ ?>
                                <h2>No Available Style Options</h2>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <?php if($venueFeature !== ''){ ?>

                    <div class="features-container">
                        <div class="title-container g_grid_3">
                            <h4>Features</h4>
                        </div>
                        <div class="g_grid_9 ">
                            <div class="details-container">
                                <?php foreach($venueFeature as $feature){ ?>
                                    <p><?=$feature->name?></p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    
                <?php } ?>

            </div>
        </div>
		
        <div class="listing_map-container">
            <div class="row">
               <?php echo get_field('listing_map');?>
            </div>
        </div>
	<?php if(!get_field('listing_map')=="") { ?>
	<?php } ?>

        <?php if($reviewcount > 0)  :?>
            <div class="reviews-container" id="reviews">
                <div class="row">
                    <h4>Reviews</h4>
                    <div class="starReviews">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <title>star</title>
                            <path d="M12 17.25l-6.188 3.75 1.641-7.031-5.438-4.734 7.172-0.609 2.813-6.609 2.813 6.609 7.172 0.609-5.438 4.734 1.641 7.031z"></path>
                            </svg>
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <title>star</title>
                            <path d="M12 17.25l-6.188 3.75 1.641-7.031-5.438-4.734 7.172-0.609 2.813-6.609 2.813 6.609 7.172 0.609-5.438 4.734 1.641 7.031z"></path>
                            </svg>
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <title>star</title>
                            <path d="M12 17.25l-6.188 3.75 1.641-7.031-5.438-4.734 7.172-0.609 2.813-6.609 2.813 6.609 7.172 0.609-5.438 4.734 1.641 7.031z"></path>
                            </svg>
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <title>star</title>
                            <path d="M12 17.25l-6.188 3.75 1.641-7.031-5.438-4.734 7.172-0.609 2.813-6.609 2.813 6.609 7.172 0.609-5.438 4.734 1.641 7.031z"></path>
                            </svg>
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <title>star</title>
                            <path d="M12 17.25l-6.188 3.75 1.641-7.031-5.438-4.734 7.172-0.609 2.813-6.609 2.813 6.609 7.172 0.609-5.438 4.734 1.641 7.031z"></path>
                            </svg>

                        <a href="#reviews"><?php echo $reviewcount;?> Reviews</a>
                    </div>
                </div>
                <div class="reviews grid-display">
                    <?php
                        $reviews = get_field('reviews');
                        if(isset($reviews)){
                            foreach($reviews as $review){ ?>
                                <div class="review-card">
                                    <div class="card-title">
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="70px"
                                             height="70px" viewBox="0 0 70 70" style="overflow:visible;enable-background:new 0 0 70 70;" xml:space="preserve">
                                        <style type="text/css">
                                            .st0{fill:#5A606B;}
                                            .st1{fill:none;stroke:#717070;}
                                            .st2{fill:#FFFFFF;}
                                        </style>
                                        <defs>
                                        </defs>
                                        <g id="Ellipse_11_1_">
                                            <circle class="st0" cx="35" cy="35" r="35"/>
                                            <circle class="st1" cx="35" cy="35" r="34.5"/>
                                        </g>
                                        <path id="user_1_" class="st2" d="M48.5,48.51v-3c0-4.14-3.36-7.5-7.5-7.5l0,0H29c-4.14,0-7.5,3.36-7.5,7.5l0,0v3
                                            c0,0.83,0.67,1.5,1.5,1.5s1.5-0.67,1.5-1.5v-3c0-2.49,2.01-4.5,4.5-4.5l0,0h12c2.49,0,4.5,2.01,4.5,4.5l0,0v3
                                            c0,0.83,0.67,1.5,1.5,1.5S48.5,49.33,48.5,48.51z M42.5,27.51c0-4.14-3.35-7.5-7.49-7.51s-7.5,3.35-7.51,7.49s3.35,7.5,7.49,7.51
                                            c1.99,0,3.9-0.79,5.31-2.19C41.71,31.4,42.5,29.49,42.5,27.51z M39.5,27.51c0,2.49-2.01,4.5-4.5,4.5c-2.49,0-4.5-2.01-4.5-4.5
                                            s2.01-4.5,4.5-4.5c1.19,0,2.34,0.47,3.18,1.32C39.03,25.17,39.5,26.31,39.5,27.51z"/>
                                        </svg>

                                        <div class="reviewer">
                                            <p><strong><?=$review['title']?></strong></p>
                                            <span><small><?=$review['review_date']?></small></span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <?=$review['review_content']?>
                                    </div>
                                </div>
                        <?php }
                        }else{
                            echo "<h2>No Available Reviews</h2>";
                        }
                    ?>
                    
                </div>
            </div>
        <?php endif;?>


        <?php 
            $listingId = get_the_ID(); 
            $ownerEmail = get_the_author_meta('user_email');
            $theTitle = get_the_title();
        ?>
	<?php endwhile; ?>

    <?php 
        $listingOwnerEmail = get_post_meta($listingId, 'listing_owner_email', true);
    

    ?>

    <?php
    if(isset($_POST['Enquiry'])){

        $enquiryType = $_POST['Enquiry'];
        $message = $_POST['enquiry_message_content'];
          
        $toEmail = $listingOwnerEmail;
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: Find My Wedding <'.get_bloginfo('admin_email').'>' . "\r\n";
        $headers .= "Return-path: <" . get_bloginfo('admin_email') . ">\r\n";
        $htmlmessage = "<p>You have a ". $_POST['Enquiry'] ." from Find My Wedding. Log into your <a href=". get_site_url() . '/listing-dashboard' .">dashboard</a> to respond</p>";
        $sendMail = wp_mail($toEmail, $_POST['Enquiry'] . ' from Find My Wedding', $htmlmessage, $headers);

        // after email send
        // save message as post type
        $args = array(
            'post_title' => get_the_title($current_user->user_page_id),
            'post_status' => 'publish',
            'post_type' => 'message',
            'post_content' => $_POST['enquiry_message_content']
        );
        $newMessage = wp_insert_post($args);
        update_post_meta($newMessage, 'listing_name', $theTitle, true);
        update_post_meta($newMessage, 'business_email', $listingOwnerEmail, true);
        update_post_meta($newMessage, 'couple_email', $current_user->user_email, true);
        update_post_meta($newMessage, 'new_message', 1, true);
        update_post_meta($newMessage, 'indicator', 'gray', true);
        term_insertion($_POST['Enquiry'], 'enquiry-type', $newMessage, false);

          
    }


    ?>


</article>

<script>
jQuery(document).keydown(function(e) {
    if(e.keyCode == 27) {
        jQuery(".Modal").hide(300);
    }
});
jQuery(document).ready(function(){
    jQuery(".Modal").hide();
    jQuery("#viewImageGallery").click(function(){
        jQuery(".Modal").fadeToggle();
    });
    jQuery(".Close").click(function(){
        jQuery(".Modal").fadeOut();
    });
});
jQuery(document).ready((e) => {
    jQuery('#viewImageGallery').on('click', (e) => {
    })
})
</script>

<?php Embers_Utilities::get_template_parts( array( 'parts/footer','parts/html-footer' ) ); ?>