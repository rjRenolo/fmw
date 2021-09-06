<?php

add_action( 'rest_api_init', function () {
    register_rest_route( 'fmw/v1', '/stripe-listener', array(
        'methods' => ['GET', 'POST'],
        'callback' => 'stripeListener',
    ) );
} );

function stripeListener(WP_REST_Request $request){
    $jsonParams = $request->get_json_params();


    do_action('custom_logger', $jsonParams);
    
    if($jsonParams['type'] === 'customer.subscription.deleted'){

        require_once( THEME_DIR . '/vendor/autoload.php' );	
        $stripe = new \Stripe\StripeClient(
            get_field('stripe_api_secret_key', 'options')
        );
        
        
        $stripeCustomerId = $jsonParams['data']['object']['customer'];

        $stripeSubscriptionId = $jsonParams['data']['object']['id'];

        // get customerr object
        $customerObj = $stripe->customers->retrieve($stripeCustomerId,[]);
        $wp_user_id = $customerObj->metadata->userId;

        
        update_user_meta($wp_user_id, 'subscription_status', $jsonParams['data']['object']['status']);
        
        $expiryDate = get_user_meta( $wp_user_id, 'user_subscription_expiry' , true );
        
        $defaultmail = $customerObj->email;
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: All Things Wales <'.get_bloginfo('admin_email').'>' . "\r\n";
        $headers .= "Return-path: <" . get_bloginfo('admin_email') . ">\r\n";
        $htmlmessage = "<h2>Subscription Canceled.</h2>";
        $htmlmessage .= "<p>Sorry to see you go, your subscription will end on ". apply_filters('unix_handler', $expiryDate) ."</p>";
        $sendMail = wp_mail($defaultmail, 'Subscrition Canceled', $htmlmessage, $headers);

        
    }else if($jsonParams['payment_intent.succeeded'] === 'invoice.paid'){
        if($jsonParams['data']['object']['billing_reason'] == 'subscription_cycle'){


            require_once( THEME_DIR . '/vendor/autoload.php' );	
            $stripe = new \Stripe\StripeClient(
                get_field('stripe_api_secret_key', 'options')
            );


            // get the customer id
            $renew_stripeCustomerId = $jsonParams['data']['object']['customer'];
            // get the customer metadata which contains the wordpress user id
            $renew_StripeCustomer = $stripe->customers->retrieve(
                $renew_stripeCustomerId,
                []
              );
            $renew_wp_id = $renew_StripeCustomer->metadata->userId;


            // get the subscription id
            $renew_stripeSubscriptionId = $jsonParams['data']['object']['subscription'];

            // get the latest subscription details
            $renew_StripeSubscription = $stripe->subscriptions->retrieve(
                $renew_stripeSubscriptionId,
                []
              );

            $current_period_end = $renew_StripeSubscription->current_period_end;

            // update the user subscription accordingly
            update_user_meta($renew_wp_id, 'user_subscription_expiry', $current_period_end);
        }
    }else if($jsonParams['payment_intent.succeeded'] === 'invoice.payment_failed'){
        if($jsonParams['data']['object']['billing_reason'] == 'subscription_cycle'){


            require_once( THEME_DIR . '/vendor/autoload.php' );	
            $stripe = new \Stripe\StripeClient(
                get_field('stripe_api_secret_key', 'options')
            );


            // get the customer id
            $failed_renew_stripeCustomerId = $jsonParams['data']['object']['customer'];
            // get the customer metadata which contains the wordpress user id
            $failed_renew_StripeCustomer = $stripe->customers->retrieve(
                $failed_renew_stripeCustomerId,
                []
              );
            $failed_renew_wp_id = $failed_renew_StripeCustomer->metadata->userId;


            // get the subscription id
            $failed_renew_stripeSubscriptionId = $jsonParams['data']['object']['subscription'];

            // get the latest subscription details
            $failed_renew_StripeSubscription = $stripe->subscriptions->retrieve(
                $failed_renew_stripeSubscriptionId,
                []
              );

            $current_period_end = $failed_renew_StripeSubscription->current_period_end;

            // update the user subscription accordingly
            update_user_meta($failed_renew_wp_id, 'user_subscription_expiry', $current_period_end);
            update_user_meta($failed_renew_wp_id, 'subscription_status', $failed_renew_StripeSubscription->status);
        }
    }

    // test
    echo json_encode(['status' => true]);
    exit();
}