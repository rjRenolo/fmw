<?php

function package_post_type() {
    $labels = array( 
		'name' => _x('Subscription Package', 
		'post type general name'), 
		'singular_name' => _x('package', 
		'post type singular name'),
		'not_found' => __('Nothing found'), 
		'not_found_in_trash' => __('Nothing found in Trash'), 
		'parent_item_colon' => '' ); 
		  
		$args = array( 'labels' => $labels, 
		'public' => true, 
		'publicly_queryable' => true, 
		'show_ui' => false, 
		'query_var' => true,  
		'rewrite' => true, 
		'capability_type' => 'post', 
		'hierarchical' => false, 
		'menu_position' => null,
		'show_in_rest' => true,
		'menu_icon'   => 'dashicons-store',
        'supports' => array('title') ,
        );   
        register_post_type( 'package' , $args ); 
}
add_action('init', 'package_post_type');
