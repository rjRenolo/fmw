<?php

// add_action('wp_head', 'sometest');
function sometest(){
    require_once( THEME_DIR . '/vendor/autoload.php' );	
    $stripe = new \Stripe\StripeClient(
        // get_option('stripe_secret_key')
        get_field('stripe_api_secret_key', 'options')
    );
    $productList = $stripe->products->all(['limit' => 3]);
    
    foreach($productList as $prod){
        $prices = $stripe->prices->all(['product' => $prod->id]);
        
        foreach($prices as $price){
            echo '<pre>';
            print_r($price);
            echo '</pre>';
        }
        
    }
    die();
}


add_action( 'rest_api_init', function () {
    register_rest_route( 'fmw/v1', '/subscribe-now', array(
        'methods' => ['GET', 'POST'],
        'callback' => 'subscribeNow',
    ) );
} );


function subscribeNow(WP_REST_Request $request){
  require_once( THEME_DIR . '/vendor/autoload.php' );	
  $stripe = new \Stripe\StripeClient(
    // get_option('stripe_secret_key')
    get_field('stripe_api_secret_key', 'options')
  );

  $bodyParams = $request->get_body_params();
  $cardNumber;
  $expMonth;
  $expYear;
  $cvc;
  $email;
  $firstName;
  $lastName;
  $userId;
  $selectedSubscription = $bodyParams['selectedSubscription'];
  $license = $bodyParams['license'];


  foreach($bodyParams['paymentDetails'] as $params){
      switch($params['name']){
        case 'number':
          $cardNumber = $params['value'];
          break;
        case 'expiry':
          $expMonth = explode(" / ", $params['value'])[0];
          $expYear = explode(" / ", $params['value'])[1];
          break;
        case 'cvc':
          $cvc = $params['value'];
          break;
        case 'first-name':
          $firstName = $params['value'];
          break;
        case 'last-name':
          $lastName = $params['value'];
          break;
        case 'email':
          $email = $params['value'];
          break;
        case 'userId':
          $userId = $params['value'];
          break;
        default:
          break;
      }
  }


  $selectedSubscriptionId;
  if($license === "Supplier"){ // Supplier Pricing IDs
    switch($selectedSubscription){
      case "best":
          $selectedSubscriptionId = get_field('supplier_basic_price_id', 'options');
        break;
      case "better":
          $selectedSubscriptionId = get_field('supplier_better_price_id', 'options');
        break;
      default:
        $selectedSubscriptionId = get_field('supplier_best_price_id', 'options');
        break;
    }

  }else{ // Venue Pricing IDs
    switch($selectedSubscription){
      case "best":
          $selectedSubscriptionId = get_field('venue_basic_price_id', 'options');
        break;
      case "better":
          $selectedSubscriptionId = get_field('venue_better_price_id', 'options');
        break;
      default:
        $selectedSubscriptionId = get_field('venue_best_price_id', 'options');
        break;
    }
  }

  // if($selectedSubscription === 'bronze'){
  //   $selectedSubscriptionId = get_field('basic_price_id', 'options');
  // }else if($selectedSubscription === 'silver'){
  //   $selectedSubscriptionId = get_field('penyfan_price_id', 'options');
  // }else if($selectedSubscription === 'gold'){
  //   $selectedSubscriptionId = get_field('snowdon_price_id', 'options');
  // }




  // $productList = $stripe->products->all(['limit' => 3]);
    
  //   foreach($productList as $prod){
  //       $prices = $stripe->prices->all(['product' => $prod->id]);
        
  //       foreach($prices as $price){

  //           $priceID = $price->id;
  //           $interval = $price->recurring->interval;
  //           $intervalCount = $price->recurring->interval_count;

  //           if($selectedSubscription === 'bronze' && $interval === 'month' && $intervalCount === 1){

  //               $selectedSubscriptionId = $priceID;

  //           }else if($selectedSubscription === 'silver' && $interval === 'month' && $intervalCount === 3){

  //               $selectedSubscriptionId = $priceID;

  //           }else if($selectedSubscription === 'gold' && $interval === 'year' && $intervalCount === 1){
              
  //               $selectedSubscriptionId = $priceID;
  //           }
  //       }
  //   }

  try {
    $stripePaymentMethod = $stripe->paymentMethods->create([
      'type' => 'card',
      'card' => [
        'number' => $cardNumber,
        'exp_month' => $expMonth,
        'exp_year' => $expYear,
        'cvc' => $cvc,
      ]
    ]);
  } catch (\Throwable $th) {
    do_action('custom_logger', $th->getError()->message);
    echo json_encode(['error' => true, 'message' => $th->getError()->message]);
    exit();
  }
  
    
    $stripeCustomer = $stripe->customers->create([
      'payment_method' => $stripePaymentMethod->id,
      'invoice_settings' => [
        'default_payment_method' => $stripePaymentMethod->id
      ],
      'email' => $email,
      'name' => $firstName . " " . $lastName,
      'metadata' => ['userId' => $userId]
    
      ]);

    $stripeSubscription = $stripe->subscriptions->create([
      'customer' => $stripeCustomer->id,
      'items' => [
        // ['price' => 'price_1IXnSUCRN4o1Cr35TDkRvsXv'], // 1 year 
        ['price' => $selectedSubscriptionId], // dynamic
      ],
      ]);
    //   do_action('custom_logger', $stripeSubscription);

      // update user meta here
      if($stripeSubscription->status !== 'incomplete'){

        do_action('custom_logger', $stripeSubscription);
        update_user_meta($userId, 'user_subscription_expiry', $stripeSubscription->current_period_end);
        update_user_meta($userId, 'subscription_id', $stripeSubscription->id);
        update_user_meta($userId, 'customer_id', $stripeSubscription->customer);
        update_user_meta($userId, 'customer_default_payment', $stripePaymentMethod->id);
        update_user_meta($userId, 'subscription_status', $stripeSubscription->status);
        if($selectedSubscription === 'basic'){
            update_user_meta($userId, 'subscription_type', 'basic');
        }else if($selectedSubscription === 'better'){
            update_user_meta($userId, 'subscription_type', 'better');
        }else if($selectedSubscription === 'best'){
            update_user_meta($userId, 'subscription_type', 'best');
        }


        $user = get_user_by('id', $userId);

        $defaultmail = $stripeCustomer->email;
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: Find My Wedding <'.get_bloginfo('admin_email').'>' . "\r\n";
        $headers .= "Return-path: <" . get_bloginfo('admin_email') . ">\r\n";
        $htmlmessage = "<h2>Thank you.</h2>";
        $htmlmessage .= "<p>Hello ". $user->user_nicename .",</p><br>";
        $htmlmessage .= "<p>Thank you for subscribing on our service, your subscription will end on ". apply_filters('unix_handler', $stripeSubscription->current_period_end) ."</p>";
        $sendMail = wp_mail($defaultmail, 'Thank you', $htmlmessage, $headers);


        echo json_encode(['status' => true]);
      }else{
        echo json_encode(['status' => false, 'redirect_url' => '/failed-paymet']);
      }


      exit();

}


