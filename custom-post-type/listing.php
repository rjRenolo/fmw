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

register_taxonomy("listing-license", array("listing"), array("hierarchical" => true, "label" => "Listing License", "singular_label" => "Listing License", "rewrite" => true));

register_taxonomy("listing-license-type", array("listing"), array("hierarchical" => true, "label" => "Listing License Type", "singular_label" => "Listing License Type", "rewrite" => true));


register_taxonomy("listing-capacity", array("listing"), array("hierarchical" => true, "label" => "Ceremony Guests", "singular_label" => "Ceremony Guests", "rewrite" => true));

register_taxonomy("listing-reception-capacity", array("listing"), array("hierarchical" => true, "label" => "Reception Guests", "singular_label" => "Reception Guests", "rewrite" => true));

register_taxonomy("listing-style", array("listing"), array("hierarchical" => true, "label" => "Listing Style", "singular_label" => "Listing Style", "rewrite" => true));

register_taxonomy("listing-venue-type", array("listing"), array("hierarchical" => true, "label" => "Listing Venue Type", "singular_label" => "Listing Venue Type", "rewrite" => true));

register_taxonomy("listing-features", array("listing"), array("hierarchical" => true, "label" => "Listing Feature", "singular_label" => "Listing Feature", "rewrite" => true));

register_taxonomy("listing-accommodation", array("listing"), array("hierarchical" => true, "label" => "Listing Accommodation", "singular_label" => "Listing Accommodation", "rewrite" => true));

register_taxonomy("listing-fooddrink", array("listing"), array("hierarchical" => true, "label" => "Listing Food and Drink", "singular_label" => "Listing Food and Drink", "rewrite" => true));
