<div class="dashboard-navigation">

    <?php $current_user = wp_get_current_user();?>

    <div class="couples-avatar">
    <p><?php echo $current_user->user_nicename;?></p>
        <?php
        acf_form(array(
            'post_id'   => $userPageId,
            'post_title'    => false,
            'fields' => array('profile_image'),
            'submit_value'  => 'Update Profile Picture'
        ));
        ?>

    </div>

    <ul>
        <?php wp_nav_menu(array('theme_location'=>'coupledashboard'))?>
        <li class="wedmatch-icon"><a href="<?php echo get_bloginfo('url');?>/wedding/<?php echo $current_user->display_name;?>" target="_blank">
           My Personal Page</a>
        </li>
        <?php
            $wedmatchVenue = get_the_permalink(get_field('venue_directory_page','option'));
            $wedmatchSupplier = get_the_permalink(get_field('supplier_directory_page','option'));

            $county = get_user_meta( $current_user->ID, 'wedmatch_location', true );
            if($county && $county != ""){
                $urlencoded = urlencode($county);
                $wedmatchVenue .= "?county%5B%5D=$urlencoded";
                $wedmatchSupplier .= "?county%5B%5D=$urlencoded";
            }
            $listing_capacity = get_user_meta( $current_user->ID, 'wedmatch_ceremonyguests', true );
            if($listing_capacity && $listing_capacity != ""){
                $urlencoded = urlencode($listing_capacity  );
                $wedmatchVenue .= "&accommodation%5B%5D=$urlencoded";
                $wedmatchSupplier .= "&accommodation%5B%5D=$urlencoded";
            }
            $listing_venue_type = get_user_meta( $current_user->ID, 'wedmatch_listingvenuetype', true );
            if($listing_venue_type && $listing_venue_type != ""){
                $urlencoded = urlencode($listing_venue_type);
                $wedmatchVenue .= "&venue_type%5B%5D=$urlencoded";
            }
            $listing_venue_type = get_user_meta( $current_user->ID, 'wedmatch_listingFeature', true );
            if($listing_venue_type && is_array($listing_venue_type) && count($listing_venue_type) > 0){
                foreach($listing_venue_type as $item){
                    $urlencoded = urlencode($item  );
                    $wedmatchVenue .= "&venue_features%5B%5D=$urlencoded";
                }
            }
            $listing_style = get_user_meta($current_user->ID, 'wedmatch_listingStyle', true);
            if($listing_style && $listing_style != ""){
                $urlencoded = urlencode($listing_style );
                $wedmatchVenue .= "&style%5B%5D=$urlencoded";
                $wedmatchSupplier .= "&style%5B%5D=$urlencoded";
            }
            $categs = get_user_meta($current_user->ID, 'wedmatch_category', true);
            if($categs && is_array($categs) && count($categs) > 0){
                foreach($categs as $categ){
                    $urlencoded = urlencode($categ);
                    $wedmatchSupplier .= "&venue_category%5B%5D=$urlencoded";
                }
            }

        ?>
        <li class="wedmatch-icon"><a href="<?=$wedmatchVenue?>">
            WEDMATCH<sup>TM</sup> Venues</a>
        </li>
        <li class="wedmatch-icon"><a href="<?=$wedmatchSupplier?>">
            WEDMATCH<sup>TM</sup> Suppliers</a>
        </li>

        <li class="logout-icon"><a href="<?php echo wp_logout_url( home_url() ); ?>" target="_blank">Wedding Fayre FB Group</a></li>
        <?php if(is_user_logged_in()) { ?>
            <li class="logout-icon"><a href="<?php echo wp_logout_url( home_url() ); ?>">Logout</a></li>
        <?php } ?>

    </ul>
</div>