add_action('wp_ajax_new_test', 'new_test');
add_action('wp_ajax_nopriv_new_test', 'new_test');
function new_test(){
    echo json_encode(['test' => true]);
    exit();
}


/////////////////////////////
// Cancelling Subscription //
////////////////////////////
add_action( 'rest_api_init', function () {
    register_rest_route( 'atw/v1', '/cancel-subscription', array(
        'methods' => ['GET', 'POST'],
        'callback' => 'cancelSubscription',
    ) );
  } );
  
function cancelSubscription(WP_REST_Request $request){
require_once( THEME_DIR . '/vendor/autoload.php' );	
$stripe = new \Stripe\StripeClient(
    // get_option('stripe_secret_key')
    get_field('stripe_api_secret_key', 'options')
);


$bodyParams = $request->get_params();
$subsId = $bodyParams['subscriptionId'];

  try {
    $cancelled = $stripe->subscriptions->cancel(
      $subsId,
      []
    );
  } catch (\Throwable $th) {
    do_action('custom_logger', $th);
  }
  
  echo json_encode(['status' => true]);
  exit();

}  


add_action('wp_ajax_cancelling_subscription', 'cancelling_subscription');
add_action('wp_ajax_nopriv_cancelling_subscription', 'cancelling_subscription');
function cancelling_subscription(){


    echo json_encode(['status' => $_REQUEST]);
    exit();

//   require_once( THEME_DIR . '/vendor/autoload.php' );	
//   $stripe = new \Stripe\StripeClient(
//     'sk_test_51IRcAqCRN4o1Cr35MuhWnRnSt5Ip54fs61DvcllQe97CpKpo5lT4UjTxPZMAKDFDHFIhkWPqcujOyO87ME6F2iVa00tqTT76J0'
//   );

//   try {
//     $cancelled = $stripe->subscriptions->cancel(
//       $_REQUEST['subscriptionId'],
//       []
//     );
//     do_action('custom_logger', $cancelled);
//   } catch (\Throwable $th) {
//     do_action('custom_logger', $th);
//   }
  
//   echo json_encode(['status' => true]);
//   exit();
}


