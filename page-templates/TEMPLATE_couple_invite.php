<?php 
/*
Template Name: Couple Invite
*/
?>
<?php Embers_Utilities::get_template_parts( array( 'parts/html-header', 'parts/header' ) ); ?>

<div class="container">

<?php
    global $current_user; 
    wp_get_current_user();
    $userPageId = $current_user->user_page_id;
    
?>
<?php if(is_user_logged_in()){ ?>
    <?php if(current_user_can( 'couple' ) || current_user_can( 'administrator' )){  ?>
        <?php include THEME_DIR . '/parts/couple-dashboard-navigation.php'; ?>
            

        <!-- content here -->
        <h3>Invite Family and Friends</h3>

        
    <?php }else{
        echo "You don't have permission to access this page.";
    }?>

<?php }else{
    include THEME_DIR . '/parts/couple-registration-form.php'; 
} ?>

</div>

<?php Embers_Utilities::get_template_parts( array( 'parts/footer','parts/html-footer' ) ); ?>