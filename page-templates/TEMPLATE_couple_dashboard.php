<?php 
/*
Template Name: Couple Dashboard
*/
?>
<?php acf_form_head(); ?>
<?php Embers_Utilities::get_template_parts( array( 'parts/html-header', 'parts/header' ) ); ?>

<div class="row dashboard-container">

    <?php
        global $current_user; 
        wp_get_current_user();
        $userPageId = $current_user->user_page_id;
        $user_page_id = get_user_meta( $current_user->ID, 'user_page_id' , true );
        
        $userdescription = get_user_meta( $current_user->ID, 'wedmatch_userdescription', true);
    ?>

    <?php if(is_user_logged_in()) { ?>

        <?php if(current_user_can('administrator') || current_user_can('couple')) {  ?>

            <div class="g_grid_3 has-white-background-color dashboard-sidebar">
                <?php include THEME_DIR . '/parts/couple-dashboard-navigation.php'; ?>
            </div>
            <div class="g_grid_9 row dashboard-content-wrap">

                <h4 class="dashTitle">Welcome to your Find My Wedding dashboard</h4>

                <div class="fullHeightColumns">
                    <div class="fullHeightColumn has-background-color has-light-pink-background-color g_grid_4">

                        <div class="userType-container">
                            <?php if(!get_field('user_type',$userPageId) == "") { ?>

                                <div class="userType-icon <?php echo get_field('user_type',$userPageId);?>"></div>

                            <?php } ?>

                            <?php
                            acf_form(array(
                                'id' => 'userdescription-form',
                                'post_id'   => $userPageId,
                                'post_title'    => false,
                                'fields' => array('user_type'),
                                'submit_value'  => 'Update'
                            ));
                            ?>
                        </div>


                        <div class="dashboard-weddingdate">
                             <div class="dashboard-content">
                                <h5 class="has-black-color">Your Wedding Date</h5>
                                <p>Select a date for the big day.</p>
                            </div>

                            <?php
                                acf_form(array(
                                    'post_id'   => $userPageId,
                                    'post_title'    => false,
                                    'fields' => array('wedding_date'),
                                    'submit_value'  => 'Update'
                                ));
                            ?>

                        </div>

                        <div class="dashboard-content">
                            <h5 class="has-black-color">My Wedding Countdown</h5>
                            
                            <p class="textcenter"><a href="<?php echo get_the_permalink($userPageId);?>">Visit Your Page</a></p>
                        </div>
                    </div>

                    <div class="fullHeightColumn g_grid_4">

                        <div class="dashboard-content">
                            <img src="<?php echo get_bloginfo('template_directory');?>/images/global/to-do-icon.png" alt="To do" class="sectionIcon"/>
                            <h5 class="has-black-color">To Do List</h5>
                            <p>Don't forget a thing on your big day. Keep track of what's to do by updating your Find My Wedding To Do List.</p>
                        </div>

                        <div class="dashboard-todo">
                            <?php
                            $i = 1;
                            $repeater = get_field('to_do',$userPageId);
                            if(is_array($repeater)):
                                foreach( $repeater as $key => $row ) { 
                                    $column_id[ $key ] = $row['due_date'];
                                } 
                                array_multisort( $column_id, SORT_ASC, $repeater );
                                foreach( $repeater as $row ) :
                                    if( $i < 5 ) :
                                        if(!$row['done']) { ?>
                                            <?php 
                                            $date =  date('Ymd');
                                            $difference = $row['due_date'] - $date;
                                            if($difference < 7) {
                                                $class = 'is-style-due';
                                            }
                                            if($difference > 7) {
                                                $class = 'is-style-nearlydue';
                                            }
                                            if($difference > 14) {
                                                $class = 'is-style-notdue';
                                            }
                                            ?>
    
                                            <div class="toDo-list-item <?php echo $class;?>">
                                                <h3><?php echo $row['to_do_name'];?></h3>
                                                <?php if($row['due_date']): ?>
                                                    <p><?php echo DateTime::createFromFormat('Ymd', $row['due_date'])->format('d M Y');?></p>
                                                <?php endif; ?>
                                            </div>
                                             
                                            <?php $i ++;
                                        }
                                    endif;
                                endforeach;
                            endif;
                            ?>
                           
                        </div>
                        <p><a href="<?php echo get_the_permalink(get_field('couples_todo_page','option'));?>" class="wp-block-button__link no-border-radius">Manage To-Do List</a></p>
                    </div>

                    <div class="fullHeightColumn g_grid_4">
                        <div class="dashboard-content">
                            <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
                                <?php the_content(); ?>
                            <?php endwhile; ?>
                        </div>

                        <div class="dashboard-cover-photo">
                            <h5>My Wedding Countdown Cover Photo</h5>
                            <?php
                                acf_form(array(
                                    'post_id'   => $userPageId,
                                    'post_title'    => false,
                                    'fields' => array('couples_cover_photo'),
                                    'submit_value'  => 'Update'
                                ));
                                ?>
                        </div>
                    </div>

                </div>
            </div>

        <?php }else{ ?>

            <?php echo '<p>You do not have permission to access this page</p>';?>

        <?php } ?>
        
    <?php }else{ ?>

        <?php include THEME_DIR . '/parts/couple-registration-form.php'; ?>
        
    <?php } ?>
</div>


<?php Embers_Utilities::get_template_parts( array( 'parts/footer','parts/html-footer' ) ); ?>