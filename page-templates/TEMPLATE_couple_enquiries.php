<?php 
/*
Template Name: Couple Enquiries
*/
?>
<?php acf_form_head(); ?>
<?php Embers_Utilities::get_template_parts( array( 'parts/html-header', 'parts/header' ) ); ?>

<div class="row dashboard-container">
    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
    <?php endwhile; ?>
    <?php
    global $current_user; 
    wp_get_current_user();
    $userPageId = $current_user->user_page_id;
    
    ?>
    <?php if(is_user_logged_in()){ ?>
        <?php if(current_user_can('administrator') || current_user_can('couple')) { ?>

            <div class="g_grid_3 has-white-background-color dashboard-sidebar">
                <?php include THEME_DIR . '/parts/couple-dashboard-navigation.php'; ?>
            </div>
            <div class="g_grid_9 dashboard-content-wrap">
                <img src="<?php echo get_bloginfo('template_directory');?>/images/global/messages.png" alt="To do" class="sectionIcon"/>
                <h2>Messages</h2>

                <?php
                $args = array(
                    'post_type' => 'message',
                    'numberposts'   =>  -1,
                    'meta_query' => array(
                        array(
                            'key' => 'couple_email',
                            'value' => $current_user->user_email
                        )
                    )
                );
                $myEnquiries = get_posts($args);
                ?>

                <table class="responsiveTable">
                    <tr>
                        <th></th>
                        <th>Recipient</th>
                        <th >Enquiry Type</th>
                        <th class="textcenter">Reply Count</th>
                        <th class="textcenter"></th>
                    </tr>


                <?php foreach($myEnquiries as $enq){ 
                    
                    $isNewResponse = '';
                    $newResponseFlag = false;
                    if(get_post_meta( $enq->ID, 'listing_new_reply', true ) == 1){ $isNewResponse = '?listing-owner-new-reponse'; $newResponseFlag = true;}
                    $indicator = get_post_meta($enq->ID, 'indicator', true);
                    ?>
                    <tr class="enquiries-list" data-indicator="<?=$indicator?>">
                        <td class="enquiry-indicator-wrap">
                            <select onchange="indicatorChanged(<?=$enq->ID?>, event)" class="message-indicator" id="select-<?=$enq->ID?>" style="color: <?=$indicator?>; font-size:24px; padding:3px;">
                                <option value="gray" style="font-size:24px;color:gray;">&#9679;</option>
                                <option value="green" style="font-size:24px;color:green;">&#9679; </option>
                                <option value="orange" style="font-size:24px;color:orange;">&#9679;</option>
                                <option value="red" style="font-size:24px;color:red;">&#9679;</option>
                            </select>
                        </td>
                        <td><?=get_post_meta($enq->ID, 'listing_name', true)?></td>
                        <?php foreach(get_the_terms($enq->ID, 'enquiry-type') as $enqType){?>
                            <td ><?= $enqType->name ?></td>
                        <?php } ?>
                        <td class="textcenter"><?= get_comments_number($enq->ID) ?>  <?php echo $newResponseFlag ? "| New Response" : "" ?></td>
                        <td class="textcenter"><a href="<?=$enq->guid . $isNewResponse?>" >View</a>  | <a id="<?=$enq->ID?>-message" onclick="deleteMessage(<?=$enq->ID?>, event)" class="delete-message-btn removeItem">Delete</a></td>
                    </tr>
                <?php } ?>

                </table>


                <script type="text/javascript" src="https://cdn.rawgit.com/prashantchaudhary/ddslick/master/jquery.ddslick.min.js" ></script>
                <script>
                    function indicatorChanged(ID, event){
                        // console.log(ID, indicatorValue)
                        // jQuery(`#select-${ID}`).css('color', String(indicatorValue))
                        jQuery(`#select-${ID}`).css('color', event.target.value)
                        jQuery.ajax({
                            url: fmw_ajax.ajaxurl,
                            method: 'POST',
                            data: {action: 'updateIndicator', postId: ID, value: event.target.value},
                            success: function(res){

                            }
                        })
                    }


                    function deleteMessage(id, event){
                        event.preventDefault();
                        jQuery(`#${id}-message`).text('Deleting')
                        jQuery.ajax({
                            url: fmw_ajax.ajaxurl,
                            method: 'POST',
                            data: {action: 'deleteMessage', idToDelete: id},
                            success: function(res){
                                console.log(res)
                                location.reload()
                            }
                        })
                    }

                </script>

            </div>

        <?php }else{ ?>
            <p>You don't have permission to access this page.</p>
        <?php } ?>
    <?php }else{ ?>
        <!-- unauthorized show log in form -->
        <?php include THEME_DIR . '/parts/couple-registration-form.php'; ?>
    <?php } ?>

</div>
<?php Embers_Utilities::get_template_parts( array( 'parts/footer','parts/html-footer' ) ); ?>