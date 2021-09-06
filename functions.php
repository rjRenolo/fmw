<?php

//Ajax registration
add_action('wp_ajax_register_user_front_end', 'register_user_front_end', 0);
add_action('wp_ajax_nopriv_register_user_front_end', 'register_user_front_end');
function register_user_front_end() {
    
    require_once(THEME_DIR . '/inc/todo_data.php');

    // $role = 'subscriber';
    // if($_POST['userType'] =="couple") {
    //     $role = "couple";
    // }
    // if($_POST['userType'] =="business") {
    //     $role = "business";
    // }

    $new_user_name = stripcslashes($_POST['new_user_name']);
    $new_user_email = stripcslashes($_POST['new_user_email']);
    $new_user_password = $_POST['new_user_password'];
    $user_nice_name = strtolower($_POST['new_user_email']);
    // $role = 'couple';

    $user_data = array(
          'user_login' => $new_user_name,
          'user_email' => $new_user_email,
          'user_pass' => $new_user_password,
          'user_nicename' => $user_nice_name,
          'display_name' => $new_user_first_name,
        //   'role' => $role
    );

    $user_id = wp_insert_user($user_data);
        if (!is_wp_error($user_id)) {
            do_action('custom_logger', $_POST);
            
            $userPageId = get_user_meta($user_id, 'user_page_id', true);
            // save wedmatch
            update_user_meta( $user_id, 'wedmatch_name1', sanitize_text_field( $_POST['name1'] ) );
            update_user_meta( $user_id, 'wedmatch_name1status', sanitize_text_field( $_POST['name1status'] ) );
            update_user_meta( $user_id, 'wedmatch_name2', sanitize_text_field( $_POST['name2'] ) );
            update_user_meta( $user_id, 'wedmatch_name2status', sanitize_text_field( $_POST['name2status'] ) );

            if($_POST['userdescription']){
                update_user_meta( $user_id, 'wedmatch_userdescription', $_POST['userdescription'] );
                // user_page_id
                update_field('user_type', $_POST['userdescription'], $userPageId);
            }
            
            if($_POST['weddingDate']){
                update_user_meta( $user_id, 'wedmatch_weddingdate', $_POST['weddingDate'] );
                $exploded = explode("/", $_POST['weddingDate']);
                $formatedDate = $exploded[2] . $exploded[1] . $exploded[0];
                update_field( 'wedding_date', $formatedDate, $userPageId );
            }
            
            update_user_meta( $user_id, 'wedmatch_listinglicensetype', $_POST['listingLicenseType'] );

            if($_POST['ceremonyGuests'] != "0"){
                update_user_meta( $user_id, 'wedmatch_ceremonyguests', $_POST['ceremonyGuests'] );
            }

            update_user_meta( $user_id, 'wedmatch_listingvenuetype', $_POST['listingVenueType'] );

            update_user_meta( $user_id, 'wedmatch_location', $_POST['location'] );

            if(isset($_POST['listingAccommodation'])){
                $meta = get_user_meta($user_id, 'wedmatch_listingaccommodation', false);
                if ( ! array($meta) ) {
                    $meta = array();
                }
                foreach($_POST['listingAccommodation'] as $item){
                    $meta[] = $item;
                }
                update_user_meta($user_id, 'wedmatch_listingaccommodation', $meta);
            }
            if(isset($_POST['listingFoodDrink'])){
                $meta = get_user_meta($user_id, 'wedmatch_listingFoodDrink', false);
                if ( ! array($meta) ) {
                    $meta = array();
                }
                foreach($_POST['listingFoodDrink'] as $item){
                    $meta[] = $item;
                }
                update_user_meta($user_id, 'wedmatch_listingFoodDrink', $meta);
            }
            if(isset($_POST['listingFeature'])){
                $meta = get_user_meta($user_id, 'wedmatch_listingFeature', false);
                if ( ! array($meta) ) {
                    $meta = array();
                }
                foreach($_POST['listingFeature'] as $item){
                    $meta[] = $item;
                }
                update_user_meta($user_id, 'wedmatch_listingFeature', $meta);
            }

            if($_POST['receptionGuests'] != "0"){
                update_user_meta( $user_id, 'wedmatch_receptionGuests', $_POST['receptionGuests'] );
            }

            update_user_meta( $user_id, 'wedmatch_listingStyle', $_POST['listingStyle'] );

            if(isset($_POST['category'])){
                $meta = get_user_meta($user_id, 'wedmatch_category', false);
                if ( ! array($meta) ) {
                    $meta = array();
                }
                foreach($_POST['category'] as $item){
                    $meta[] = $item;
                }
                update_user_meta($user_id, 'wedmatch_category', $meta);
            }

            // pre-populate to do
            $todoCount = count(get_field('to_do', $userPageId)?: []);
            foreach($todoData as $todo){
                $row = [
                    'to_do_name' => $todo,
                    'done' => false
                ];
                update_row('to_do', ++$todoCount, $row, $userPageId);
            }


          echo 'success';
        } else {
            if (isset($user_id->errors['empty_user_login'])) {
              $notice_key = 'Username and email are mandatory';
              echo $notice_key;
            } elseif (isset($user_id->errors['existing_user_login'])) {
              echo'User name already exists';
            } elseif (isset($user_id->errors['existing_user_email'])) {
              echo'A user with that email already exists';
            } else {
              echo'Whoops! An error occurred please fill out the form carefully.';
            }
        }
    die;
}



