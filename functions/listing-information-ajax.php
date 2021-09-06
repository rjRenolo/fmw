<?php


add_action('wp_ajax_listingInfoUpdate', 'listingInfoUpdate');
add_action('wp_ajax_nopriv_listingInfoUpdate', 'listingInfoUpdate');
function listingInfoUpdate(){


    // update the users listing taxonomy
    global $current_user; 
    wp_get_current_user();
    $listingPageId = get_user_meta($current_user->ID, 'user_page_id', true);
    $listingCounties = get_terms(array( 'taxonomy' => 'listing-location', 'hide_empty' => false ));
    $listingStyles = get_terms(array( 'taxonomy' => 'listing-style', 'hide_empty' => false ));
    $listingVenueDescriptions = get_terms(array('taxonomy' => 'listing-venue-type', 'hide_empty' => false));
    $listingVenueFeatures = get_terms(array('taxonomy' => 'listing-features', 'hide_empty' => false));


    switch($_REQUEST['data']['type']){
        case 'listingType':
            foreach($_REQUEST['data']['value'] as $val){
                $toStoredListingType = $val === 'yes' ? 'Venue' : 'Supplier';

                echo json_encode(['status' => $toStoredListingType]);
                // exit();

                // term_insertion($toStoredListingType, 'listing-type', $listingPageId, false);
                term_insertion($toStoredListingType, 'listing-license', $listingPageId, false);
            }
            break;
        case 'listingVenueType':
            foreach($_REQUEST['data']['value'] as $val){
                term_insertion($val, 'listing-license-type', $listingPageId, true);
            }
            break;
        case 'county':
            foreach($listingCounties as $lCounties){
                wp_remove_object_terms( $listingPageId, $lCounties->name, 'listing-location' );
            }
            foreach($_REQUEST['data']['value'] as $val){
                term_insertion($val, 'listing-location', $listingPageId, true);
            }
            break;
        case 'accommodation':
            foreach($_REQUEST['data']['value'] as $val){
                term_insertion($val, 'listing-capacity', $listingPageId, false);
            }
            break;
        case 'style':
            foreach($listingStyles as $lStyle){
                wp_remove_object_terms( $listingPageId, $lStyle->name, 'listing-style' );
            }
            foreach($_REQUEST['data']['value'] as $val){
                term_insertion($val, 'listing-style', $listingPageId, true);
            }
            break;
        case 'serviceDescription':
            foreach($_REQUEST['data']['value'] as $val){
                // term_insertion($val, 'listing-service', $listingPageId, false);
                term_insertion($val, 'listing-category', $listingPageId, false);
            }
            break;
        case 'venueDescription':
            foreach($listingVenueDescriptions as $lVenueDecs){
                wp_remove_object_terms( $listingPageId, $lVenueDecs->name, 'listing-venue-type' );
            }
            foreach($_REQUEST['data']['value'] as $val){
                term_insertion($val, 'listing-venue-type', $listingPageId, true);
            }
            break;
        case 'venueFeature':
            foreach($listingVenueFeatures as $lVenueFeat){
                wp_remove_object_terms( $listingPageId, $lVenueFeat->name, 'listing-features' );
            }
            foreach($_REQUEST['data']['value'] as $val){
                term_insertion($val, 'listing-features', $listingPageId, true);
            }
            break;
        default:
            break;
    }
    // update_done_steps($current_user->ID, 'business_details_done_steps', $_REQUEST['data']['done']);

    echo json_encode(['status' => $_REQUEST['data']['value']]);

    exit();
}