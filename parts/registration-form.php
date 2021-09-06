
<div id="login-register-password">

	<?php global $user_ID, $user_identity; if (!$user_ID) { ?>


	<div class="tab_container_login">
		<div id="tab1_login" class="tab_content_login">

			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			<?php the_content(); ?>
			<?php endwhile; ?>

			<form id="login-form" method="post" action="<?php bloginfo('url') ?>/wp-login.php" class="wp-user-form">
                <?php if(isset($_GET['login'])){
                    if($_GET['login'] === 'failed'){
                        echo '<p class="input-error">Invalid credentails.</p>';
                    }
                } ?>
				<div class="username">
					<label for="user_login"><?php _e('Username'); ?>: </label>
					<input type="text" name="log" value="<?php echo esc_attr(stripslashes($user_login)); ?>" size="20" id="user_login" tabindex="11" />
				</div>
				<div class="password">
					<label for="user_pass"><?php _e('Password'); ?>: </label>
					<input type="password" name="pwd" value="" size="20" id="user_pass" tabindex="12" />
				</div>
				<div class="login_fields">
					<div class="rememberme">
						<label for="rememberme">
							<input type="checkbox" name="rememberme" value="forever" checked="checked" id="rememberme" tabindex="13" /> Remember me
						</label>
					</div>
					<?php do_action('login_form'); ?>
                    <div id="login-loader" class="lds-roller" style="display:none;"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
					<input type="submit" name="user-submit" value="<?php _e('Login'); ?>" tabindex="14" class="user-submit" />
					<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
					<input type="hidden" name="user-cookie" value="1" />
				</div>
			</form>

			<p><small>Forgotten your password? <a href="#tab2_login" class="tabSwitch">Reset password</a></small></p>
		</div>
		
		<div id="tab2_login" class="tab_content_login forgot_password_container" >
			<h1>Forgotten Password</h1>
			<p>Enter your username or email to reset your password.</p>
			<form method="post" action="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post') ?>" class="wp-user-form">
				<div class="username">
					<label for="user_login" class="hide"><?php _e('Username or Email'); ?>: </label>
					<input type="text" name="user_login" value="" size="20" id="user_login" tabindex="1001" />
				</div>
				<div class="login_fields">
					<?php do_action('login_form', 'resetpass'); ?>
					<input type="submit" name="user-submit" value="<?php _e('Reset my password'); ?>" class="user-submit" tabindex="1002" />
					<?php $reset = $_GET['reset']; if($reset == true) { echo '<p>A message will be sent to your email address.</p>'; } ?>
					<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>?reset=true" />
					<input type="hidden" name="user-cookie" value="1" />
				</div>
			</form>
			<p><small><a href="#tab1_login" class="tabSwitch">Login to your account</a></small></p>
		</div>
	</div>

	<?php } else { // is logged in ?>

		<div class="sidebox">
			<h3>Welcome, <?php echo $user_identity; ?></h3>
			<div class="usericon">
				<?php global $userdata; echo get_avatar($userdata->ID, 60); ?>

			</div>
			<div class="userinfo">
				<p>You're logged in as <strong><?php echo $user_identity; ?></strong></p>
				<p>
					<a href="<?php echo wp_logout_url('index.php'); ?>">Log out</a> | 
					<?php if (current_user_can('manage_options')) { 
						echo '<a href="' . admin_url() . '">' . __('Admin') . '</a>'; } else { 
						echo '<a href="' . admin_url() . 'profile.php">' . __('Profile') . '</a>'; } ?>

				</p>
			</div>
		</div>

	<?php } ?>

</div>
<script>

jQuery(document).ready((e) => {
    jQuery('.tabSwitch').click(function() {
    	jQuery('.tab_content_login').hide();
    	target = jQuery(this).attr('href');
    	jQuery(target).show();
    })
})

</script>