define('THEME_DIR', get_stylesheet_directory());

	//add_filter('acf/settings/show_admin', '__return_false');

	add_action('admin_head', 'editor_full_width_gutenberg');

	function editor_full_width_gutenberg() {
	  echo '<style>
	    body.gutenberg-editor-page .editor-post-title__block, body.gutenberg-editor-page .editor-default-block-appender, body.gutenberg-editor-page .editor-block-list__block {
			max-width: none !important;
		}
	    .block-editor__container .wp-block {
	        max-width: none !important;
	    }
	  </style>';
	}

	if( function_exists('acf_add_options_page') ) {

        // Register options page.
        $option_page = acf_add_options_page(array(
            'page_title'    => __('Site Settings'),
            'menu_title'    => __('Site Settings'),
            'menu_slug'     => 'site-settings'
        ));
    }

	function ds_custom_excerpt_length( $length ) {
	    return 20;
	}
	add_filter( 'excerpt_length', 'ds_custom_excerpt_length', 999 );

	function acf_image_output_url($id, $size) {
		$image = wp_get_attachment_image_src( $id, $size );
		return $image[0];
	}

	
	function wa_setup_theme_supported_features() {
	    add_theme_support( 'editor-color-palette', array(
		      
		        array(
		            'name' => __( 'Black', 'themeLangDomain' ),
		            'slug' => 'black',
		            'color' => '#222222',
		        ),
		        array(
		            'name' => __( 'White', 'themeLangDomain' ),
		            'slug' => 'white',
		            'color' => '#ffffff',
		        ),
		        array(
		            'name' => __( 'Dark Blue', 'themeLangDomain' ),
		            'slug' => 'dark-blue',
		            'color' => '#27368d',
		        ),
		        array(
		            'name' => __( 'Light Blue', 'themeLangDomain' ),
		            'slug' => 'light-blue',
		            'color' => '#4ab4e8',
		        )
		    ) );
	}

	//Add custom logo to login page
	function wa_login_logo() {
		?>

		<style type="text/css">
			body.login div#login h1 a {
			background-image: url(); 
			padding-bottom: 30px;
			width: 100%;
			background-size: auto 100%;
			}
		</style>

	<?php }
	add_action( 'login_enqueue_scripts', 'wa_login_logo' );


	/*** Disable the admin bar ***/
	add_action('after_setup_theme', 'remove_admin_bar');
	function remove_admin_bar() {
		if (!current_user_can('administrator') && !is_admin()) {
		  show_admin_bar(false);
		}
	}

	// Function to change email address
	function wpb_sender_email( $original_email_address ) {
		return 'donotreply@findmywedding.co.uk';
	}
	// Function to change sender name
	function wpb_sender_name( $original_email_from ) {
		return 'Find My Wedding';
	}
	// Hooking up our functions to WordPress filters 
	add_filter( 'wp_mail_from', 'wpb_sender_email' );
	add_filter( 'wp_mail_from_name', 'wpb_sender_name' );


    // allow comments for message
    function default_comments_on( $data ) {
        if( $data['post_type'] == 'message' ) {
            $data['comment_status'] = 'open';
        }
    
        return $data;
    }
    add_filter( 'wp_insert_post_data', 'default_comments_on' );
    
    add_filter('comment_flood_filter', '__return_false');

    //////////////////////
    // Comment Response //
    //////////////////////
    function send_email_on_comment_response( $comment_ID, $comment_approved ) {
            $comment = get_comment( $comment_ID, OBJECT ); // get the comment author details, identift if it is a business or couple then proceed
            $post_id = $comment->comment_post_ID; // here i can automaticall get the couple details post_author_email
            $whoComment = get_userdata($comment->user_id);

            $listingOwnerEmail = get_post_meta($post_id, 'business_email', true);
            $coupleEmail = get_post_meta($post_id, 'couple_email', true);

    
            if(get_post_type($post_id) == 'message') {

    
                $author_id = get_post_field ('post_author', $post_id);
                $user = get_userdata($author_id);

                $display_name = get_the_title($user->user_page_id);
    
                $post_url = get_permalink( $post_id );
                // $subject = 'Support Ticket: ' . $company . ' [Ticket: ' . $post_id. '] ' . get_the_title($post_id) . '';
                $subject = 'Find My Wedding Equiry Response ' . get_the_date('F j, Y, g:i a', $post_id);
    
                $message = "<table border=0 cellspacing=10 cellpadding=10 align=center width=800><tr><td  colspan=2><strong>". $subject . "</strong></td></tr>";
                $message .= "<tr><td width=80>Enquiry thread: </td><td><strong><a href='" . $post_url . "'>" . get_the_title($post_id) . "</a></strong></td></tr>";
    
                $message .= "<tr><td width=80 colspan=2>Response: </td></tr>";
                $message .= "<tr><td width=80 colspan=2>" . get_comment_text($comment_ID) . "</td></tr>";
    
                if( have_rows('attachments',$post_id) ):
                        //$message .= "<tr><td colspan=2>Attachments: </td></tr>";
                        $count = 1;
                        while ( have_rows('attachments',$post_id) ) : the_row();
    
                            //$message .= "<tr><td colspan=2><a href='" . get_sub_field('attachment') . "'>Attached File " . $count . "</a></td></tr>";
                            $count ++;
    
                        endwhile;
                endif;
    
                $message .= "</table>";
    
    
                $headers[] = 'Content-Type: text/html; charset=UTF-8';
                $headers[] = 'From: Find My Wedding <donotreply@findmywedding.com>';
    
                //Send response email
                wp_mail( $listingOwnerEmail, $subject, $message, $headers );
                wp_mail( $coupleEmail, $subject, $message, $headers );
            }
    }
    
    add_action( 'comment_post', 'send_email_on_comment_response', 10, 2 );
    
    
    function unreadReplyFlagging($comment_ID, $comment_approved){
        $comment = get_comment( $comment_ID, OBJECT );
        $post_id = $comment->comment_post_ID;
        $whoComment = get_userdata($comment->user_id);
        // $user_meta=get_userdata($user_id);

        $user_roles=$whoComment->roles;
        do_action('custom_logger', $user_roles[0]);
        do_action('custom_logger', $whoComment);
        if($user_roles[0] === 'business'){
            update_post_meta( $post_id, 'listing_new_reply', 1, true );
        }else if($user_roles[0] === 'couple'){
            update_post_meta( $post_id, 'couple_new_reply', 1, true );
        }
    }
    add_action( 'comment_post', 'unreadReplyFlagging', 10, 2 );

    require_once('parts/custom-block-styles.php');

	/* ========================================================================================================================
	
	Disable gutenberg in some post type
	
	======================================================================================================================== */
    add_filter('use_block_editor_for_post_type', 'prefix_disable_gutenberg', 10, 2);
    function prefix_disable_gutenberg($current_status, $post_type)
    {
        // Use your post type key instead of 'product'
        if ($post_type === 'message') return false;
        return $current_status;
    }

	/* ========================================================================================================================
	
	Required external files
	
	======================================================================================================================== */
	
	add_action('custom_logger', 'rjrenolo_logger');
	function rjrenolo_logger($data){
		$log =  "/////////////////////////". PHP_EOL.
		"// ". date("Y-m-d H-i-s") . " //".PHP_EOL.
		"/////////////////////////".PHP_EOL.PHP_EOL.
		print_r($data,1).PHP_EOL.
		"--------------------------------------------------------------------------------------".PHP_EOL.PHP_EOL.PHP_EOL;
		file_put_contents(THEME_DIR . '/custom_logs.txt', $log, FILE_APPEND);
	}
    
	add_action('webhook_logger', 'rjrenolo_webhook_logger');
	function rjrenolo_webhook_logger($data){
		$log =  "/////////////////////////". PHP_EOL.
		"// ". date("Y-m-d H-i-s") . " //".PHP_EOL.
		"/////////////////////////".PHP_EOL.PHP_EOL.
		print_r($data,1).PHP_EOL.
		"--------------------------------------------------------------------------------------".PHP_EOL.PHP_EOL.PHP_EOL;
		file_put_contents(THEME_DIR . '/webhook-logs.txt', $log, FILE_APPEND);
	}


	

	require_once( 'external/embers-utilities.php' );

	require_once( 'parts/admin-blocks.php' );

	require_once( 'functions/registration.php' );
	
	require_once( 'functions/stripe-subscribe.php' );
	
	require_once( 'functions/stripe-webhook.php' );

    require_once( 'functions/listing-information-ajax.php' );

    require_once( 'functions/couple-ajax.php' );

    require_once( 'functions/listing-ajax.php' );

    require_once( 'functions/debugger.php' );

	/* ========================================================================================================================
	
	Theme specific settings

	======================================================================================================================== */

	add_theme_support('post-thumbnails');
	
	register_nav_menus(array('primary' => 'Primary Navigation', 'footer' => 'Footer', 'footerright' => 'Footer Right','coupledashboard' => 'Couple Dashboard', 'listingdashboard' => 'Listing Dashboard'));

	/* ========================================================================================================================
	
	Actions and Filters
	
	======================================================================================================================== */

	add_action( 'wp_enqueue_scripts', 'embers_script_enqueuer' );

	add_filter( 'body_class', array( 'Embers_Utilities', 'add_slug_to_body_class' ) );


    add_filter( 'custom_card_excerpt', 'customCardExcerpt', 10, 1);
    function customCardExcerpt($theListingDescription){
        // 45 words
        $sliced = explode(' ', $theListingDescription);
        $theListingDescriptionExcerpt = implode(' ', array_slice($sliced, 0, 50));
        return $theListingDescriptionExcerpt . '...';
    }
	
	// Add styles to the WYSIWYG editor.  Function finds stylesheet from the root of the current theme's folder.   
	//add_editor_style('style.css');

	/* ========================================================================================================================
	
	Custom Post Types 
	
	======================================================================================================================== */
	
	require_once( 'custom-post-type/listing.php' );
	require_once( 'custom-post-type/weddings.php' );
	require_once( 'custom-post-type/package.php' );
	require_once( 'custom-post-type/message.php' );

    /* ========================================================================================================================
	
	Externals
	
	======================================================================================================================== */


    require_once( 'inc/subscription-cron.php' );



	/* ========================================================================================================================
	
	Scripts
	
	======================================================================================================================== */

	function embers_script_enqueuer() {
		wp_register_script( 'shiv', get_template_directory_uri().'/js/html5shiv.js', array( 'jquery' ) );
		wp_enqueue_script( 'shiv' );

		wp_register_script( 'site', get_template_directory_uri().'/js/site.js', array( 'jquery' ) );
		wp_enqueue_script( 'site' );

        $googleMapApiKey = get_field('google_map_api_key', 'options');
        wp_register_script( 'gmaps', "https://maps.googleapis.com/maps/api/js?key=$googleMapApiKey", array( 'jquery' ));
        wp_enqueue_script('gmaps');

		wp_register_script( 'card', get_template_directory_uri().'/assets/card/card.js', array( 'jquery' ) );
		wp_enqueue_script( 'card' );

		wp_register_style( 'screen', get_stylesheet_directory_uri().'/style.css', '', '', 'screen' );
        wp_enqueue_style( 'screen' );
		
		wp_register_style( 'card-style', get_template_directory_uri().'/assets/card/card.css', '', '', 'card-style' );
        wp_enqueue_style( 'card-style' );


        wp_register_script( 'owl-carousel', get_template_directory_uri().'/js/owl.carousel.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'owl-carousel' );
        wp_register_style( 'owl-style', get_template_directory_uri().'/css/owl.carousel.min.css', '', '', 'owl-style' );
        wp_enqueue_style( 'owl-style' );
        wp_register_style( 'owl-default-theme', get_template_directory_uri().'/css/owl.theme.default.min.css', '', '', 'owl-default-theme' );
        wp_enqueue_style( 'owl-default-theme' );

	}	

	/* ========================================================================================================================
	
	Admin Menus
	
	======================================================================================================================== */

    function theme_section_description(){
        // echo '<p>Theme Option Section</p>';
    }
    function options_callback(){
        echo '<p>This is the new Setting</p>';
    }
    function test_theme_settings(){
        add_settings_section( 'first_section', 'Stripe Secret Key', 'theme_section_description','theme-options');


        add_option('stripe_secret_key', '');
        add_settings_field('stripe_secret_key', 'Stripe secret key', 'display_stripe_secret_key_element', 'theme-options', 'first_section');
        register_setting( 'theme-options-grp', 'stripe_secret_key');
    }
    add_action('admin_init','test_theme_settings');


    
    function display_stripe_secret_key_element(){
    //php code to take input from text field for twitter URL.
    ?>
        <input type="text" name="stripe_secret_key" id="stripe_secret_key" value="<?php echo get_option('stripe_secret_key'); ?>" />
    <?php
    }

    



	/* ========================================================================================================================
	
	User Roles
	
	======================================================================================================================== */
    function wedding_roles() {  
 
        //add the new user role
        add_role( 'business', __(
            'Business' ),
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
        add_role( 'couple', __(
            'Couple' ),
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
     
    }
    add_action('admin_init', 'wedding_roles');




	/* ========================================================================================================================
	
	Comments
	
	======================================================================================================================== */

	function embers_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment; 
		?>
		<?php if ( $comment->comment_approved == '1' ): ?>	
		<li>
			<article id="comment-<?php comment_ID() ?>">
				<?php echo get_avatar( $comment ); ?>
				<h4><?php comment_author_link() ?></h4>
				<time><a href="#comment-<?php comment_ID() ?>" pubdate><?php comment_date() ?> at <?php comment_time() ?></a></time>
				<?php comment_text() ?>
			</article>
		<?php endif;
	}



	/* ========================================================================================================================
	
	Filters
	
	======================================================================================================================== */
	function unixToReadableDate($unistamp){
		// $datetime = new DateTime("$unistamp"); 
		// $formated = $datetime->format('F j, Y');
		// return $formated;
        return date('F j, Y', "$unistamp");
	}
	add_filter('unix_handler', 'unixToReadableDate');

    function subscripstionTypeGetter($userId){
        $subscriptionType = get_user_meta( $userId, 'subscription_type' , true );
        $theType = '';

        // if($subscriptionType === 'bronze'){
        //     $theType = 'Basic';
        // }else if($subscriptionType === 'silver'){
        //     $theType = 'Penyfan';
        // }else if($subscriptionType === 'gold'){
        //     $theType = 'Snowdon';
        // }else{
        //     $theType = 'N/A';
        // }
        // return $theType;
        switch($subscriptionType){
            case 'basic':
                return "Basic";
            case 'better':
                return "Better";
            case 'best':
                return "Best";
            deafult:
                return 'N/A';
        }
    }
    add_filter('get_subscriptiontype', 'subscripstionTypeGetter');

    function subscriptionStatus($userId){
        $subscriptionStatus = get_user_meta($userId, 'subscription_status', true);
        if($subscriptionStatus){
            return $subscriptionStatus;
        }else{
            return "N/A";            
        }
    }
    add_filter('get_subscriptionstatus', 'subscriptionStatus');

    function getSubscriptionExpiryDate($userId){
        $user_subscription_expiry = get_user_meta( $userId, 'user_subscription_expiry' , true );
        return $user_subscription_expiry;
    }
    add_filter('get_subscriptionexpirydate', 'getSubscriptionExpiryDate');

    function premiumBadgeGetter($postId){
        $userOwnderId = get_post_meta($postId, 'listing_owner_id', true);
        $theBadge = '';
        if($userOwnderId){
            $subscriptionType = get_user_meta( $userOwnderId, 'subscription_type' , true );
            if($subscriptionType === 'gold'){
                $theBadge = '<div class="premBadge">Premier Supplier</div>';
            }
        }
        return $theBadge;
    }
    add_filter('get_premiumbadge', 'premiumBadgeGetter');
	
	
	function my_enqueue_scripts() {
		wp_enqueue_script('jquery');
        wp_localize_script( 'jquery', 'fmw_ajax', array(
			'ajaxurl'       => admin_url( 'admin-ajax.php' ))
        );
    }
    add_action('wp_enqueue_scripts','my_enqueue_scripts');
	


    add_filter('wp_mail','check_the_mail_content');

    function check_the_mail_content($args){
        // do_action('custom_logger', $args);
        if($args['subject'] === '[Find My Wedding] Login Details'){ 

            $args['subject'] = 'Welcome to Find My Wedding!';

            $args["message"] = '<h3>Welcome to Find My Wedding!</h3>';

            $args["message"] .= "<p>We look forward to helping you plan your dream day.<br />Head to your Find My Wedding dashboard to find out all the handy planning tools available to you.<br />Find out from others about their experiences in the blog.</p><p>Why not follow us on social - <a href='https://twitter.com/FindMyWeddingUK' target='_blank'>twitter</a> / <a href='https://www.facebook.com/findmywedding.co.uk' target='_blank'>facebook</a> / <a href='https://www.instagram.com/findmywedding.co.uk/' target='_blank'>instagram</a></p>";

            $args["message"] .= '<p>Log in to your account - <a href="' . get_the_permalink(get_field('login_page','option')) . '">Log in</a><p>';
        }
        return $args;
    }

    /* END========================================================================================================================
	
	Filters
	
	======================================================================================================================== */




	function change_password_form() { ?>

        <!-- <button id="btn__change_password">Change Password</button> -->

		<form action="" method="post" id="form__change_password">
			<label for="current_password">Enter your current password:</label>
			<input type="password" name="current_password" id="current_password" required>

			<label for="new_password">Enter your new password:</label>
			<input type="password" name="new_password" id="new_password" required>

			<label for="confirm_new_password">New password confirmation:</label>
			<input type="password" name="confirm_new_password" id="confirm_new_password" required>

			<input type="submit" value="Change Password">
		</form>
        <script>
            jQuery('#btn__change_password').on('click', (e) => {
                jQuery('#form__change_password').slideDown()
                jQuery('#btn__change_password').hide()
            })
        </script>

	<?php }

	function change_password(){

		
		if(isset($_POST['current_password'])){
			$_POST = array_map('stripslashes_deep', $_POST);

			$current_password = sanitize_text_field($_POST['current_password']);
			$new_password = sanitize_text_field($_POST['new_password']);
			$confirm_new_password = sanitize_text_field($_POST['confirm_new_password']);

			$userId = get_current_user_id();
			$current_user = get_user_by('id', $userId);

			
			
			$errors = array();
			// basic validation
			if(empty($current_password) && empty($new_password) && empty($confirm_new_password)){
				$errors[] = 'All fields are required';
			}

			if($current_user && wp_check_password($current_password, $current_user->data->user_pass, $current_user->ID)){
				// current password matched
			}else{
				$errors[] = 'Password is incorrect';
			}

			if($new_password != $confirm_new_password){
				$errors[] = 'Password does not match';
			}

			if(empty($errors)){ // change password here
				wp_set_password($new_password, $current_user->ID);
				echo '<h3>Password successfuly changed.</h3>';
			}else{
				echo "<p>An error occured</p>";
				foreach($errors as $err){
					echo '<p>';
					echo '<strong>'. $err .'</strong>';
					echo '</p>';
				}
			}
		}
	}

	function do_change_password(){
		change_password();
		change_password_form();
	}
	add_shortcode( 'change_password', 'do_change_password' );





    // test
    // add_action('wp_head', 'testFunc');
    function testFunc(){

    }


    function term_insertion($termToInsert, $tax, $pID, $append){
        $termChallenge = wp_insert_term($termToInsert, $tax);
        
        $toTermID = '';
        if(isset($termChallenge->error_data)){
            $toTermID = $termChallenge->error_data['term_exists'];
            $res = wp_set_post_terms($pID, $toTermID, $tax, $append);
        }else{
            $toTermID = $termChallenge['term_id'];
            
            $res = wp_set_post_terms($pID, $toTermID, $tax, $append);
        }

    }


    // Lets create a reusable function for simplicity
    /*
    * @param int $user id
    * @param string $meta_key
    * @param string $new_value - the new value to be added to the array
    */
    function update_done_steps($user_id, $meta_key, $new_value) {
        // Get the existing meta for 'meta_key'
        $meta = get_user_meta($user_id, $meta_key, true);
        // Do some defensive coding - if it's not an array, set it up
        if ( ! array($meta) ) {
            $meta = array();
        }
        // Push a new value onto the array
        if(!in_array($new_value, $meta)){
            $meta[] = $new_value;
            update_user_meta($user_id, $meta_key, $meta);
        }
        // Write the user meta record with the new value in it
    }


    ///////////////////////////////////////
    // Redirect User when Invalid Log In //
    ///////////////////////////////////////
    add_action( 'wp_login_failed', 'my_front_end_login_fail' );  // hook failed login
    function my_front_end_login_fail( $username ) {
    $referrer = $_SERVER['HTTP_REFERER'];  // where did the post submission come from?

    $url = explode("?", $referrer)[0];

    do_action('custom_logger', $url);


    // if there's a valid referrer, and it's not the default log-in screen
    if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
        wp_redirect( $url . '?login=failed' );  // let's append some information (login=failed) to the URL for the theme to use
        exit;
    }
    }
    add_filter( 'authenticate', function( $user, $username, $password ) {
        // forcefully capture login failed to forcefully open wp_login_failed action, 
        // so that this event can be captured
        if ( empty( $username ) || empty( $password ) ) {
            do_action( 'wp_login_failed', $user );
        }
        return $user;
    }, 10, 3 );


    ///////////////////////////
    // add "Add To Wishlist" //
    ///////////////////////////
    add_action('add_wishlist_button', 'wishlistButton');
    function wishlistButton(){
        // if(is_user_logged_in()){
            // if(current_user_can( 'couple' )){
                global $current_user; 
                wp_get_current_user();
                $wishlist = get_user_meta( $current_user->ID, 'couple_wishlist', true );

                
                
                $isAdded = false;
                if($wishlist){
                    foreach($wishlist as $wish){
                        if($wish == get_the_ID()){
                            $isAdded = true;
                            
                            
                        }
                    }
                }
                
                ?>

                <?php 
                    $isAddedIcon = $isAdded == 1 ? 'heart-filled.svg':'heart.svg';
                    if(is_user_logged_in(  )){ ?>
                    

                    <a class="addToWishlist wish primary-btn md-btn">
                        <span>Add To Wishlist</span>
                        <img height="25px" width="25px" src="<?=get_bloginfo('template_directory');?>/images/global/fmw/<?=$isAddedIcon?>" alt="">
                    </a>
                    <script>
                        jQuery(document).ready((e) => {
                            var isAdded = '<?=$isAdded?>'
                            console.log(isAdded);
                            if(isAdded == 1){
                                jQuery('.addToWishlist').addClass('addedToWishlist');
                                jQuery('.addedToWishlist').removeClass('addToWishlist');
                                // jQuery('.addedToWishlist').text('Added to Wishlist');
                                jQuery('.addedToWishlist').find('span').text('Added to Wishlist');
                            }

                            jQuery('.addToWishlist').on('click', (e) => {
                                console.log('<?=$current_user->ID?>')
                                console.log('<?=get_the_ID()?>')
                                jQuery.ajax({
                                    url: fmw_ajax.ajaxurl,
                                    method: 'POST',
                                    data: {
                                        action: 'addToWishlist',
                                        userId: <?=$current_user->ID?>,
                                        listingId: <?=get_the_ID()?>
                                    },
                                    success: function(res){
                                        console.log(res)
                                        jQuery('.wish').addClass('addedToWishlist')
                                        jQuery('.wish').removeClass('addToWishlist')
                                        // jQuery('.wish').text('Added To Wishlist')
                                        jQuery('.wish').find('span').text('Added To Wishlist')
                                        location.reload()
                                    }
                                })
                            })


                            jQuery('.addedToWishlist').on('click', (e) => {
                                jQuery.ajax({
                                    url: fmw_ajax.ajaxurl,
                                    method: 'POST',
                                    data: {action: 'removeToWishList', userId: <?=$current_user->ID?>, listingId: <?=get_the_ID()?>},
                                    success: function(res){
                                        jQuery('.wish').addClass('addToWishlist')
                                        jQuery('.wish').removeClass('addedToWishlist')
                                        jQuery('.wish').text('Add To Wishlist')
                                        location.reload()
                                    }
                                })
                            })


                        })
                    </script>

                <?php 
                    }else{ ?>
                        
                        <a class="addToWishlist wish primary-btn btn-disabled md-btn">
                            <span>Add To Wishlist</span>
                            <img height="25px" width="25px" src="<?=get_bloginfo('template_directory');?>/images/global/fmw/heart.svg" alt="">
                        </a>
                        <a href="<?php echo get_the_permalink(get_field('login_page','option'));?>">Login to use this feature.</a>
                <?php
                    } ?>
                
                <?php
            // }
        // }
    }


    add_filter( 'term_getter', 'term_getter_callback', 10, 3);
    function term_getter_callback($postid, $tax, $returnType = 'single'){
        
        $termText = "";
        
        $term_list = get_the_terms( $postid, $tax );
        
        if($term_list){
            if($returnType === 'single'){

                foreach($term_list as $term){
                    
                    $termText .= $term->name;
                    
                    
                }
            }else{
                return $term_list;
            }
        }

        return $termText;
    }


    add_filter('termdID_getter', 'termID_getter', 10, 2);
    function termID_getter($postID, $tax){
        $termID = "";

        $term_list = wp_get_post_terms( $postID, $tax );

        
        $img = [];
        
        if($term_list){
            foreach($term_list as $term){
                           
                $termID .= $term->term_id;
                
            }
        }

        return $termID;
        
    }


    add_filter('taxonomy_images_getter', 'taxImageGetter');
    function taxImageGetter($termID){

        $t = new Taxonomy_Images_Term(get_term($termID));
        
        $img = wp_get_attachment_image( $t->get_image_id(), array(50, 50), false );
        

        return $img;


    }

    // add_action('wp_head', 'sometesting');
    function sometesting(){

        $theTerm = get_term(136);

        $t = new Taxonomy_Images_Term(get_term(136));
        $img = wp_get_attachment_image( $t->get_image_id(), array(50, 50), false );
        
        echo '<pre>';
        print_r($img);
        echo '</pre>';
        die();
    }




    add_filter('get_all_searchable_term', 'getAllSearchableTerm');
    function getAllSearchableTerm(){
        $searchableTerm = [];

        $allListingServiceTerm = get_terms(array(
            'taxonomy' => 'listing-service'
        ));
        $allListingVenueTypeTerm = get_terms(array(
            'taxonomy' => 'listing-venue-type'
        ));

        foreach($allListingServiceTerm as $item){
            // $searchableTerm[] = $item->name;
            $searchableTerm[] = array('slug' => $item->slug, 'name' => $item->name);
        }
        foreach($allListingVenueTypeTerm as $item){
            // $searchableTerm[] = $item->name;
            $searchableTerm[] = array('slug' => $item->slug, 'name' => $item->name);
        }
        return $searchableTerm;
    }


	add_filter('get_all_listing_services', 'getAllListingServices');
    function getAllListingServices(){
        $searchableTerm = [];

        $allListingServiceTerm = get_terms(array(
            'taxonomy' => 'listing-category'
            // 'taxonomy' => 'listing-service'
        ));

        foreach($allListingServiceTerm as $item){
            $searchableTerm[] = array('slug' => $item->slug, 'name' => $item->name);
        }
     
        return $searchableTerm;
    }

    add_filter('get_all_listing_counties', 'getAllListingCounties');
    function getAllListingCounties(){
        $searchableTerm = [];

        $allListingServiceTerm = get_terms(array(
            'taxonomy' => 'listing-location'
        ));

        foreach($allListingServiceTerm as $item){
            $searchableTerm[] = array('slug' => $item->slug, 'name' => $item->name);
        }
     
        return $searchableTerm;
    }

    add_filter('get_all_listing_styles', 'getAllListingStyles');
    function getAllListingStyles(){
        $searchableTerm = [];

        $allListingServiceTerm = get_terms(array(
            'taxonomy' => 'listing-style'
        ));

        foreach($allListingServiceTerm as $item){
            $searchableTerm[] = array('slug' => $item->slug, 'name' => $item->name);
        }
     
        return $searchableTerm;
    }

    add_filter('get_all_listing_capacity', 'getAllListingCapacity');
    function getAllListingCapacity(){
        $searchableTerm = [];

        $allListingServiceTerm = get_terms(array(
            'taxonomy' => 'listing-capacity'
        ));

        foreach($allListingServiceTerm as $item){
            $searchableTerm[] = array('slug' => $item->slug, 'name' => $item->name);
        }
     
        return $searchableTerm;
    }

    add_filter('get_all_listing_type', 'getAllListingType');
    function getAllListingType(){
        $searchableTerm = [];

        $allListingServiceTerm = get_terms(array(
            'taxonomy' => 'listing-venue-type'
        ));

        foreach($allListingServiceTerm as $item){
            $searchableTerm[] = array('slug' => $item->slug, 'name' => $item->name);
        }
     
        return $searchableTerm;
    }

    add_filter('get_all_listing_features', 'getAllListingFeatures');
    function getAllListingFeatures(){
        $searchableTerm = [];

        $allListingServiceTerm = get_terms(array(
            'taxonomy' => 'listing-features'
        ));

        foreach($allListingServiceTerm as $item){
            $searchableTerm[] = array('slug' => $item->slug, 'name' => $item->name);
        }
     
        return $searchableTerm;
    }

    add_filter('get_term_name_by_slug', 'getTermNameBySlug');
    function getTermNameBySlug($theSlug){
        $termName = "";
        foreach(getAllSearchableTerm() as $aTerm){
            if($aTerm['slug'] == $theSlug){
                $termName = $aTerm['name'];
            }
        }
        return $termName;
    }


    add_filter('service_venue_identifyer', 'isServiceOrVenue');
    function isServiceOrVenue($theTerm){
        $typeOf = "listing-venue-type";
        $allListingServiceTerm = get_terms(array(
            'taxonomy' => 'listing-service'
        ));
        foreach($allListingServiceTerm as $challenge){
            if($challenge->slug == $theTerm){
                $typeOf = "listing-service";
            }
        }

        return $typeOf;
    }

    function get_field_keys_from_group($group, $negate = array()) {
	
        $group			= (int) $group;
        $keys			= array();
        $all_field_keys		= acf_get_fields($group);
        //	var_dump ( $all_field_keys );
        foreach ( $all_field_keys as $field ) {
            $key = $field['key'];
            
            if ( !strstr($key,'field_') )
                continue;
            if ( in_array($key, $negate) )
                continue;
            
            $keys[] = $key;
            //	echo $field['label'] . ': ' . $key .'<br>';
        
        }
        return $keys;
    }
    add_filter('negate_acfformfield', 'get_field_keys_from_group', 10, 2);




    add_filter('listing_filter', 'listingFilter');
    function listingFilter(){

    }


    function wa_numeric_posts_nav() {
 
	    if( is_singular() )
	        return;
	 
	    global $wp_query;
	 
	    /** Stop execution if there's only 1 page */
	    if( $wp_query->max_num_pages <= 1 )
	        return;
	 
	    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
	    $max   = intval( $wp_query->max_num_pages );
	 
	    /** Add current page to the array */
	    if ( $paged >= 1 )
	        $links[] = $paged;
	 
	    /** Add the pages around the current page to the array */
	    if ( $paged >= 3 ) {
	        $links[] = $paged - 1;
	        $links[] = $paged - 2;
	    }
	 
	    if ( ( $paged + 2 ) <= $max ) {
	        $links[] = $paged + 2;
	        $links[] = $paged + 1;
	    }
	 
	    echo '<div class="navigation"><ul>' . "\n";
	 
	    /** Previous Post Link */
	    if ( get_previous_posts_link() )
	        printf( '<li>%s</li>' . "\n", get_previous_posts_link('« Back') );
	 
	    /** Link to first page, plus ellipses if necessary */
	    if ( ! in_array( 1, $links ) ) {
	        $class = 1 == $paged ? ' class="active"' : '';
	 
	        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );
	 
	        if ( ! in_array( 2, $links ) )
	            echo '<li>…</li>';
	    }
	 
	    /** Link to current page, plus 2 pages in either direction if necessary */
	    sort( $links );
	    foreach ( (array) $links as $link ) {
	        $class = $paged == $link ? ' class="active"' : '';
	        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
	    }
	 
	    /** Link to last page, plus ellipses if necessary */
	    if ( ! in_array( $max, $links ) ) {
	        if ( ! in_array( $max - 1, $links ) )
	            echo '<li>…</li>' . "\n";
	 
	        $class = $paged == $max ? ' class="active"' : '';
	        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
	    }
	 
	    /** Next Post Link */
	    if ( get_next_posts_link() )
	        printf( '<li>%s</li>' . "\n", get_next_posts_link('Next »') );
	 
	    echo '</ul></div>' . "\n";
	 
	}



    // add_action('wp_head', 'somefiltershere');
    function somefiltershere(){

        global $wp_query;
        // $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
        $args = array(
            'post_type' => 'listing',
            'tax_query' => array(
                // 'relation' => 'AND',
                array(
                    'taxonomy' => 'listing-license',
                    'field' => 'slug', 
                    // 'terms' => array( 106 ),
                    'terms' => 'venue',
                    'include_children' => true, 
                    'operator' => 'IN' 
                  ),
            ),
            'posts_per_page' =>20,   
            'paged' => get_query_var( 'paged', 1 ),
        );

        $the_query = new WP_Query( $args );

        // The Loop
        $idList = [];
        if ( $the_query->have_posts() ) :
        while ( $the_query->have_posts() ) : $the_query->the_post();
            
            // $theId = get_the_id();
            the_id();
            ?><br><?php
            foreach(get_the_terms(get_the_id(), 'listing-license') as $theTerm){
                
                echo '<pre>';
                print_r($theTerm->name);
                echo '</pre>';
                
            }
            
            
        endwhile;

        

        
 
        $big = 999999999; // need an unlikely integer
        
        echo paginate_links( array(
            // 'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            // 'format' => '?paged=%#%',
            // 'current' => max( 1, get_query_var('paged') ),
            'total' => $the_query->max_num_pages
        ) );
        
        
        
        endif;

        // Reset Post Data
        wp_reset_postdata();
    }



    //////////////////////////////
    // Redirect after logged in //
    //////////////////////////////
    function my_login_redirect( $redirect_to, $request, $user ) {
        //is there a user to check?
        if ( isset( $user->roles ) && is_array( $user->roles ) ) {
            //check for admins
            if ( in_array( 'administrator', $user->roles ) ) {
                // redirect them to the default place
                return $redirect_to = admin_url();
                
            } elseif(in_array( 'couple', $user->roles )) {
                // return home_url();
                return $redirect_to = site_url('/couple-dashboard');
            }elseif(in_array('business', $user->roles)){
                return $redirect_to = site_url('/listing-dashboard');
            }else{
                return home_url();
            }
        } else {
            return $redirect_to;
        }
    }
     
    add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );



    // add_action('wp_head', 'check_tax');
    function check_tax(){
        $posts = get_posts(array(
                'post_type' => 'listing',
                'numberposts' => -1
            )
        );
        foreach($posts as $a){
            
            echo '<pre>';
            print_r($a->ID);
            echo '</pre>';
            
            foreach(get_the_terms($a->ID, 'listing-capacity') as $b){
                
                echo '<pre>';
                print_r($b->name);
                echo '</pre>';
                
            }
            
        }
        die();
    }


    // add_action('wp_head', 'allListingsTest');
    function allListingsTest(){
        $allListing = get_posts(
                array(
                    'numberposts' => -1,
                    'post_type' => 'listing'
                )
            );
        
        foreach($allListing as $listing){

            $tmpCategory = apply_filters( 'term_getter', $listing->ID, 'listing-license' );
            
            echo '<pre>';
            print_r($tmpCategory);
            echo "<br>";
            print_r($listing->ID);
            echo '</pre>';
            echo "--------------<br>--------------";
            

        }

    }


    // add_action('wp_head', 'whatsinside');
    function whatsinside(){
        
        // $datetime = new DateTime("1655993234"); 
        // $datetime = new DateTime(1655993234); 
        $datetime = date('F j, Y', "1655993234");
		// $formated = $datetime->format('F j, Y');

        
        echo '<pre>';
        print_r($datetime);
        echo '</pre>';
        

        die();
    }






    function listingDescriptionLimiter( $valid, $value, $field, $input_name ) {
        // Bail early if value is already invalid.
        if( $valid !== true ) {
            return $valid;
        }

        global $current_user; 
        wp_get_current_user();
        $subscriptionType = apply_filters('get_subscriptiontype', $current_user->ID);



        if($subscriptionType === 'Basic'){
            if(str_word_count($value) > 50){
                return __('Your subscription limits you to 50 words');
            }
        }

         return $valid;
    }
    
    // Apply to all fields.
    add_filter('acf/validate_value/name=listing_description', 'listingDescriptionLimiter', 10, 4);








    ////////////////////////
    // Add TinyMCE PLugin //
    ////////////////////////
    add_filter('mce_external_plugins', 'my_tinymce_plugins');
    function my_tinymce_plugins() {
        $plugins_array = array(
                            'wordcount' => 'https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.0/plugins/wordcount/plugin.min.js'
                        );
        return $plugins_array;
    }


    remove_action('shutdown', 'wp_ob_end_flush_all', 1);

    function my_acf_init() {
        acf_update_setting('google_api_key', 'AIzaSyBqgNZugZ_Uf2MWXGgxosgUeXfeXfeo8K8');
    }
    add_action('acf/init', 'my_acf_init');




    add_action('wp_head', 'getAllListingsTest');
    function getAllListingsTest(){
        if(isset($_GET['allthelistings'])){
            $allTheListings = get_posts(array(
                'post_type' => 'listing',
                'numberposts' => -1
            ));
            foreach($allTheListings as $theListing){
                $listingOwnerEmail = '';
                $theListingOwner;

                $listingOwnerEmail = get_post_meta($theListing->ID, 'listing_owner_email', true);
                $theListingOwner = get_user_by('email', $listingOwnerEmail);
                $listingExpiryDate = apply_filters('get_subscriptionexpirydate', $theListingOwner->ID);
                $listingType = apply_filters('term_getter', $theListing->ID, 'listing-license');
                $listingLocations = apply_filters('term_getter', $theListing->ID, 'listing-location', 'array');
                $listingCategories = apply_filters('term_getter', $theListing->ID, 'listing-category');
                $listingCapacity = apply_filters('term_getter', $theListing->ID, 'listing-capacity');
                $listingStyles = apply_filters('term_getter', $theListing->ID, 'listing-style', 'array');
                $listingFeatures = apply_filters('term_getter', $theListing->ID, 'listing-features', 'array');
                $listingVenueType = apply_filters('term_getter', $theListing->ID, 'listing-venue-type', 'array');

                update_post_meta($theListing->ID, 'expiration_date', $listingExpiryDate);

                $listingExpiry = get_post_meta($theListing->ID, 'expiration_date', true);


                $isActive = $listingExpiryDate ? 'style="background:pink;"' : '';
                $isActive = $listingType === "" ? 'style="background:pink;"' : 'style="background:#8aef8a;"';

                echo "<pre $isActive>";
                print_r($theListing->post_title);
                echo "<br>";

                
                print_r("Listing Owner Email: " . $listingOwnerEmail);
                echo "<br>";

                print_r("Listing Type: " . $listingType);
                echo "<br>";

                echo "Locations: ";
                if(isset($listingLocations) && $listingLocations !== ""){
                    foreach($listingLocations as $lLoc)
                    print_r($lLoc->name . ", ");
                }
                echo "<br>";
                
                echo "Category for SUPPLIERS ONLY: " . $listingCategories;
                echo "<br>";

                echo "Capacity: " . $listingCapacity;
                echo "<br>";

                echo "Styles: ";
                if(isset($listingStyles) && $listingStyles !== ""){
                    foreach($listingStyles as $lStyle){
                        print_r($lStyle->name . ", ");
                    }
                }
                echo "<br>";

                echo "Features for VENUE ONLY: ";
                if(isset($listingFeatures) && $listingFeatures !== ""){
                    foreach($listingFeatures as $lFeat){
                        print_r($lFeat->name . ", ");
                    }
                }
                echo "<br>";


                echo "Venue Type for VENUE ONLY";
                if(isset($listingVenueType) && $listingVenueType !== ""){
                    foreach($listingVenueType as $lType){
                        print_r($lType->name . ", ");
                    }
                }
                echo "<br>";

                echo "The EXP :";
                print_r($listingExpiry);
                echo "<br>";


                
                
                // print_r($theListingOwner->ID);
                // echo "<br>";
                
                echo "The Expiration Date: ";
                var_dump($listingExpiryDate ? apply_filters('unix_handler', $listingExpiryDate) : "");
                echo "<br>";

                echo "<br>===================================<br>";
                echo '</pre>';
                
            }
            die();
        }
    }


    // add_action('wp_head', 'insertSomeTerms');
    function insertSomeTerms(){
        $someTemrs = ["Sleeping arrangements", "On-site accommodation", "Glamping / Camping", "Long let available", "Food & drink", "Catering included", "Ability to bring my own catering.", "Alcohol licence", "Fine dining", "Corkage charge for own alcohol", "Evening hog roasts / BBQ’s", "Venue features", "Civil ceremony in the same venue", "Exclusive use", "Wedding co-ordinator included", "Pet friendly", "Disabled access", "Landscaped gardens / outdoor space", "Bridal changing facilities", "On-site parking", "Marquee permitted", "Photo opportunities", "All inclusive wedding packages", "Confetti permitted", "Spa on-site", "Sound system available for speeches.", "Dancefloor available"];

        foreach($someTemrs as $sTerm){
            wp_insert_term($sTerm, 'listing-features');
        }
        die();
    }

    // $P$BN5C1o0dzPuLIc8vIoFWiG8BVblmOq1