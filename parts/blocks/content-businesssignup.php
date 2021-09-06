<?php
/**
 * Block Name: Business sign up form
 *
 */

// create id attribute for specific styling
$id = 'signupform-' . $block['id'];

?>

<div class="sign-up-form-wrap">

<?php if(isset($_GET['username_exists']) || isset($_GET['email_exists']) || isset($_GET['invalid_email']) || isset($_GET['username_exists']) || isset($_GET['register'])) { ?>

	<script>
		jQuery(document).ready(function() {

			   	jQuery('html, body').animate({
			        scrollTop: jQuery('#business-signup').offset().top 
			    }, 1000);

		})
	</script>

<?php } ?>

<div id="business-signup" class="tab_content_login  tab-content" >

	<?php $register = $_GET['register']; if($register == true) { echo '<div class="success message"><a href="' . get_the_permalink(get_field('login_page','option')). '">Login to your account &raquo;</a></div>'; } ?>

	<form method="post" class="registration-form" id="business-register-form" action="<?php echo site_url('wp-login.php?action=register', 'login_post') ?>" class="wp-user-form">
		<div class="username">
			<label for="user_login"><?php _e('Username'); ?>: </label>

			<input type="text" name="user_login" value="" size="20" id="business-user_login" tabindex="101" required/>

			<?php if(isset($_GET['username_exists'])){
				echo '<p class="input-error">Username already exist.</p>';
			} ?>

		</div>
		<div class="password">
			<label for="user_email"><?php _e('Your Email'); ?>: </label>
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
			<input type="password" name="user_password" value="" size="25" id="business-user_password" tabindex="102" required/>
		</div>
		<div class="login_fields">
			<?php do_action('register_form'); ?>

			<p>What is your business type?</p>
			<div class="input-group" style="display:flex;">
				<select name="licenseType">
					<option value="Supplier">Supplier</option>
					<option value="Venue">Venue</option>
				</select>
			</div>

			<input type="submit" name="user-submit" value="<?php _e('Sign up!'); ?>" class="user-submit" tabindex="103" />

			<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>?register=true" />
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

	// jQuery('input[name=license-type]').click(function(){
	// jQuery('input:checkbox').click(function(){
	// 	console.log(jQuery(this))
	// 	var group = "input:checkbox[name='"+jQuery(this).attr("name")+"']";
	// 	console.log(jQuery(group))
	// 	jQuery(group).attr("checked",false);
    // 	jQuery(this).attr("checked",true);
	// })
    

})

</script>
