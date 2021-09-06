<?php
/**
 * Block Name: Sign up form
 *
 */

// create id attribute for specific styling
$id = 'signupform-' . $block['id'];

?>

<div class="sign-up-form-wrap container">

<div class="tab-container row" style="display:flex">
	<a href="#business-signup" id="btn-listing" class="tab-link active" >
		For Businesses
	</a>
	<a href="#couple-signup" id="btn-couple" class="tab-link">
		For Couples
	</a>
</div>

<div id="business-signup" class="tab_content_login  tab-content" >
	<h3>Showcase your Business and Register</h3>
	<p>Ready to join the Welsh wedding planning revolution? Claim your free listing today</p>

	<form method="post" class="registration-form" id="business-register-form" action="<?php echo site_url('wp-login.php?action=register', 'login_post') ?>" class="wp-user-form">
		<div class="username">
			<label for="user_login"><?php _e('Username'); ?>: </label>
			<!-- <input type="text" name="user_login" value="< ?php echo esc_attr(stripslashes($user_login)); ?>" size="20" id="business-user_login" tabindex="101" /> -->
			<input type="text" name="user_login" value="" size="20" id="business-user_login" tabindex="101" required/>
			<?php if(isset($_GET['username_exists'])){
				echo '<p class="input-error">Username already exist.</p>';
			} ?>
		</div>
		<div class="password">
			<label for="user_email"><?php _e('Your Email'); ?>: </label>
			<!-- <input type="text" name="user_email" value="< ?php echo esc_attr(stripslashes($user_email)); ?>" size="25" id="business-user_email" tabindex="102" /> -->
			<input type="text" name="user_email" value="" size="25" id="business-user_email" tabindex="102" required/>
			<?php if(isset($_GET['email_exists'])){
				echo '<p class="input-error">Email already exist.</p>';
			} ?>
			<?php if(isset($_GET['invalid_email'])){
				echo '<p class="input-error">Invalid Email.</p>';
			} ?>
		</div>
		<div class="password">
			<label for="user_password"><?php _e('Your password'); ?>: </label>
			<!-- <input type="password" name="user_password" value="< ?php echo esc_attr(stripslashes($user_password)); ?>" size="25" id="business-user_password" tabindex="102" /> -->
			<input type="password" name="user_password" value="" size="25" id="business-user_password" tabindex="102" required/>
		</div>
		<div class="login_fields">
			<?php do_action('register_form'); ?>
			<div id="register-loader" class="lds-roller" style="display:none;"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
			<input type="submit" name="user-submit" value="<?php _e('Sign up!'); ?>" class="user-submit" tabindex="103" />
			<?php $register = $_GET['register']; if($register == true) { echo '<p>Check your email for the password!</p>'; } ?>
			<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>?register=true" />
			<input type="hidden" name="user-cookie" value="1" />
		</div>
	</form>
	<p>Have an account? <a href="<?=site_url('/log-in')?>">Log In Here</a></p>
</div>


<div id="couple-signup" class="tab_content_login tab-content" style="display:none">
        <h3>Create a Couple account and Plan Your Wedding!</h3>
        <p>Sign up now for the good stuff.</p>
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
                <div id="register-loader" class="lds-roller" style="display:none;"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                <input type="submit" name="user-submit" value="<?php _e('Sign up!'); ?>" class="user-submit" tabindex="103" />
                <?php $register = $_GET['register']; if($register == true) { echo '<p>Check your email for the password!</p>'; } ?>
                <input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>?register=true" />
                <input type="hidden" name="userType" value="couple" />
                <input type="hidden" name="user-cookie" value="1" />
            </div>
        </form>
		<p>Have an account? <a href="<?=site_url('/log-in')?>">Log In Here</a></p>
    </div>
    
</div>


<script>

jQuery(document).ready((e) => {
    jQuery('form').on('submit', (e) => {
        jQuery('#lds-roller').show();
    })
    jQuery('#login-form').on('submit', (e) => {
        jQuery('#login-loader').show();
    })


	jQuery('.tab-link').on('click', function(event){
		event.preventDefault();
		jQuery('.tab-link').removeClass('active');
		jQuery(this).addClass('active');
		jQuery('.tab-content').hide();
		target = jQuery(this).attr('href');
		jQuery(target).show();
		jQuery('#couple-signup').hide();
	})
	

})

</script>