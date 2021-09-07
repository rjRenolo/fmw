<?php 
/*
Template Name: Listing Editing Form
*/
acf_form_head();
?>
<?php Embers_Utilities::get_template_parts( array( 'parts/html-header', 'parts/header' ) ); ?>

<div class="row dashboard-container">

	<?php 
	if(is_user_logged_in()) { 
		

		if(current_user_can('administrator') || current_user_can('business')) { 
			global $current_user; 
			get_currentuserinfo();
			
		 
			if ( $current_user ) {
		    	$user_page_id = get_user_meta( $current_user->ID, 'user_page_id' , true );
		    	$user_subscription_expiry = get_user_meta( $current_user->ID, 'user_subscription_expiry' , true );
		    	$subscription_id = get_user_meta( $current_user->ID, 'subscription_id' , true );
		    	$subscription_status = get_user_meta( $current_user->ID, 'subscription_status' , true );
				$subscription_type = apply_filters( 'get_subscriptiontype', $current_user->ID );
				if(isset($_GET['plaindd'])){
					echo "atr";
					$fieldsForPenyfan = array(
						'address',
						'town',
						'county',
						'postcode',
						'phone',
						'email',
						'listing_description',
						'image_gallery',
						'video_urls',
						'website_url',
						'instagram',
						'facebook',
						'twitter',
						'reviews',
						'map_location'
					);
					$new_post= array(
					'post_id' => $user_page_id, 
					'form' => true,
					'fields' => $fieldsForPenyfan,
					'html_before_fields' => '',
					'html_after_fields' => '',
					'submit_value' => 'Update Listing',
					'updated_message' => 'Saved!'
					);
					acf_form( $new_post);
				}
				?>

				<div class="g_grid_3 has-white-background-color dashboard-sidebar">
					<?php include THEME_DIR . '/parts/dashboard-navigation.php'; ?>
				</div>
		    		
			
				
		    	<?php //Check if user subscription has expired
		    	// If it has expired $user_subscription_has_expired = true;
		    	$user_subscription_has_expired = false;
		     
		    	if ( $user_page_id != "" && $user_subscription_has_expired == false) { ?>
				

		    		<?php //add ACF form to allow the editing of the fields of the post with id = $user_page_id ?>
				<div class="g_grid_9 dashboard-content-wrap">

					<img src="<?php echo get_bloginfo('template_directory');?>/images/global/messages.png" alt="To do" class="sectionIcon"/>
					<h2>Edit Listing</h2>
					<div class="overlay">
                        <div id="the-loader" class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                    </div>
					<?php if(isset($_GET['subscription-cancelled'])): ?>
						<div id="message" class="updated" style="background: #ac4646;"><p>Cancellation of your Subscription is Succesfull. Your remaining time on your account will be honoured. No refunds given.</p></div>
					<?php endif; ?>

					<?php

						if(!$user_subscription_expiry){
							echo "<p>Please subscribe to edit/view you listing.</p>";
							echo "<a class='internal-button' href='" . get_the_permalink(get_field('listing_dashboard','option')) . "'>Subscribe Now.</a>";
						
						}else{

							
							if($subscription_type === 'Basic'){
								$fieldsForBasic = array(
									'address',
									'town',
									'county',
									'postcode',
									'phone',
									'email',
									'listing_description',
									'image_gallery',
									'reviews',
									'map_location'
								);
								$new_post= array(
									'post_id' => $user_page_id, 
									'form' => true,
									'fields' => $fieldsForBasic,
									'html_before_fields' => '',
									'html_after_fields' => '',
									'submit_value' => 'Update Listing',
									'updated_message' => 'Saved!'
								);
								acf_form( $new_post);
							}else if($subscription_type === 'Better'){
								$fieldsForPenyfan = array(
									'address',
									'town',
									'county',
									'postcode',
									'phone',
									'email',
									'listing_description',
									'image_gallery',
									'website_url',
									'instagram',
									'facebook',
									'twitter',
									'reviews',
									'map_location'
								);
								$new_post= array(
								'post_id' => $user_page_id, 
								'form' => true,
								'fields' => $fieldsForPenyfan,
								'html_before_fields' => '',
								'html_after_fields' => '',
								'submit_value' => 'Update Listing',
								'updated_message' => 'Saved!'
								);
								acf_form( $new_post);

							}else{
							
								$fieldsForPenyfan = array(
									'address',
									'town',
									'county',
									'postcode',
									'phone',
									'email',
									'listing_description',
									'image_gallery',
									'video_urls',
									'website_url',
									'instagram',
									'facebook',
									'twitter',
									'reviews',
									'map_location'
								);
								$new_post= array(
								'post_id' => $user_page_id, 
								'form' => true,
								'fields' => $fieldsForPenyfan,
								'html_before_fields' => '',
								'html_after_fields' => '',
								'submit_value' => 'Update Listing',
								'updated_message' => 'Saved!'
								);
								acf_form( $new_post);
							}


							// $new_post= array(
							// 'post_id' => $user_page_id, 
							// 'form' => true,
							// 'html_before_fields' => '',
							// 'html_after_fields' => '',
							// 'submit_value' => 'Update Listing',
							// 'updated_message' => 'Saved!'
							// );
							// acf_form( $new_post);
							?>
							

							<script>
								jQuery(document).ready(() => {
									var isPresented = false;
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
										jQuery('.overlay').css('display','flex');
                                		jQuery('#cancelSub').prop('disabled', true);
										jQuery('#cancelSubscriptionLoader').show();
										jQuery.ajax({
											url: '<?=get_site_url()?>/wp-json/atw/v1/cancel-subscription',
											method: 'POST',
											// data: {action: 'cancelling_subscription', subscriptionId: '< ?=$subscription_id?>'},
											data: {subscriptionId: '<?=$subscription_id?>'},
											success: function(res){
												console.log(res)
												// window.location.reload(true);
												// setTimeout(function(){ window.location.reload(true); }, 5000)
												setTimeout(function(){ window.location.href = "https://" + window.location.host + window.location.pathname + '?' + "subscription-cancelled=true"; }, 5000)
											}
										})
									})

									// listing-description-field watch for 500 words.
									var subscriptionType = "<?=$subscription_type?>"
									jQuery('#image-gallery-field .acf-actions a').on('click', function(e){
										var rowLength = jQuery('#image-gallery-field table tr').length;
										console.log(rowLength)
										if(subscriptionType === 'Snowdon'){
											if(rowLength > 50){
												jQuery('#image-gallery-field table tr')[50].remove();
											}
										}else if(subscriptionType === 'Penyfan'){
											if(rowLength > 25){
												jQuery('#image-gallery-field table tr')[25].remove();
											}
										}else if(subscriptionType === 'Basic'){
											if(rowLength > 1){
												jQuery('#image-gallery-field table tr')[1].remove();
											}
										}
									})

									jQuery('#video-gallery-field .acf-actions a').on('click', function(e){
										var rowLength = jQuery('#video-gallery-field table tr').length;
										if(rowLength > 5){
											jQuery('#video-gallery-field table tr')[5].remove();
										}
									})


								})
							</script>

							<?php
							//They dont want the user to be able to cancel
							$showcancel = false;
							if($showcancel) {
								if($subscription_status !== 'canceled'){ ?>
									<div class="cancelSubscription-wrapper">
										<h4>Cancel Subscription</h4>
										<p>After cancelling your subscription you will not be charged further payments but your any remaining time on your account will be honoured. No refunds are given.</p>
										<button id='cancelSub' class='acf-button button button-primary button-large cancelSubscriptionButton'>Cancel Subscription</button>
										<p id='cancelSubscriptionLoader' style='display:none;'>Processing, Please wait... </p>
									</div>
								<?php }
							}
							
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
