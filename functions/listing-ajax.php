<?php 

add_action('wp_ajax_listingMessageDelete', 'listingMessageDelete');
add_action('wp_ajax_nonpriv_listingMessageDelete', 'listingMessageDelete');
function listingMessageDelete(){
    $messageIdToDelete = $_REQUEST['idToDelete'];
    
    update_post_meta( $messageIdToDelete, 'deletedByListingOwner', true );

    echo json_encode(['status' => true]);
    exit();
}