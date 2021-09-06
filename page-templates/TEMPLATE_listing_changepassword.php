<?php 
/*
Template Name: Listing Change Password
*/

    if(!is_user_logged_in()) :

        wp_redirect(get_bloginfo('url'));
        exit;

        if(!current_user_can('administrator') || !current_user_can('business') || !current_user_can('couple')) :
             wp_redirect(get_bloginfo('url'));
            exit;
        endif;
    endif; ?>
<?php Embers_Utilities::get_template_parts( array( 'parts/html-header', 'parts/header' ) ); ?>
<?php
  global $current_user; 
  wp_get_current_user();
  $userId = $current_user->ID;
?>


<div class="fullwidth-container">
    <div class="container dashboard-container row">
        <div class="g_grid_3">
            <?php include THEME_DIR . '/parts/dashboard-navigation.php'; ?>
        </div>
        <div class="g_grid_9">
            <h1>Change Password</h1>
            <?php echo do_shortcode( '[change_password]' ) ?>
        </div>
    </div>
</div>


<?php Embers_Utilities::get_template_parts( array( 'parts/footer','parts/html-footer' ) ); ?>