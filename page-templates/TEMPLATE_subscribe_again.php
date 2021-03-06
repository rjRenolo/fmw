<?php 
/*
Template Name: Subscribe Again
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

<div class="dashboard-container row">



<?php 
	if(is_user_logged_in()) { 

		if(current_user_can('administrator') || current_user_can('business')) { ?>


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

                
		    	$user_subscription_has_expired = false;?>

                <h2>Select a Subscription Package</h2>
                                    
                    <div class="overlay">
                        <div id="the-loader" class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                    </div>

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
                                    <div class="feature-price"><?=$basicPrice?></div>
                                    <button class="" onclick="selecting('basic', '<?=$basicPrice?>')">SUBSCRIBE NOW</button>
                                </td>
                                <td>
                                    <div class="feature-price"><?=$betterPrice?></div>
                                    <button class="" onclick="selecting('better', '<?=$betterPrice?>')">SUBSCRIBE NOW</button>
                                </td>
                                <td>
                                    <div class="feature-price"><?=$bestPrice?></div>
                                    <button class="" onclick="selecting('best', '<?=$bestPrice?>')">SUBSCRIBE NOW</button>
                                </td>
                            </tr>
                        </table>
                    </div>



                    <div class="subscription-form-container" >
                        <div class="indicator-container" style="display:none;">
                            <div class="subscription-card has-pink-background-color" >
                                <h3 id="selectedPackageName">Gold Subscription</h3>
                                <p id="selectedPackagePrice">Some Price Here</p>
                            </div>
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

                            <input id="subscribeNowBtn" type="submit" value="Subscribe">
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
                                cardNumber: '???' // optional - mask card number
                            },
                        });

                        var selectedSubscription;
                        const selecting = (params, price) => {
                            console.log(params)
                            if(params === 'Basic'){
                                selectedSubscription = 'bronze';
                            }else if(params === 'Penyfan'){
                                selectedSubscription = 'silver';
                            }else{
                                selectedSubscription = 'gold';
                            }
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
                                    data: {paymentDetails: subscriptionData, selectedSubscription: selectedSubscription},
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

            </div>

		<?php 

            } 
        }
    }
        ?>

</div>
<?php Embers_Utilities::get_template_parts( array( 'parts/footer','parts/html-footer' ) ); ?>

