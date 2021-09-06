<?php

//Redirect non-admin users to home page
//This function is attached to the 'admin_init' action hook.
function redirect_non_admin_users() {
    if ( ! current_user_can( 'manage_options' ) && '/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF'] ) {
        wp_redirect( get_field('business_login_page','option') );
        exit;
    }
}
add_action( 'admin_init', 'redirect_non_admin_users' );

// Add a custom user role
$result = add_role( 'couples', __(
'Couples' ),
    array(
        'read' => true, 
        'edit_posts' => true, // Allows user to edit their own posts
        'edit_pages' => false,
        'edit_others_posts' =>false, 
        'create_posts' => true, 
        'manage_categories' => false, 
        'publish_posts' => true, 
        'edit_themes' => false, 
        'install_plugins' => false, 
        'update_plugin' => false, 
        'update_core' => false 
    )
);


//This hook fires BEFORE the user is registered
//Take payment here and register the user once succssful
function subscribe_user_before_registration( $user_login, $user_email, $errors ) {

    do_action('custom_logger', 'subscribe');
}
add_action( 'register_post', 'subscribe_user_before_registration', 10, 3 );



function setUserPasswordOnRegister( $user_id ) {
    if ( isset( $_POST['user_password'] ) ){   
        wp_set_password( $_POST['user_password'], $user_id );
    }
}
add_action('user_register','setUserPasswordOnRegister');


//This hook fires AFTER the user is registered
//Save our extra registration user meta.
function atw_user_register( $user_id ) {

    //Create a page for the new registered user
    if(isset($_POST['userType'])){

    }else{

        $args = array(
            'post_title' => $_POST['title'],
            'post_status' => 'publish',
            'post_type' => 'listing'
        );
        $new_user_page = wp_insert_post($args);
        
        //Save the user page against the user
        if ( ! empty( $new_user_page ) ) {
            update_user_meta( $user_id, 'user_page_id', sanitize_text_field( $new_user_page ) );
        }
    }


}
add_action( 'user_register', 'atw_user_register' );


// TODO HERE
//add columns to User panel list page
function atw_add_user_columns($column) {
    $column['user_page_id'] = 'Listing';
    $column['user_subscription_expiry'] = 'Expiry Date';
    return $column;
}
add_filter( 'manage_users_columns', 'atw_add_user_columns' );

//add the data to the columns
function atw_add_user_column_data( $val, $column_name, $user_id ) {
    $user = get_userdata($user_id);

    switch ($column_name) {
        case 'user_page_id' :
            return get_the_title($user->user_page_id);
            break;
        case 'user_subscription_expiry' :
            return 'Add subscription expiry date here';
            break;
        default:
    }
    return;
}
add_filter( 'manage_users_custom_column', 'atw_add_user_column_data', 10, 3 );

