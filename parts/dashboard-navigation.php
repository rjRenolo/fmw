<nav class="dashboard-navigation">

    <?php $current_user = wp_get_current_user();
    $user_page_id = get_user_meta( $current_user->ID, 'user_page_id' , true );?>
    <?php $expiryDate = apply_filters('get_subscriptionexpirydate', $current_user->ID) ?>
    <?php 
        $isExpired = intval($expiryDate) - time();
    ?>


    <div class="listing-avatar">
        <p><?php echo $current_user->user_nicename;?></p>
    </div>

    <div class="subscriptionStatus">
        <p>Status: <strong><?php echo apply_filters( 'get_subscriptionstatus', $current_user->ID );?></strong><br>
        Subscription: <strong><?php echo apply_filters('get_subscriptiontype', $current_user->ID);?></strong></p>
        <?php if($expiryDate): ?>
        <p>Subscription Expiry: <strong><?=apply_filters('unix_handler', $expiryDate)?></strong></p>
        <?php endif; ?>
    </div>
   
    <ul>
        <?php wp_nav_menu(array('theme_location'=>'listingdashboard'))?>
        <?php if(is_user_logged_in()) { ?>

            <?php if($isExpired < 0): ?>
                <li class="site-icon"><a href="/subscribe-again">Subscribe</a></li>
            <?php endif; ?>
            <li class="site-icon"><a href="<?php echo get_the_permalink($user_page_id) ?>"  target="_blank">View My Live Listing</a></li>
            <li class="logout-icon"><a href="<?php echo wp_logout_url( home_url() ); ?>">Logout</a></li>
            
        <?php } ?>
    </ul>
</nav>