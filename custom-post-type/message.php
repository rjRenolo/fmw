<?php


function enquiry_message_post_type() {
    $labels = array( 
		'name' => _x('Messages', 
		'post type general name'), 
		'singular_name' => _x('Message', 
		'post type singular name'),
		'not_found' => __('Nothing found'), 
		'not_found_in_trash' => __('Nothing found in Trash'), 
		'parent_item_colon' => '' ); 
		  
    $args = array( 
        'labels' => $labels, 
        'public' => true, 
        'publicly_queryable' => true, 
        'show_ui' => true, 
        'query_var' => true,  
        'rewrite' => true, 
        'capability_type' => 'post', 
        'hierarchical' => false, 
        'menu_position' => null,
        'show_in_rest' => true,
        'menu_icon'   => 'dashicons-format-chat',
        'supports' => array('title', 'editor', 'comments') ,
    );   
    register_post_type( 'message' , $args ); 
}
add_action('init', 'enquiry_message_post_type');


register_taxonomy("enquiry-type", array("message"), array("hierarchical" => true, "label" => "Enquiry Type", "singular_label" => "Enquiry Type", "rewrite" => true));