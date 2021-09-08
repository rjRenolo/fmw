<?php


add_action('wp_head', 'see_user_details');
function see_user_details(){
    if(isset($_GET['user_id'])){
        $userId = $_GET['user_id'];
        echo "<br>";
        echo '<pre>';
        print_r(get_user_meta( $userId, 'user_page_id', true));
        echo '</pre>';

        
        echo '<pre>';
        print_r('wedmatch_name1');
        echo "<br>";
        print_r(get_user_meta( $userId, 'wedmatch_name1', true ));
        echo "<br>";
        echo "<br>";
        print_r('-------------------');
        echo "<br>";
        echo '</pre>';

        echo '<pre>';
        print_r('wedmatch_name1status');
        echo "<br>";
        print_r(get_user_meta( $userId, 'wedmatch_name1status', true ));
        echo "<br>";
        echo "<br>";
        print_r('-------------------');
        echo "<br>";
        echo '</pre>';

        echo '<pre>';
        print_r('wedmatch_name2');
        echo "<br>";
        print_r(get_user_meta( $userId, 'wedmatch_name2', true ));
        echo "<br>";
        echo "<br>";
        print_r('-------------------');
        echo "<br>";
        echo '</pre>';

        echo '<pre>';
        print_r('wedmatch_name2status');
        echo "<br>";
        print_r(get_user_meta( $userId, 'wedmatch_name2status', true ));
        echo "<br>";
        echo "<br>";
        print_r('-------------------');
        echo "<br>";
        echo '</pre>';

        echo '<pre>';
        print_r('wedmatch_userdescription');
        echo "<br>";
        print_r(get_user_meta( $userId, 'wedmatch_userdescription', true ));
        echo "<br>";
        echo "<br>";
        print_r('-------------------');
        echo "<br>";
        echo '</pre>';

        echo '<pre>';
        print_r('wedmatch_weddingdate');
        echo "<br>";
        print_r(get_user_meta( $userId, 'wedmatch_weddingdate', true ));
        echo "<br>";
        echo "<br>";
        print_r('-------------------');
        echo "<br>";
        echo '</pre>';

        echo '<pre>';
        print_r('wedmatch_listinglicensetype');
        echo "<br>";
        print_r(get_user_meta( $userId, 'wedmatch_listinglicensetype', true ));
        echo "<br>";
        echo "<br>";
        print_r('-------------------');
        echo "<br>";
        echo '</pre>';

        echo '<pre>';
        print_r('wedmatch_ceremonyguests');
        echo "<br>";
        print_r(get_user_meta( $userId, 'wedmatch_ceremonyguests', true ));
        echo "<br>";
        echo "<br>";
        print_r('-------------------');
        echo "<br>";
        echo '</pre>';

        echo '<pre>';
        print_r('wedmatch_listingvenuetype');
        echo "<br>";
        print_r(get_user_meta( $userId, 'wedmatch_listingvenuetype', true ));
        echo "<br>";
        echo "<br>";
        print_r('-------------------');
        echo "<br>";
        echo '</pre>';

        echo '<pre>';
        print_r('wedmatch_location');
        echo "<br>";
        print_r(get_user_meta( $userId, 'wedmatch_location', true ));
        echo "<br>";
        echo "<br>";
        print_r('-------------------');
        echo "<br>";
        echo '</pre>';

        echo '<pre>';
        print_r('wedmatch_listingaccommodation');
        echo "<br>";
        print_r(get_user_meta( $userId, 'wedmatch_listingaccommodation', true ));
        echo "<br>";
        echo "<br>";
        print_r('-------------------');
        echo "<br>";
        echo '</pre>';

        echo '<pre>';
        print_r('wedmatch_listingFoodDrink');
        echo "<br>";
        print_r(get_user_meta( $userId, 'wedmatch_listingFoodDrink', true ));
        echo "<br>";
        echo "<br>";
        print_r('-------------------');
        echo "<br>";
        echo '</pre>';

        echo '<pre>';
        print_r('wedmatch_listingFeature');
        echo "<br>";
        print_r(get_user_meta( $userId, 'wedmatch_listingFeature', true ));
        echo "<br>";
        echo "<br>";
        print_r('-------------------');
        echo "<br>";
        echo '</pre>';

        echo '<pre>';
        print_r('wedmatch_receptionGuests');
        echo "<br>";
        print_r(get_user_meta( $userId, 'wedmatch_receptionGuests', true ));
        echo "<br>";
        echo "<br>";
        print_r('-------------------');
        echo "<br>";
        echo '</pre>';

        echo '<pre>';
        print_r('wedmatch_listingStyle');
        echo "<br>";
        print_r(get_user_meta( $userId, 'wedmatch_listingStyle', true ));
        echo "<br>";
        echo "<br>";
        print_r('-------------------');
        echo "<br>";
        echo '</pre>';

        echo '<pre>';
        print_r('wedmatch_category');
        echo "<br>";
        print_r(get_user_meta( $userId, 'wedmatch_category', true ));
        echo "<br>";
        echo "<br>";
        print_r('-------------------');
        echo "<br>";
        echo '</pre>';

        
        die();
    }else if(isset($_GET['listingid'])){
        $listingId = $_GET['listingid'];
        $license = apply_filters( 'term_getter', $listingId, 'listing-license' );
        
        
        echo '<pre>';
        print_r($license);
        echo '</pre>';
        die();
    }
}

// add_action('wp_head', 'testget');
function testget(){
    $user = get_user_by( 'email', 'test01@gmail.com');
    
    echo '<pre>';
    print_r($user->roles[0]);
    echo '</pre>';
    die();
}