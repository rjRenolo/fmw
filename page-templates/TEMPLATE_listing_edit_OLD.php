<?php 
/*
Template Name: Listing Editing Form
*/
acf_form_head();
?>
<?php Embers_Utilities::get_template_parts( array( 'parts/html-header', 'parts/header' ) ); ?>

<div class="container row dashboard-container">

	<?php 
	if(is_user_logged_in()) { 

		if(current_user_can('administrator') || current_user_can('business')) { 
			global $current_user; 
			wp_get_current_user();
			
		 
			if ( $current_user ) {
		    	$user_page_id = get_user_meta( $current_user->ID, 'user_page_id' , true );
		    	$user_subscription_expiry = get_user_meta( $current_user->ID, 'user_subscription_expiry' , true );
		    	$subscription_id = get_user_meta( $current_user->ID, 'subscription_id' , true );
		    	$subscription_status = get_user_meta( $current_user->ID, 'subscription_status' , true );

		    		
				
		    	//Check if user subscription has expired
		    	// If it has expired $user_subscription_has_expired = true;
		    	$user_subscription_has_expired = false;
		     
		    	if ( ! empty( $user_page_id ) && $user_subscription_has_expired == false) { ?>
				<div class="g_grid_3">
					<?php include THEME_DIR . '/parts/dashboard-navigation.php'; ?>
				</div>

		    		<?php //add ACF form to allow the editing of the fields of the post with id = $user_page_id ?>
				<div class="g_grid_9">

					<img src="<?php echo get_bloginfo('template_directory');?>/images/global/messages.png" alt="To do" class="sectionIcon"/>
					<h2>Edit Listing</h2>

					<?php

						if(!$user_subscription_expiry){
							echo "<p>Please subscribe to edit/view you listing.</p>";
							echo "<a class='internal-button' href='" . get_the_permalink(get_field('listing_dashboard','option')) . "'>Subscribe Now.</a>";
						
						}else{


							$new_post= array(
							'post_id' => $user_page_id, 
							'form' => true,
							'html_before_fields' => '',
							'html_after_fields' => '',
							'submit_value' => 'Update Listing',
							'updated_message' => 'Saved!'
							);
							acf_form( $new_post);
							?>
							

							<script>
								jQuery(document).ready(() => {
									jQuery('#cancelSub').on('click', (e) => {
										// e.preventDefault();
										// jQuery('#cancelSubscriptionLoader').show();
										// jQuery.ajax({
										// 	url: atw_ajax.ajaxurl,
										// 	method: 'POST',
										// 	data: {action: 'cancelling_subscription', subscriptionId: '<?=$subscription_id?>'},
										// 	success: function(res){
										// 		// console.log(res)
										// 		// window.location.reload(true);
										// 		setTimeout(function(){ window.location.reload(true); }, 5000)
										// 	}
										// })
										e.preventDefault();
										jQuery('#cancelSubscriptionLoader').show();
										jQuery.ajax({
											url: '<?=get_site_url()?>/wp-json/atw/v1/cancel-subscription',
											method: 'POST',
											// data: {action: 'cancelling_subscription', subscriptionId: '< ?=$subscription_id?>'},
											data: {subscriptionId: '<?=$subscription_id?>'},
											success: function(res){
												console.log(res)
												// window.location.reload(true);
												setTimeout(function(){ window.location.reload(true); }, 5000)
											}
										})
									})
								})
							</script>

							<?php

							if($subscription_status !== 'canceled'){ ?>
								<div class="cancelSubscription-wrapper">
									<h4>Cancel Subscription</h4>
									<p>After cancelling your subscription you will not be charged further payments but your any remaining time on your account will be honoured. No refunds are given.</p>
									<button id='cancelSub' class='acf-button button button-primary button-large cancelSubscriptionButton'>Cancel Subscription</button>
									<p id='cancelSubscriptionLoader' style='display:none;'>Processing, Please wait... </p>
								</div>
							<?php }
						}
				echo '</div>';	
						
		    	} else {

					echo '<p>No page associated with this account</p>';

				}

			}

		} else {

			echo '<p>You do not have permission to access this page</p>';

		}

	} else {
		include THEME_DIR . '/parts/registration-form.php';

	}
	?>

</div>


<?php Embers_Utilities::get_template_parts( array( 'parts/footer','parts/html-footer' ) ); ?>