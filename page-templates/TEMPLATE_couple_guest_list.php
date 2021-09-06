<?php 
/*
Template Name: Couple Guest List
*/
?>
<?php acf_form_head(); ?>
<?php Embers_Utilities::get_template_parts( array( 'parts/html-header', 'parts/header' ) ); ?>

<div class="container row dashboard-container">
<?php
    global $current_user; 
    wp_get_current_user();
    $userPageId = $current_user->user_page_id;
    
?>

<?php if(is_user_logged_in()){ ?>
    <?php if(current_user_can( 'couple' ) || current_user_can( 'administrator' )){ ?>
        <div class="overlay">
            <div id="the-loader" class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
        </div>
        <div class="g_grid_3">
            <?php include THEME_DIR . '/parts/couple-dashboard-navigation.php'; ?>
        </div>
        <div class="g_grid_9 row dashboardSection">

        
            <div class="g_grid_8">
                <img src="<?php echo get_bloginfo('template_directory');?>/images/global/guestlist.png" alt="To do" class="sectionIcon"/>
                <h2>Guest List</h2>

                <?php
                $rows = get_field('guest_list', $userPageId);
                if(!empty($rows)){ ?>
                    <table>
                        <tr>
                            <th>Name</th>
                            <th>Notes</th>
                            <th></th>
                            <th></th>
                        </tr>
                        <?php
                            if( $rows ) {
                                $rowNumber = 0;
                                foreach( $rows as $row ) {
                                    $rowClass = '';
                                    if($row['status']['value'] === 'attending'){
                                        $rowClass = 'has-green-background-color';
                                    }else if($row['status']['value'] === 'declined'){
                                        $rowClass = 'has-red-background-color';
                                    }
                                    echo '<tr id="row-'. $rowNumber .'" class="'. $rowClass .'">';
                                    
                                    echo '<td class="row-name">'. $row['name'] .'</td>';
                                    echo '<td class="row-notes">'. $row['notes'] .'</td>';
                                    echo '<td class="row-status">'. $row['status']['label'] .'</td>';
                                    echo '<td class="row-action"><a onclick="showEdit('. '\'row-'.$rowNumber .'\')" class="editItem">Edit</a>  <a onclick="removeGuest('.$rowNumber.')" class="removeItem">Remove</a></td>';
                                    echo '</tr>';
                                    $rowNumber++;
                                }
                            }
                        ?>
                    </table>

                

                <script>

                function removeGuest(row){
                    var rowToRemove = row + 1;
                    jQuery('.overlay').css('display','flex');
                    jQuery.ajax({
                        url: fmw_ajax.ajaxurl,
                        method: 'POST',
                        data: {action: 'removeGuest', row: rowToRemove},
                        success: function(res){
                            location.reload();
                        }
                    })
                }

                function showEdit(rowIdentifyer){
                    // console.log(jQuery(`#${rowIdentifyer}`))
                    var selectedRow = jQuery(`#${rowIdentifyer}`)
                    var rowNameValue = selectedRow.find('.row-name').text();
                    var rowNotesValue = selectedRow.find('.row-notes').text();
                    var rowStatusValue = selectedRow.find('.row-status').text();
                    selectedRow.find('.row-name').remove();
                    selectedRow.find('.row-notes').remove();
                    selectedRow.find('.row-status').remove();
                    selectedRow.find('.row-action').remove();
                    console.log(rowNameValue, rowNotesValue, rowStatusValue)
                    selectedRow.append(`
                            <td><input type="text" name="${rowIdentifyer}-name" value="${rowNameValue}" required></td>
                            <td><input type="text" name="${rowIdentifyer}-notes" value="${rowNotesValue}" required></td>
                            <td>
                                <select name="${rowIdentifyer}-status" id="${rowIdentifyer}-status">
                                    ${defaultSelected(rowStatusValue)}
                                    <option value="hold">Save the date sent</option>
                                    <option value="sent">Invitation sent</option>
                                    <option value="awaiting">Awaiting RSVP</option>
                                    <option value="attending">Attending</option>
                                    <option value="declined">Declined</option>
                                </select>
                            </td>
                            <td><a onclick="updateGuest('${rowIdentifyer}', '<?=$userPageId?>')">Update</a></td>
                    `)
                }

                function updateGuest(rowIdentifyer, pageId){
                    console.log(rowIdentifyer, pageId)
                    var rowToUpdate = jQuery(`#${rowIdentifyer}`)
                    var nameToUpdate = rowToUpdate.find(`input[name="${rowIdentifyer}-name"]`).val()
                    var notesToUpdate = rowToUpdate.find(`input[name="${rowIdentifyer}-notes"]`).val()
                    var statusToUpdate = rowToUpdate.find(`#${rowIdentifyer}-status`).val()

                    rowToUpdate.find('a').text('Updating')
                    var rowNum = parseInt(rowIdentifyer.split('-')[1]) + 1;
                    jQuery('.overlay').css('display','flex');
                    jQuery.ajax({
                        url: fmw_ajax.ajaxurl,
                        method: 'POST',
                        data: {action: 'updateCoupleGuest', data: {guestName:nameToUpdate, guestNotes:notesToUpdate, guestStatus:statusToUpdate, rowNumber: rowNum}},
                        success: function(res){
                            console.log(res)
                            location.reload()
                        }
                    })

                }


                function defaultSelected(selectedValue){
                    console.log(selectedValue)
                    var el = '';
                    switch(selectedValue){
                        case 'Hold the date sent':
                            el = '<option value="hold" selected>Save the date sent</option>'
                            break;
                        case 'Invitation sent':
                            el = '<option value="sent" selected>Invitation sent</option>'
                            break;
                        case 'Awaiting RSVP':
                            el = '<option value="awaiting" selected>Awaiting RSVP</option>'
                            break;
                        case 'Attending':
                            el = '<option value="attending" selected>attending</option>'
                            break;
                        case 'Declined':
                            el = '<option value="declined" selected>Declined</option>'
                            break;
                        default:
                            break;
                    }
                    return el
                }
                </script>
            <?php }else{ ?>
                <h3>Your Guest List is empty.</h3>
            <?php } ?>

            <script>
                jQuery(document).ready((e) => {

                jQuery('#add-guest').on('submit', (e) => {
                        e.preventDefault();
                        console.log('doubled??')
                        jQuery('.overlay').css('display','flex');
                        jQuery('#addGuestBtn').prop('disabled', true);
                        var guestName = jQuery('#guest-name').val()
                        var guestNotes = jQuery('#guest-notes').val()
                        var guestStatus = jQuery('#guest-status').val()
                        // var todoDue = jQuery('#todo-due').val()
                        // var todoBudget = jQuery('#todo-budget').val()
                        // console.log(guestStatus)
                        jQuery.ajax({
                            url: fmw_ajax.ajaxurl,
                            method: 'POST',
                            data: {action: 'addGuest', data: {guestName:guestName, guestNotes:guestNotes, guestStatus:guestStatus}},
                            success: function(res){
                                console.log(res)
                                location.reload()
                            }
                        })
                    })
                })
            </script>
            </div>
            <div class="g_grid_4">
                <form id="add-guest">
                    <label for="guest-name">Guest Name</label>
                    <input type="text" name="guest-name" id="guest-name" required>

                    <label for="guest-notes">Notes</label>
                    <input type="text" name="guest-notes" id="guest-notes">

                    <label for="guest-status">Status</label>
                    <select name="status" id="guest-status">
                        <option value="hold">Save the date sent</option>
                        <option value="sent">Invitation sent</option>
                        <option value="awaiting">Awaiting RSVP</option>
                        <option value="attending">Attending</option>
                        <option value="declined">Declined</option>
                    </select><br>

                    <input id="addGuestBtn" type="submit" value="Add">
                </form>
            </div>
        </div>
        
    <?php }else{ ?>
        <?php echo "You don't have permission to access this part"; ?>
    <?php } ?>
<?php }else{ ?>
    <?php include THEME_DIR . '/parts/couple-registration-form.php'; ?>
<?php } ?>
</div>
<?php Embers_Utilities::get_template_parts( array( 'parts/footer','parts/html-footer' ) ); ?>