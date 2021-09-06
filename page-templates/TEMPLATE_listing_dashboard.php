<?php 
/*
Template Name: Listing Dashboard
*/
?>
<?php Embers_Utilities::get_template_parts( array( 'parts/html-header', 'parts/header' ) ); ?>

<div class="container row dashboard-container">
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; ?>

	<?php
		global $current_user; 
		wp_get_current_user();

        
        
        
	?>
    <?php if(is_user_logged_in()){ ?>
        <?php if(current_user_can('administrator') || current_user_can('business')) {  ?>


                <div class="g_grid_3">

                    <?php include THEME_DIR . '/parts/dashboard-navigation.php'; ?>

                </div>
                <div class="g_grid_9">


                <?php if(get_user_meta( $current_user->ID, 'user_subscription_expiry' , true )) {?>

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
                        <table>
                            <tr>
                                <th>Couple Name</th>
                                <th>Enquiry Type</th>
                                <th>Replies</th>
                                <th></th>
                            </tr>
                        <?php foreach($enquiries as $enq){ 
                            $isNew = 'has-grey-background-color';
                            $flagNew = '';

                            $isNewResponse = '';
                            $newResponseFlag = false;
                            if(get_post_meta( $enq->ID, 'couple_new_reply', true ) == 1){ $isNewResponse = '?couple-new-reponse'; $newResponseFlag = true;}
                            if(get_post_meta( $enq->ID, 'new_message', true ) == 1){ $isNew = ''; $flagNew = '?new';}
                            ?>
                            <tr class="<?=$isNew?>">
                                <td><?=$enq->post_title?></td>
                                <?php foreach(get_the_terms($enq->ID, 'enquiry-type') as $enqType){?>
                                    <td><?= $enqType->name ?></td>
                                <?php } ?>
                                <td><?= get_comments_number($enq->ID) ?> <?php echo $newResponseFlag ? "| New Response" : "" ?></td>
                                <td><a href="<?=$enq->guid . $flagNew?>" class="viewItem">View</a> <a id="<?=$enq->ID?>-message" onclick="deleteMessage(<?=$enq->ID?>, event)" class="delete-message-btn removeItem">Delete</a></td>
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

            <?php }else{?>

                <h2>Subscribe</h2>
                <div class="row">
            
                    <div class="g_grid_8">
                            <form id="subscriptionForm">
                                <label for="email">Email</label>
                                <input type="email" id="email" required name="email" />

                                <label for="firstName">First Name</label>
                                <input type="text" id="firstName" required name="first-name"/>

                                <label for="lastName">Last Name</label>
                                <input type="text" id="lastName" required name="last-name"/>

                                <label for="number">Card Number</label>
                                <input type="text" id="number" required name="number">

                                <label for="expiry">Expiry Date</label>
                                <input type="text" id="expiry" required name="expiry" placeholder="" />

                                <label for="cvc">CVC</label>
                                <input type="text" id="cvc" required name="cvc"/>

                                <input type="hidden" name="userId" value="<?=$userId;?>">

                                <p id="errorMessage" style="display:none;color:red;">error</p>

                                <input type="submit" value="Subscribe">
                            </form>
                            
                    </div>

                    <div class="g_grid_4">
                        <div class='card-subscribe'></div>
                    </div>
                </div>

                <script>

                                    var card = new Card({
                                        form: '#subscriptionForm',
                                        container: '.card-subscribe',

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


                                jQuery(document).ready(() => {
                                    jQuery('#subscriptionForm').on('submit', (e) => {
                                        e.preventDefault();
                                        var subscriptionData = jQuery('#subscriptionForm').serializeArray();
                                        jQuery.ajax({
                                            url: '/wp-json/atw/v1/subscribe-now',
                                            method: 'POST',
                                            data: {paymentDetails: subscriptionData},
                                            success: function(res){
                                                console.log(res)
                                                if(res.error){
                                                    jQuery('#errorMessage').text(res.message);
                                                    jQuery('#errorMessage').show()
                                                }else{
                                                    jQuery('#errorMessage').hide()
                                                    if(res.status){
                                                        document.location.href = '/edit-listing'
                                                    }else{
                                                        document.location.href = res.redirect_url
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

            <?php } ?>

        </div>

        
            <!-- < ?php echo do_shortcode( '[change_password]' ) ?> -->

        <?php }else{ ?>
            <?php echo '<p>You do not have permission to access this page</p>';?>
        <?php } ?>
    <?php }else{ ?>
        <?php include THEME_DIR . '/parts/registration-form.php'; ?>
    <?php } ?>
    
</div>


<?php Embers_Utilities::get_template_parts( array( 'parts/footer','parts/html-footer' ) ); ?>