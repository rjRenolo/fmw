<header class="header">
	
		<div class="fullwidth-container header-row">

			<a href="<?php bloginfo('url');?>" class="mainLogo">Find My Wedding</a>

			<nav class="mainNav ">
				<?php wp_nav_menu(array('theme_location'=>'primary'));?>

				<div class="authNav-mob">
					<a href="<?php echo get_the_permalink(get_field('couples_join_now_page','option'));?>" class="head-join">Join Now</a>

					<?php
				        global $current_user; 
				        wp_get_current_user();
				        $userPageId = $current_user->user_page_id;
				        $user_page_id = get_user_meta( $current_user->ID, 'user_page_id' , true );
				    ?>
				    <?php if(is_user_logged_in()) { 
				    	if(current_user_can('couple')) { ?>

							<a href="<?php echo get_the_permalink(get_field('couples_dashboard','option'));?>" class="head-login">
								<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
									 viewBox="0 0 23.89 25.38" style="enable-background:new 0 0 23.89 25.38;" xml:space="preserve">
								<style type="text/css">
									.st0{fill:#010202;}
								</style>
								<path id="lock" class="st0" d="M4.88,12.88h14c0.55,0,1,0.45,1,1v7c0,0.55-0.45,1-1,1h-14c-0.55,0-1-0.45-1-1v-7
									C3.88,13.33,4.33,12.88,4.88,12.88z M17.88,10.88v-3c0-3.31-2.69-6-6-6s-6,2.69-6,6v3h-1c-1.66,0-3,1.34-3,3v7c0,1.66,1.34,3,3,3h14
									c1.66,0,3-1.34,3-3v-7c0-1.66-1.34-3-3-3H17.88z M7.88,10.88v-3c0-2.21,1.79-4,4-4s4,1.79,4,4v3H7.88z"/>
								</svg>
								Dashboard
							</a>

						<?php } else { ?>

							<a href="<?php echo get_the_permalink(get_field('listing_dashboard','option'));?>" class="head-login">
								<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
									 viewBox="0 0 23.89 25.38" style="enable-background:new 0 0 23.89 25.38;" xml:space="preserve">
								<style type="text/css">
									.st0{fill:#010202;}
								</style>
								<path id="lock" class="st0" d="M4.88,12.88h14c0.55,0,1,0.45,1,1v7c0,0.55-0.45,1-1,1h-14c-0.55,0-1-0.45-1-1v-7
									C3.88,13.33,4.33,12.88,4.88,12.88z M17.88,10.88v-3c0-3.31-2.69-6-6-6s-6,2.69-6,6v3h-1c-1.66,0-3,1.34-3,3v7c0,1.66,1.34,3,3,3h14
									c1.66,0,3-1.34,3-3v-7c0-1.66-1.34-3-3-3H17.88z M7.88,10.88v-3c0-2.21,1.79-4,4-4s4,1.79,4,4v3H7.88z"/>
								</svg>
								Dashboard
							</a>

						<?php } ?>

					<?php } else { ?>

						<a href="<?php echo get_the_permalink(get_field('login_page','option'));?>" class="head-login">
							<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
								 viewBox="0 0 23.89 25.38" style="enable-background:new 0 0 23.89 25.38;" xml:space="preserve">
							<style type="text/css">
								.st0{fill:#010202;}
							</style>
							<path id="lock" class="st0" d="M4.88,12.88h14c0.55,0,1,0.45,1,1v7c0,0.55-0.45,1-1,1h-14c-0.55,0-1-0.45-1-1v-7
								C3.88,13.33,4.33,12.88,4.88,12.88z M17.88,10.88v-3c0-3.31-2.69-6-6-6s-6,2.69-6,6v3h-1c-1.66,0-3,1.34-3,3v7c0,1.66,1.34,3,3,3h14
								c1.66,0,3-1.34,3-3v-7c0-1.66-1.34-3-3-3H17.88z M7.88,10.88v-3c0-2.21,1.79-4,4-4s4,1.79,4,4v3H7.88z"/>
							</svg>
							Log in
						</a>

					<?php } ?>

				</div>

				<a href="#" class="closeMenu">
					<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
					<title>clear</title>
					<path d="M18.984 6.422l-5.578 5.578 5.578 5.578-1.406 1.406-5.578-5.578-5.578 5.578-1.406-1.406 5.578-5.578-5.578-5.578 1.406-1.406 5.578 5.578 5.578-5.578z"></path>
					</svg>
				</a>
			</nav>

			<div class="authNav <?php echo(is_user_logged_in() ? '' : 'notLoggedIn');?>">

				<?php if(is_user_logged_in()) { 
				    	if(current_user_can('couple')) { ?>

				    		<a href="<?php echo get_the_permalink(get_field('couples_dashboard','option'));?>" class="head-login">
								<?php if(get_field('profile_image',$userPageId) == "") { ?>
									<img src="<?php echo get_bloginfo('template_directory');?>/images/global/user-profile.jpg" alt="" />
								<?php } else { ?>
									<img src="<?php echo acf_image_output_url(get_field('profile_image',$userPageId), 'thumbnail');?>" alt="" />
								<?php } ?>
							</a>

				    	<?php } else { ?>

				    		<a href="<?php echo get_the_permalink(get_field('listing_dashboard','option'));?>" class="head-login">
								<?php if(get_field('profile_image',$userPageId) == "") { ?>
									<img src="<?php echo get_bloginfo('template_directory');?>/images/global/user-profile.jpg" alt="" />
								<?php } else { ?>
									<img src="<?php echo acf_image_output_url(get_field('profile_image',$userPageId), 'thumbnail');?>" alt="" />
								<?php } ?>
							</a>

				    	<?php } ?>

				<?php } else { ?>
					<a href="<?php echo get_the_permalink(get_field('couples_join_now_page','option'));?>" class="head-join">For Couples</a>
					<a href="<?php echo get_the_permalink(get_field('business_join_now_page','option'));?>" class="head-join">For Business</a>

					<a href="<?php echo get_the_permalink(get_field('login_page','option'));?>" class="head-login">
						<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
								viewBox="0 0 23.89 25.38" style="enable-background:new 0 0 23.89 25.38;" xml:space="preserve">
						<style type="text/css">
							.st0{fill:#010202;}
						</style>
						<path id="lock" class="st0" d="M4.88,12.88h14c0.55,0,1,0.45,1,1v7c0,0.55-0.45,1-1,1h-14c-0.55,0-1-0.45-1-1v-7
									C3.88,13.33,4.33,12.88,4.88,12.88z M17.88,10.88v-3c0-3.31-2.69-6-6-6s-6,2.69-6,6v3h-1c-1.66,0-3,1.34-3,3v7c0,1.66,1.34,3,3,3h14
									c1.66,0,3-1.34,3-3v-7c0-1.66-1.34-3-3-3H17.88z M7.88,10.88v-3c0-2.21,1.79-4,4-4s4,1.79,4,4v3H7.88z"/>
						</svg>
						Log in
					</a>
				<?php } ?>

			</div>

			<a href="#" class="menuToggle">
				<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="28" viewBox="0 0 24 28">
					<title>bars</title>
					<path d="M24 21v2c0 0.547-0.453 1-1 1h-22c-0.547 0-1-0.453-1-1v-2c0-0.547 0.453-1 1-1h22c0.547 0 1 0.453 1 1zM24 13v2c0 0.547-0.453 1-1 1h-22c-0.547 0-1-0.453-1-1v-2c0-0.547 0.453-1 1-1h22c0.547 0 1 0.453 1 1zM24 5v2c0 0.547-0.453 1-1 1h-22c-0.547 0-1-0.453-1-1v-2c0-0.547 0.453-1 1-1h22c0.547 0 1 0.453 1 1z"></path>
				</svg>
			</a>


		</div>

</header>

