<?php
/**
 * Block Name: Couples sign up form
 *
 */

// create id attribute for specific styling
$id = 'signupform-' . $block['id'];

?>

<?php if(isset($_GET['username_exists']) || isset($_GET['email_exists']) || isset($_GET['invalid_email']) || isset($_GET['username_exists']) || isset($_GET['register'])) { ?>

    <script>
        jQuery(document).ready(function() {

                jQuery('html, body').animate({
                    scrollTop: jQuery('#couple-signup').offset().top 
                }, 1000);

        })
    </script>

<?php } ?>

<div class="sign-up-form-wrap container">



<div id="couple-signup" class="tab_content_login tab-content" >

    <?php $register = $_GET['register']; if($register == true) { echo '<div class="success message"><a href="' . get_the_permalink(get_field('login_page','option')). '">Login to your account &raquo;</a></div>'; } ?>

        <form class="registration-form" id="register-form" method="post" action="<?php echo site_url('wp-login.php?action=register', 'login_post') ?>" class="wp-user-form">
            <div class="username">
                <label for="user_login"><?php _e('Username'); ?>: </label>
                <input type="text" name="user_login" value="<?php echo esc_attr(stripslashes($user_login)); ?>" size="20" id="user_login" tabindex="101" required/>
                <?php if(isset($_GET['username_exists'])){
                    echo '<p class="input-error">Username already exist.</p>';
                } ?>
            </div>
            <div class="password">
                <label for="user_email"><?php _e('Your Email'); ?>: </label>
                <input type="text" name="user_email" value="<?php echo esc_attr(stripslashes($user_email)); ?>" size="25" id="user_email" tabindex="102" required/>
                <?php if(isset($_GET['email_exists'])){
                    echo '<p class="input-error">Email already exist.</p>';
                } ?>
            </div>
            <div class="password">
                <label for="user_password"><?php _e('Your password'); ?>: </label>
                <input type="password" name="user_password" value="" size="25" id="user_password" tabindex="102" required/>
            </div>
            <div class="login_fields">
                <?php do_action('register_form_couples'); ?>
                <input type="hidden" name="userType" value="couples">
                
                <div id="register-loader" class="lds-roller" style="display:none;">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                
                <input type="submit" name="user-submit" value="<?php _e('Sign up!'); ?>" class="user-submit" tabindex="103" />

                <?php $register = $_GET['register']; if($register == true) { echo '<p>Check your email for the password!</p>'; } ?>

                <input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>?register=true" />
                <input type="hidden" name="userType" value="couple" />
                <input type="hidden" name="user-cookie" value="1" />
            </div>
        </form>
		<p>Have an account? <a href="<?php echo get_the_permalink(get_field('login_page','option'));?>">Log In Here</a></p>
    </div>
    
</div>

<div class="overlay">
    <div id="register-loader" class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
</div>
<script>

jQuery(document).ready((e) => {
    jQuery('form').on('submit', (e) => {
        jQuery('.overlay').css('display','flex');
    })
    

})

</script>