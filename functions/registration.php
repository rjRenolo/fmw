<?php



//Redirect non-admin users to home page
//This function is attached to the 'admin_init' action hook.
function redirect_non_admin_users() {
    // if ( ! current_user_can( 'manage_options' ) && '/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF'] ) {
    if ( ! current_user_can( 'manage_options' ) && !defined( 'DOING_AJAX' ) && !current_user_can('administrator') ) {
        wp_redirect( get_field('login_page','option') );
        exit;
    }
}
add_action( 'admin_init', 'redirect_non_admin_users' );


//Add a new form element...
add_action( 'register_form', 'atw_register_form' );
function atw_register_form() { ?>
        <p>
            <label for="title"><?php _e( 'Business Name', 'mydomain' ) ?></label>
            <input type="text" name="title" id="title" class="input" value="" size="45" required/>
            <small>Enter the name of your business</small>
        </p>

        <?php
}
add_action( 'register_form_couples', 'atw_register_form_couples' );
function atw_register_form_couples() { ?>
        <p>
            <label for="title"><?php _e( 'Couple Name', 'mydomain' ) ?></label>
            <input type="text" name="title" id="title" class="input" value="" size="45" required/>
            <small>e.g. Alice and Derek</small>
        </p>
        
        <?php
}




function setUserPasswordOnRegister( $user_id ) {
    do_action('custom_logger', 'set password');
    if ( isset( $_POST['user_password'] ) ){   
        wp_set_password( $_POST['user_password'], $user_id );
        // add_user_meta($user_id, 'user_subscription_expiry', 'Please Subscribe');
        // add_user_meta($user_id, 'subscription_id', 'Please Subscribe');
    }
}
add_action('user_register','setUserPasswordOnRegister');

add_action('register_post', 'fmw_register_fail_redirect', 99, 3);

function fmw_register_fail_redirect( $sanitized_user_login, $user_email, $errors ){
    //this line is copied from register_new_user function of wp-login.php
    $errors = apply_filters( 'registration_errors', $errors, $sanitized_user_login, $user_email );
    //this if check is copied from register_new_user function of wp-login.php
    if ( $errors->get_error_code() ){
        //setup your custom URL for redirection
        $urlPath;
        if(isset($_POST['userType'])){ // couple url
            $redirect_url = get_the_permalink(get_field('couples_join_now_page','option'));
        }else{ // business url
            $redirect_url = get_the_permalink(get_field('business_join_now_page','option'));
        }

        //add error codes to custom redirection URL one by one
        foreach ( $errors->errors as $e => $m ){
            $redirect_url = add_query_arg( $e, '1', $redirect_url );    
        }
        //add finally, redirect to your custom page with all errors in attributes
        wp_redirect( $redirect_url );
        exit;   
    }
}


//This hook fires AFTER the user is registered
//Save our extra registration user meta.
function atw_user_register( $user_id ) {

    if(isset($_POST['userType'])){
        $args = array(
            'post_title' => $_POST['name1'] . " & " . $_POST['name2'],
            'post_status' => 'publish',
            'post_type' => 'wedding'
        );
        $new_user_page = wp_insert_post($args);
        if ( ! empty( $new_user_page ) ) {
            update_user_meta( $user_id, 'user_page_id', sanitize_text_field( $new_user_page ) );
        }
        $user = new WP_User($user_id);
        $user->set_role('couple');

    }else{

        //Create a page for the new registered user
        $args = array(
            'post_title' => $_POST['title'],
            'post_status' => 'publish',
            'post_type' => 'listing'
        );
        $new_user_page = wp_insert_post($args);
        add_post_meta($new_user_page, 'listing_owner_email', $_POST['user_email'], true);
        add_post_meta($new_user_page, 'listing_owner_id', $user_id, true);
        
        //Save the user page against the user
        if ( ! empty( $new_user_page ) ) {
            update_user_meta( $user_id, 'user_page_id', sanitize_text_field( $new_user_page ) );
            term_insertion($_POST['licenseType'], 'listing-license', $new_user_page, false );
        }

        $user = new WP_User($user_id);
        $user->set_role('business');
    }

    $redirect_url = get_the_permalink(get_field('login_page','option'));
    //wp_redirect( $redirect_url );

    do_action('custom_logger', 'successful register');

}
add_action( 'user_register', 'atw_user_register' );

//////////////////////////////////////////////
// New :                                    //
// Create Listing page after user subscribe //
// [user_id, business_title]
//////////////////////////////////////////////


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

