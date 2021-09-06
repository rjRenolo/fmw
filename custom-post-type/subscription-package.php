<?php

function listing_post_type() {
    $labels = array( 
		'name' => _x('Listings', 
		'post type general name'), 
		'singular_name' => _x('listing', 
		'post type singular name'),
		'not_found' => __('Nothing found'), 
		'not_found_in_trash' => __('Nothing found in Trash'), 
		'parent_item_colon' => '' ); 
		  
		$args = array( 'labels' => $labels, 
		'public' => true, 
		'publicly_queryable' => true, 
		'show_ui' => true, 
		'query_var' => true,  
		'rewrite' => true, 
		'capability_type' => 'post', 
		'hierarchical' => false, 
		'menu_position' => null,
		'show_in_rest' => true,
		'menu_icon'   => 'dashicons-store',
        'supports' => array('title') ,
        );   
        register_post_type( 'listing' , $args ); 
}
add_action('init', 'listing_post_type');

register_taxonomy("listing-location", array("listing"), array("hierarchical" => true, "label" => "Location", "singular_label" => "Location", "rewrite" => true));

register_taxonomy("listing-category", array("listing"), array("hierarchical" => true, "label" => "Category", "singular_label" => "Category", "rewrite" => true));
