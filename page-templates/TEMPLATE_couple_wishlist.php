<?php 
/*
Template Name: Couple Wishlist
*/
?>
<?php acf_form_head(); ?>
<?php Embers_Utilities::get_template_parts( array( 'parts/html-header', 'parts/header' ) ); ?>

<div class=" row dashboard-container">
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
                <img src="<?php echo get_bloginfo('template_directory');?>/images/global/idea.png" alt="To do" class="sectionIcon"/>
                <h2>Shortlist</h2>

                <?php
                    $wishListingIDs = get_user_meta($current_user->ID, 'couple_wishlist', true);
                    foreach($wishListingIDs as $wID){
                        $wishListings[] = get_post($wID);
                    }
                    
                ?>

                <?php if(!empty($wishListings)) {?>
                    <table>
                        <thead>
                            <tr>
                                <th>Business Name</th>
                                <th>Category</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($wishListings as $listing){ ?>
                                <tr>
                                    <td><a href="<?=$listing->guid?>"><?=$listing->post_title?></a></td>
                                    <td><?php get_the_terms( $listing->ID, 'listing-category' )[0]->name ?></td>
                                    <td><a onclick="remove(<?=$current_user->ID?>, <?=$listing->ID?>)" class="removeItem">remove</a></td>
                                </tr>
                        <?php }?>
                        </tbody>
                    </table>
                    <script>
                        function remove(userId, listingId){
                            jQuery.ajax({
                                url: fmw_ajax.ajaxurl,
                                method: 'POST',
                                data: {action: 'removeToWishList', userId, listingId},
                                success: function(res){
                                    location.reload()
                                }
                            })
                        }
                    </script>
                <?php }else{ ?>                
                    <h3>Your Wishlist is empty.</h3>
                <?php } ?>
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
