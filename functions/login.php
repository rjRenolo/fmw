<?php


//Check user subscription date has not expired
function atw_check_user_subscription_date() {
    
	//If user subscription has expired then do not let them edit their page


	//If the user subscription has not expired they can continue to login as normal


}
add_action('wp_login', 'atw_check_user_subscription_date');