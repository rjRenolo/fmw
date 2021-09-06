<?php

add_filter( 'cron_schedules', 'newCronInterval' );

function newCronInterval( $schedules ) {
    $schedules['one_day'] = array(
        'interval' => 86400,
        'display' => esc_html__( 'Every Day' ),
    );

    return $schedules;
}

if(!wp_next_scheduled( 'subscription_expy')){
    wp_schedule_event( time(), 'one_day', 'subscription_expy' );
}

add_action('subscription_expy', 'subscriptionExpiry');
function subscriptionExpiry(){
    // get all listing
    $allTheListing = get_posts(array(
        'post_type' => 'listing',
        'numberposts' => -1
    ));
    foreach($allTheListing as $theListing){
        $listingId = $theListing->ID;
        // get users
        $listingOwnerId = get_post_meta($listingId, 'listing_owner_id', true);
        $listingExpirationDate = apply_filters('get_subscriptionexpirydate', $listingOwnerId);
        // check for expiry date - time()
        $diff = intval($listingExpirationDate) - time();
        if($diff < 0){
            // update status
            update_user_meta($listingOwnerId, 'subscription_status', "expired");
        }
    }
}