add_action( 'rest_api_init', function () {
  register_rest_route( 'atw/v1', '/update-payment', array(
      'methods' => ['GET', 'POST'],
      'callback' => 'updatePaymentCallback',
  ) );
} );

function updatePaymentCallback(WP_REST_Request $request){
  require_once( THEME_DIR . '/vendor/autoload.php' );	
  $stripe = new \Stripe\StripeClient(
    // get_option('stripe_secret_key')
    get_field('stripe_api_secret_key', 'options')
  );

  $bodyParams = $request->get_body_params();
  $cardNumber;
  $expMonth;
  $expYear;
  $cvc;
  $userId;
  foreach($bodyParams['paymentDetails'] as $params){
      switch($params['name']){
        case 'number':
          $cardNumber = $params['value'];
          break;
        case 'expiry':
          $expMonth = explode(" / ", $params['value'])[0];
          $expYear = explode(" / ", $params['value'])[1];
          break;
        case 'cvc':
          $cvc = $params['value'];
          break;
        case 'userId':
          $userId = $params['value'];
          break;
        default:
          break;
      }
  }



  // get user default payment method id
  $defaultPaymendId = get_user_meta( $userId, 'customer_default_payment' , true );
  $stripeCustomerId = get_user_meta( $userId, 'customer_id', true );
  // detach
  require_once( THEME_DIR . '/vendor/autoload.php' );	
  $stripe = new \Stripe\StripeClient(
    // get_option('stripe_secret_key')
    get_field('stripe_api_secret_key', 'options')
  );


  try {
    $detached = $stripe->paymentMethods->detach(
      $defaultPaymendId,
      []
    );
  } catch (\Throwable $th) {
    echo json_encode(['error' => true, 'message' => $th->getError()->message]);
    exit();
  }







  try {
    $stripePaymentMethod = $stripe->paymentMethods->create([
      'type' => 'card',
      'card' => [
        'number' => $cardNumber,
        'exp_month' => $expMonth,
        'exp_year' => $expYear,
        'cvc' => $cvc,
      ]
    ]);


    $stripe->paymentMethods->attach(
      $stripePaymentMethod->id,
      ['customer' => $stripeCustomerId]
    );


    $stripe->customers->update(
      $stripeCustomerId,
      
      ['invoice_settings' => [
          'default_payment_method' => $stripePaymentMethod->id
        ]
      ]
    );


    update_user_meta($userId, 'customer_default_payment', $stripePaymentMethod->id);

    echo json_encode(['status' => true]);

  } catch (\Throwable $th) {
    // do_action('custom_logger', $th->getError()->message);
    echo json_encode(['error' => true, 'message' => $th->getError()->message]);
    exit();
  }
  
    
    


  exit();

}
