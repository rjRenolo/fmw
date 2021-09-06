<?php

//Get only the approved comments
$comment_entries = get_comments(array( 'type'=> 'comment', 'post_id' => $post->ID ));
			
			if(!empty($comment_entries)){
			
		 	?>
			<ol class="commentlist" id="comments">
				<?php
					wp_list_comments( array( 'type'=> 'comment', 'callback' => 'message_reply' ) );
				?>
			</ol>
			<?php }


function message_reply($comment, $args, $depth){
    $GLOBALS['comment'] = $comment;

    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">

        <div id="comment-<?php comment_ID(); ?>">
        <article>
            <div class="gravatar">
                <?php
                //display the gravatar
                $gravatar_alt = esc_html(get_comment_author());
                echo get_avatar($comment,'60', '', $gravatar_alt); ?>
            </div>

            <!-- display the comment -->
            <div class='comment_content'>
                <header class="comment-header">
                    <?php
                    $author = '<cite class="comment_author_name">'.get_comment_author().'</cite>';
                    $link = get_comment_author_url();
                    $authorEmail = get_comment_author_email();
                    $user = get_user_by('email', $authorEmail);
                    $saysWho = get_the_title($user->user_page_id);
                    if(!empty($link))
                        $author = '<a rel="nofollow" href="'.$link.'" >'.$author.'</a>';

                    printf('<cite class="author_name heading">%s</cite> <span class="says">%s</span>', $saysWho, _e( 'says: ', 'mydomain' )) ?>
                    <?php edit_comment_link(__('(Edit)','avia_framework'),'  ','') ?>

                    <!-- display the comment metadata like time and date-->
                        <div class="comment-meta commentmetadata">
                            <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
                                <time <?php /* avia_markup_helper(array('context' => 'comment_time'));*/ ?> >
                                    <?php printf(__('%1$s at %2$s','avia_framework'), get_comment_date(),  get_comment_time()) ?>
                                </time>
                            </a>
                        </div>
                </header>

                <!-- display the comment text -->
                <div class='comment_text entry-content-wrapper clearfix' <?php /* avia_markup_helper(array('context' => 'comment_text')); */ ?>>
                <?php comment_text();?>
                <!-- < ?php
                    $attach = wp_get_attachment_url(get_comment_meta(get_comment_ID(), 'support_attachment', true));
                    if($attach){
                        echo '<a target="_blank" href="'.$attach.'" style="text-decoration:underline;">See attachment</a> <br/>';
                    }else{
                        echo 'No file attachment.';
                    }
                ?> -->
                <?php if ($comment->comment_approved == '0') : ?>
                <?php endif; ?>
                <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                </div>
            </div>

        </article>
    </div>
<?php }

$fields =  array(
    'author' =>
        '<input name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .'" size="30" placeholder="'.__('Your name','text-domain').( $req ? ' (Required)' : '' ).'"/>',
    'email' =>
        '<input name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .'" size="30" placeholder="'.__('Your email','text-domain').( $req ? ' (Required)' : '' ).'"/>',
);
$args = array(
    'id_form'           => 'commentform',
    'class_form'        => 'comment-form',
    'id_submit'         => 'submit',
    'class_submit'      => 'submit',
    'name_submit'       => 'submit',
    'submit_button'     => '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />',
    'title_reply'       => '',
    'title_reply_to'    => __( 'Reply to %s','text-domain' ),
    'cancel_reply_link' => __( 'Cancel comment','text-domain' ),
    'label_submit'      => __( 'Post reply','text-domain' ),
    'format'            => 'xhtml',
    'comment_field'     =>  '<textarea id="comment" name="comment" placeholder="'.__('Message','text-domain').'" cols="45" rows="8" aria-required="true">' .'</textarea>',
    'logged_in_as'      => '<p class="logged-in-as"></p>',
    'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published.','text-domain' ) .'</p>',
    'fields'            => apply_filters( 'comment_form_default_fields', $fields ),
);

comment_form( $args );

function move_comment_field_to_bottom( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
}

add_filter( 'comment_form_fields', 'move_comment_field_to_bottom' );