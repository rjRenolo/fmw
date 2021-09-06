<?php

//Get only the approved comments
$args = array(
    'status' => 'approve'
);
 
// The comment Query
$comments_query = new WP_Comment_Query;
$comments = $comments_query->query( $args );
 
// Comment Loop
if ( $comments ) {
 foreach ( array_reverse($comments) as $comment ) {
     
     echo '<pre>';
     print_r($comment);
     echo '</pre>';
     
 echo '<p>' . $comment->comment_content . '</p>';
 }
} else {
 echo 'No comments found...';
}

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