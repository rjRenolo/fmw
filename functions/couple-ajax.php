<?php

add_action('wp_ajax_addTodo', 'addTodo');
add_action('wp_ajax_nopriv_addTodo', 'addTodo');
function addTodo(){
    $reqBody = $_REQUEST['data'];
    global $current_user; 
    wp_get_current_user();


    // get the wedding page id
    $weddingPageId = $current_user->user_page_id;

    $row_count = count(get_field('to_do', $weddingPageId)?: []);

	// the new row that we wanna add
	$row = [
        'to_do_name' => $reqBody['todoTitle'], 
        'notes' => $reqBody['todoNotes'], 
        'due_date' => $reqBody['todoDue'], 
        'budget' => $reqBody['todoBudget'], 
        'done' => false];

	// update it as the next index (++$row_count)
	update_row('to_do', ++$row_count, $row, $weddingPageId);

    echo json_encode(['status' => true]);
    exit();

}


add_action('wp_ajax_removeTodo', 'removeTodo');
add_action('wp_ajax_nopriv_removeTodo', 'removeTodo');
function removeTodo(){
    global $current_user; 
    wp_get_current_user();
    $weddingPageId = $current_user->user_page_id;

    $rowToRemove = $_REQUEST['rowToRemove'];

    // delete_sub_row('to_do', $rowToRemove, $weddingPageId);
    delete_row('to_do', $rowToRemove, $weddingPageId);
    echo json_encode(['status' => true]);
    exit();

}


add_action('wp_ajax_removeGuest', 'removeGuest');
add_action('wp_ajax_nopriv_removeGuest', 'removeGuest');
function removeGuest(){
    global $current_user; 
    wp_get_current_user();
    $weddingPageId = $current_user->user_page_id;
    $rowToRemove = $_REQUEST['row'];

    delete_row('guest_list', $rowToRemove, $weddingPageId);
    echo json_encode(['status' => true]);
    exit();
}


add_action('wp_ajax_updateCoupleGuest', 'updateCoupleGuest');
add_action('wp_ajax_nopriv_updateCoupleGuest', 'updateCoupleGuest');
function updateCoupleGuest(){

    global $current_user; 
    wp_get_current_user();


    // get the wedding page id
    $weddingPageId = $current_user->user_page_id;


    $reqBody = $_REQUEST['data'];

    $rowToUpdate = $reqBody['rowNumber'];
    $name = $reqBody['guestName'];
    $notes = $reqBody['guestNotes'];
    $status = $reqBody['guestStatus'];
    

    update_sub_field( array('guest_list', $rowToUpdate, 'name'), $name,  $weddingPageId);
    update_sub_field( array('guest_list', $rowToUpdate, 'notes'), $notes,  $weddingPageId);
    update_sub_field( array('guest_list', $rowToUpdate, 'status'), $status,  $weddingPageId);

    echo json_encode(['status' => true]);
    exit();
}

add_action('wp_ajax_addGuest', 'addGuest');
add_action('wp_ajax_nopriv_addGuest', 'addGuest');
function addGuest(){
    $reqBody = $_REQUEST['data'];
    global $current_user; 
    wp_get_current_user();


    // get the wedding page id
    $weddingPageId = $current_user->user_page_id;

    $row_count = count(get_field('guest_list', $weddingPageId)?: []);

	// the new row that we wanna add
	$row = ['name' => $reqBody['guestName'], 'notes' => $reqBody['guestNotes'], 'status' => $reqBody['guestStatus']];

	// update it as the next index (++$row_count)
	update_row('guest_list', ++$row_count, $row, $weddingPageId);

    echo json_encode(['status' => true]);
    exit();

}

add_action('wp_ajax_updateTodoStatus', 'updateTodoStatus');
add_action('wp_ajax_nopriv_updateTodoStatus', 'updateTodoStatus');
function updateTodoStatus(){

    global $current_user; 
    wp_get_current_user();


    // get the wedding page id
    $weddingPageId = $current_user->user_page_id;


    $reqBody = $_REQUEST['data'];
    $rowToUpdate = $reqBody['rowToUpdate'];
    $status = $reqBody['status'];
    $statusToInsert;
    if($status === 'false'){
        $statusToInsert = 0;
    }else{
        $statusToInsert = 1;
    }
    update_sub_field( array('to_do',$rowToUpdate, 'done'), $statusToInsert,  $weddingPageId);

    echo json_encode(['status' => $status]);
    exit();
}


add_action('wp_ajax_deleteMessage', 'deleteMessage');
add_action('wp_ajax_nopriv_deleteMessage', 'deleteMessage');
function deleteMessage(){
    $messageIdToDelete = $_REQUEST['idToDelete'];
    wp_trash_post( $messageIdToDelete );
    echo json_encode(['status' => $messageIdToDelete]);
    exit();
}

add_action('wp_ajax_addToWishlist', 'addToWishlist');
add_action('wp_ajax_nopriv_addToWishList', 'addToWishList');
function addToWishList(){
    $userId = $_REQUEST['userId'];
    $listingId = $_REQUEST['listingId'];

    // echo json_encode(['status' => $_REQUEST]);

    // $userId, $meta_key, $new_value
    $meta_key = 'couple_wishlist';
    
    // delete_user_meta($userId, $meta_key);
    // exit();
    
    $meta = get_user_meta($userId, $meta_key, true);
    // Do some defensive coding - if it's not an array, set it up

    // if ( !array($meta) == false ) {
    if ( !is_array($meta) ) {
        $meta = array();
    }


    // Push a new value onto the array
    if(!in_array($listingId, $meta)){
        $meta[] = $listingId;
        update_user_meta($userId, $meta_key, $meta);
        echo json_encode(['status' => true]);
    }
    exit();
}

add_action('wp_ajax_removeToWishList', 'removeToWishList');
add_action('wp_ajax_nopriv_removeToWishList', 'removeToWishList');
function removeToWishList(){
    $userId = $_REQUEST['userId'];
    $listingId = $_REQUEST['listingId'];

    $meta_key = 'couple_wishlist';
    
    
    $meta = get_user_meta($userId, $meta_key, true);
    
    if ( !is_array($meta) ) {
        $meta = array();
    }
    
    $meta = array_diff($meta, array($listingId));
    update_user_meta($userId, $meta_key, $meta);
    echo json_encode(['status' => true]);
    exit();
}


add_action('wp_ajax_updateIndicator', 'updateIndicator');
add_action('wp_ajax_nopriv_updateIndicator', 'updateIndicator');
function updateIndicator(){
    $postId = $_REQUEST['postId'];
    $value = $_REQUEST['value'];
    update_post_meta($postId, 'indicator', $value);
    echo json_encode(['status' => $postId]);
    exit();
}

