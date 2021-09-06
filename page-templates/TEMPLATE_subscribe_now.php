<?php 
/*
Template Name: Subscription Page
*/
// acf_form_head();
?>
<?php Embers_Utilities::get_template_parts( array( 'parts/html-header', 'parts/header' ) ); ?>
<?php
  global $current_user; 
  wp_get_current_user();
  $userId = $current_user->ID;

  $content = get_the_content(false, false, 24);
  $myblocks = parse_blocks($content);
  $collect = [];
  $theFields;

  foreach($myblocks as $block){
		
        if( isset($block['attrs']['data']) && !empty($block['attrs']['data'][array_keys($block['attrs']['data'])[0]])){	
                                    
            acf_setup_meta( $block['attrs']['data'], $block['attrs']['id'], true );
                
            $fields = get_fields();
                
            acf_reset_meta( $block['attrs']['id'] );
                    
            // $collect[$block['attrs']['data'][array_keys($block['attrs']['data'])[0]]] = array('render' 	=> 	render_block( $block ),
            //                                                                         'field' 	=>	$fields,																							
            //                                                                         'block'  	=> 	$block
            //                                                                         );
            $theFields = $fields;
        }else{
            $collect['main'] .= render_block( $block );
        }
    }
?>

<div class="dashboard-container row ">

	<?php 
	if(is_user_logged_in()) { 

		if(current_user_can('administrator') || current_user_can('business')) { ?>
            <?php if(current_user_can('business')){
                $listingPageId = get_user_meta($userId, 'user_page_id', true);
                $licenseType = apply_filters( 'term_getter', $listingPageId, 'listing-license' );
                echo "<script> var currentLicense = $licenseType</script>";
            } ?>

            <div class="g_grid_3 has-white-background-color dashboard-sidebar">

                <?php include THEME_DIR . '/parts/dashboard-navigation.php'; ?>

            </div>


		    <div class="g_grid_9 dashboard-content-wrap">



			 <?php if ( $current_user ) {

		    	$user_page_id = get_user_meta( $current_user->ID, 'user_page_id' , true );
		    	$user_subscription_expiry = get_user_meta( $current_user->ID, 'user_subscription_expiry' , true );
		    	$user_payment_id = get_user_meta( $current_user->ID, 'user_payment_id' , true );
				
				//echo '<pre>';
				//print_r($user_subscription_expiry);
                //echo "<br>";
				//print_r($user_page_id);
				//echo '</pre>';
				
		    	//Check if user subscription has expired
		    	// If it has expired $user_subscription_has_expired = true;
		    	$user_subscription_has_expired = false;
		     
		    	if ( ! empty( $user_page_id ) && $user_subscription_expiry == false) { ?>

                
                    <h3>Select a Subscription Package</h3>
                    
                    <div class="overlay">
                        <div id="the-loader" class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                    </div>

                    <!-- <div class="pricing-blocks subscription-pricing-blocks">
                        < ?php foreach($theFields['pricing_blocks'] as $pricing){ ?>
                            <div class="pricing-block">
                                <h2 class="has-beige-color">< ?=$pricing['name']?></h2>
                                <p class="pricing-subtitle">< ?=$pricing['sub_title']?></p>

                                <p class="pricing-price has-black-color">
                                <span class="has-pink-color">< ?=$pricing['price']?></span>
                                <span class="pricing-month"> / MONTH</span>
                                </p>
                                <p ><strong>INCLUDES</strong></p>
                                < ?php if(isset($pricing['features'])){ ?>
                                    <ul class="has-black-color">
                                        < ?php foreach($pricing['features'] as $pFeatures){ ?>
                                            <li>< ?=$pFeatures['feature']?></li>
                                        < ?php } ?>
                                    </ul>
                                < ?php } ?>
                                !<p><a href="#signup" class="has-pink-background-color has-white-color">JOIN NOW</a></p>
                                <button class="has-pink-background-color has-white-color" onclick="selecting('< ?=$pricing['name']?>', '< ?=$pricing['price']?>')">JOIN NOW</button>

                            </div>    
                        < ?php } ?>
                    </div> -->

                    <div class="benefits-table">
                        <table>
                            <tr>
                                <th></th>
                                <th></th>
                                <th class="pop-flag"><span>Most Popular</span></th>
                                <th class="pop-flag max-flag"><span>Maximum Exposure</span></th>
                            </tr>
                            <tr>
                                <th>Features</th>
                                <th>Basic</th>
                                <th>Better</th>
                                <th>Best</th>
                            </tr>

                            <?php if( have_rows('package_features','option') ):
                                while( have_rows('package_features','option') ) : the_row();?>

                                    <tr>
                                        <td><?php echo get_sub_field('feature');?></td>
                                        <td><?php echo get_sub_field('basic');?></td>
                                        <td><?php echo get_sub_field('better');?></td>
                                        <td><?php echo get_sub_field('best');?></td>
                                    </tr>

                                <?php endwhile;
                            endif;?>

                            <tr>
                                <td></td>
                                <?php
                                    $basicPrice; $betterPrice; $bestPrice;
                                    $basicPriceVal; $betterPriceVal; $bestPriceVal;
                                    if( $licenseType == "Supplier" ){
                                        $basicPrice = get_field('supplier_basic_price','option');
                                        $betterPrice = get_field('supplier_better_price','option');
                                        $bestPrice = get_field('supplier_best_price','option');
                                    }else{
                                        $basicPrice = get_field('venue_basic_price','option');
                                        $betterPrice = get_field('venue_better_price','option');
                                        $bestPrice = get_field('venue_best_price','option');

                                    }
                                ?>
                                <td>
                                    <div class="feature-price">£ <?=$basicPrice?></div>
                                    <button class="" onclick="selecting('basic', '<?=$basicPrice?>')">SUBSCRIBE NOW</button>
                                </td>
                                <td>
                                    <div class="feature-price">£ <?=$betterPrice?></div>
                                    <button class="" onclick="selecting('better', '<?=$betterPrice?>')">SUBSCRIBE NOW</button>
                                </td>
                                <td>
                                    <div class="feature-price">£ <?=$bestPrice?></div>
                                    <button class="" onclick="selecting('best', '<?=$bestPrice?>')">SUBSCRIBE NOW</button>
                                </td>
                            </tr>
                        </table>
                    </div>



                    <div class="subscription-form-container" >
                        <div class="indicator-container" style="display:none;">
               
                            <div class='card-wrapper'></div>
                        </div>
                        <form id="subscriptionForm" style="display:none;">
                            <label for="email">Email</label>
                            <input type="email" id="email" required name="email"/>

                            <label for="firstName">First Name</label>
                            <input type="text" id="firstName" required name="first-name"/>

                            <label for="lastName">Last Name</label>
                            <input type="text" id="lastName" required name="last-name"/>

                            <label for="number">Card Number</label>
                            <input type="text" id="number" required name="number">

                            <label for="expiry">Expiry</label>
                            <input type="text" id="expiry" required name="expiry"/>

                            <label for="cvc">CVC</label>
                            <input type="text" id="cvc" required name="cvc"/>

                            <input type="hidden" name="userId" value="<?=$userId;?>">

                            <p id="errorMessage" style="display:none;color:red;">error</p>

                            <p><input id="subscribeNowBtn" type="submit" value="Subscribe" class="has-pink-background-color"></p>
                        </form>
                    </div>
                    <script>
                        var card = new Card({
                            form: 'form',
                            container: '.card-wrapper',

                            formSelectors: {
                                nameInput: 'input[name="first-name"], input[name="last-name"]'
                            },
                            placeholders: {
                                number: '**** **** **** ****',
                                name: 'John Doe',
                                expiry: '**/****',
                                cvc: '***'
                            },
                            masks: {
                                cardNumber: '•' // optional - mask card number
                            },
                        });

                        var selectedSubscription;

                        const selecting = (params, price) => {
                            console.log(params)
                            selectedSubscription = params
                            // if(params === 'Basic'){
                            //     selectedSubscription = 'bronze';
                            // }else if(params === 'Penyfan'){
                            //     selectedSubscription = 'silver';
                            // }else{
                            //     selectedSubscription = 'gold';
                            // }
                            console.log(selectedSubscription)
                            jQuery('.indicator-container').slideDown()
                            jQuery('#subscriptionForm').slideDown()
                            jQuery('#selectedPackageName').text(params)
                            jQuery('#selectedPackagePrice').text(price)
                        }

                        jQuery(document).ready(() => {

                            jQuery('#subscriptionForm').on('submit', (e) => {
                                e.preventDefault();
                                jQuery('.overlay').css('display','flex');
                                jQuery('#subscribeNowBtn').prop('disabled', true);
                                var subscriptionData = jQuery('#subscriptionForm').serializeArray();
                                console.log(subscriptionData)
                                jQuery.ajax({
                                    url: '<?=get_site_url()?>/wp-json/fmw/v1/subscribe-now',
                                    method: 'POST',
                                    data: {license: currentLicense, paymentDetails: subscriptionData, selectedSubscription: selectedSubscription},
                                    success: function(res){
                                        console.log(res)
                                        if(res.error){
                                            jQuery('#errorMessage').text(res.message);
                                            jQuery('#errorMessage').show()
                                        }else{
                                            jQuery('#errorMessage').hide()
                                            if(res.status){
                                                document.location.href = '<?=get_site_url()?>/edit-listing'
                                            }else{
                                                document.location.href = `<?=get_site_url()?>${res.redirect_url}`
                                            }
                                        }
                                    },
                                    error: function(res){
                                        console.logJSON.parse(res)
                                    }
                                })
                            })
                        })

                    </script>
		    		<?php
						
		    	} elseif( ! empty($current_user) && $user_subscription_expiry ) { ?>

		            <img src="<?php echo get_bloginfo('template_directory');?>/images/global/messages.png" alt="To do" class="sectionIcon"/>
                    <h2>Messages</h2>

                    <!-- show enquiry table here -->
                    <?php
                        $enquiryArgs = array(
                            'post_type' => 'message',
                            'meta_query' => array(
                                'relation' => 'AND',
                                array(
                                    'key' => 'business_email',
                                    'value' => $current_user->user_email
                                ),
                                array(
                                    'key' => 'deletedByListingOwner',
                                    'compare' => 'NOT EXISTS'
                                )
                            ),
                            'numberposts'   =>  -1,
                        );
                        $enquiries = get_posts($enquiryArgs);
                        
                        // echo '<pre>';
                        // print_r($enquiries);
                        // echo '</pre>';
                        // die();
                        ?>
                        <table class="responsiveTable">
                            <tr>
                                <th>Couple Name</th>
                                <th class="textcenter">Enquiry Type</th>
                                <th class="textcenter">Replies</th>
                                <th></th>
                            </tr>
                        <?php foreach($enquiries as $enq){ 
                            $isNew = 'has-pink-background-color';
                            $flagNew = '';

                            $isNewResponse = '';
                            $newResponseFlag = false;
                            if(get_post_meta( $enq->ID, 'couple_new_reply', true ) == 1){ $isNewResponse = '?couple-new-reponse'; $newResponseFlag = true;}
                            if(get_post_meta( $enq->ID, 'new_message', true ) == 1){ $isNew = ''; $flagNew = '?new';}
                            ?>
                            <tr class="<?=$isNew?>">
                                <td><?=$enq->post_title?></td>
                                <?php foreach(get_the_terms($enq->ID, 'enquiry-type') as $enqType){?>
                                    <td class="textcenter"><?= $enqType->name ?></td>
                                <?php } ?>
                                <td class="textcenter"><?= get_comments_number($enq->ID) ?> <?php echo $newResponseFlag ? "| New Response" : "" ?></td>
                                <td class="textcenter"><a href="<?=$enq->guid . $flagNew?>" >View</a> | <a id="<?=$enq->ID?>-message" onclick="deleteMessage(<?=$enq->ID?>, event)" class="delete-message-btn removeItem">Delete</a></td>
                            </tr>
                        <?php } ?>

                        </table>
                        <script>
                        function deleteMessage(id, event){
                            event.preventDefault();
                            jQuery(`#${id}-message`).text('Deleting')
                            jQuery.ajax({
                                url: fmw_ajax.ajaxurl,
                                method: 'POST',
                                data: {action: 'listingMessageDelete', idToDelete: id},
                                success: function(res){
                                    console.log(res)
                                    location.reload()
                                }
                            })
                        }
                        </script>
                    <!-- show enquiry table here -->
                    

				<?php }else{

                   //usually an admim user
                   echo '<p>No page associated with this account</p>';

                }

			} ?>
            </div>

		<?php } else {

			echo '<p>You do not have permission to access this page</p>';

		}

	} else {
        echo '<div class="container">';
		include THEME_DIR . '/parts/registration-form.php';
        echo '</div>';

	}
	?>

</div>


<?php Embers_Utilities::get_template_parts( array( 'parts/footer','parts/html-footer' ) ); ?>