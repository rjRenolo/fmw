<?php 
/*
Template Name: Couple To Do List
*/
?>
<?php acf_form_head(); ?>
<?php Embers_Utilities::get_template_parts( array( 'parts/html-header', 'parts/header' ) ); ?>

<div class="row dashboard-container">

<?php
    global $current_user; 
    wp_get_current_user();
    $userPageId = $current_user->user_page_id;
    
?>
<?php if(is_user_logged_in()){ ?>
    <?php if(current_user_can( 'couple' ) || current_user_can( 'administrator' )){  ?>
        <div class="overlay">
            <div id="the-loader" class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
        </div>
        <div class="g_grid_3 has-white-background-color dashboard-sidebar">
                <?php include THEME_DIR . '/parts/couple-dashboard-navigation.php'; ?>
            </div>
            <div class="g_grid_9 row dashboard-content-wrap">
                

                <div class="g_grid_8 dashboardSection">
                    <img src="<?php echo get_bloginfo('template_directory');?>/images/global/to-do-icon.png" alt="To do" class="sectionIcon"/>
                    <h2>To Do List</h2>
                     <p>Don't forget a thing on your big day. Keep track of what's to do by updating your Find My Wedding To Do List.</p>

                    <table class="toDoTable">
                        <tr>
                            <th>To Do</th>
                            <th>Due</th>
                            <th>Budget</th>
                            <th></th>
                        </tr>
                                
                        <?php
                        $repeater = get_field('to_do',$userPageId);
                        foreach( $repeater as $key => $row ) { 
                            $column_id[ $key ] = $row['due_date'];
                        } 
                        // array_multisort( $column_id, SORT_ASC, $repeater );

                        $date =  date('Ymd');

                        foreach( $repeater as $row ) :

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

                            if($row['done']){
                                $statusClass = 'has-green-background-color';
                            } else {
                                $statusClass = "";
                            }
                            echo '<tr class="'. $class .' ' . $statusClass . '">';
                                    $rowNumber++;
                                    echo '<td>'. $row['to_do_name'] .'<p>' . $row['notes'] .'</p></td>' ;
                                    echo '<td><p>'. ($row['due_date'] =="" ? "" : DateTime::createFromFormat('Ymd', $row['due_date'])->format('d M Y')) .'</p></td>';
                                    echo '<td>'. ($row['budget']=="" ? '' : '&pound;' . '<span class="budget">' . $row['budget']) . '</span>' .'</td>';
                                    echo '<td class="done"><input type="checkbox" name="" id="status-'. $rowNumber .'" ' . ($row['done'] ? 'checked' : '') . '> <a id="remove-'.$rowNumber.'" onclick="removeTodo('. $rowNumber .')" class="removeItem">Remove</a></td>';
                                    echo '</tr>';
                        endforeach;
                        echo "<tr class='budgetLine'>
                            <td colspan='2' ><strong>Total : </strong></td>
                            <td><strong id='total-budget'></strong></td>
                            <td></td>
                            </tr>";
                     ?>
                    </table>
                        <script>
                        function removeTodo(row){
                            console.log(row)
                            jQuery(`#remove-${row}`).text('Removing')
                            jQuery('.overlay').css('display','flex');
                            jQuery.ajax({
                                url: fmw_ajax.ajaxurl,
                                method: 'POST',
                                data: {action: 'removeTodo', rowToRemove: row},
                                success: function(res){
                                    location.reload();
                                }
                            })
                        }


                        jQuery(document).ready((e) => {

                            var totalBudget = 0;
                            jQuery('.budget').each(function(index){
                                totalBudget += parseFloat(jQuery(this).text())
                                jQuery('#total-budget').text('£ ' + totalBudget.toFixed(2))
                            })

                            jQuery('input[type=checkbox]').on('change', (e) => {
                                var rowToUpdate = parseInt(e.currentTarget.id.split('-')[1]);
                                var status = e.currentTarget.checked

                                if(status){ jQuery(e.currentTarget).closest('tr').addClass('has-green-background-color') }else{ jQuery(e.currentTarget).closest('tr').removeClass('has-green-background-color') }

                                jQuery.ajax({
                                    url: fmw_ajax.ajaxurl,
                                    method: 'POST',
                                    data: {action: 'updateTodoStatus', data: {rowToUpdate: rowToUpdate, status: status}},
                                    success: function(res){
                                        console.log(res)
                                    }
                                })
                            })
                        })
                        </script>

                    
                </div>

                <div class="g_grid_4">
                    <form id="add-todo">
                        <label for="todo-title">To Do</label>
                        <input type="text" name="todo-title" id="todo-title" required>

                        <label for="todo-notes">Notes</label>
                        <input type="text" name="todo-notes" id="todo-notes">

                        <label for="todo-due">Due Date</label>
                        <input type="date" name="todo-due" id="todo-due">

                        <label for="todo-budget">Budget</label>
                        <input type="number" step="0.01" value="0" name="todo-budget" id="todo-budget">

                        <input type="submit" value="Save">
                    </form>
                </div>


                <script>

                    jQuery(document).ready((e) => {
                        jQuery('#add-todo').on('submit', (e) => {
                            e.preventDefault();
                            console.log(fmw_ajax.ajaxurl)
                            jQuery('.overlay').css('display','flex');
                            var todoTitle = jQuery('#todo-title').val()
                            var todoNotes = jQuery('#todo-notes').val()
                            var todoDue = jQuery('#todo-due').val()
                            var todoBudget = jQuery('#todo-budget').val()
                            jQuery.ajax({
                                url: fmw_ajax.ajaxurl,
                                method: 'POST',
                                data: {action: 'addTodo', data: {todoTitle:todoTitle, todoNotes:todoNotes, todoDue:todoDue, todoBudget:todoBudget}},
                                success: function(res){
                                    console.log(res)
                                    location.reload()
                                }
                            })
                        })
                    })

                </script>

        
            </div>
        
    <?php }else{
        echo "You don't have permission to access this page.";
    }?>

<?php }else{
    include THEME_DIR . '/parts/couple-registration-form.php'; 
} ?>

</div>

<?php Embers_Utilities::get_template_parts( array( 'parts/footer','parts/html-footer' ) ); ?>