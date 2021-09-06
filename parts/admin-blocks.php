<?php 

// ****************************
// Blocks created for Gutenberg
// ****************************

// *************
//Pricing
//**************

add_action('acf/init', 'pricing_acf_init');
function pricing_acf_init() {
	
	// check function exists
	if( function_exists('acf_register_block') ) {
		
		// register a testimonial block
		acf_register_block(array(
			'name'				=> 'pricing',
			'title'				=> __('Pricing Block'),
			'description'		=> __(''),
			'render_callback'	=> 'pricing_block_render_callback',
			'category'			=> 'layout',
			'icon'				=> '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
			width="675.257px" height="322px" viewBox="0 0 675.257 322" enable-background="new 0 0 675.257 322" xml:space="preserve">
		   <polygon fill="#F58023" points="320.016,324 482.25,-2 6.646,-2 14.974,324 "/>
		   <polygon fill="#455560" points="670.364,324 672.635,-2 493.612,-2 336.889,324 "/>
		   <path fill="#FFFFFF" d="M675.257,324V-2H0v326H675.257z M670.843,260.225c0,30.46-24.693,55.154-55.154,55.154
			   s-55.154-24.694-55.154-55.154c0-30.462,24.693-55.155,55.154-55.155S670.843,229.763,670.843,260.225z M571.615,10.136l5.629,2.811
			   c25.135,12.554,35.508,42.757,23.168,67.462L496.771,287.925c-12.338,24.705-42.715,34.557-67.85,22.003l-5.629-2.811
			   c-25.135-12.553-35.507-42.756-23.168-67.461L503.765,32.14C516.103,7.435,546.48-2.417,571.615,10.136z M409.882,10.136
			   l5.629,2.811c25.135,12.554,35.508,42.757,23.168,67.462L335.039,287.925c-12.338,24.705-42.715,34.557-67.849,22.003l-5.63-2.811
			   c-25.134-12.553-35.506-42.756-23.168-67.461L342.033,32.14C354.371,7.435,384.748-2.417,409.882,10.136z M250.005,10.136
			   l5.63,2.811c25.134,12.554,35.506,42.757,23.168,67.462L175.162,287.925c-12.338,24.705-42.715,34.557-67.849,22.003l-5.63-2.811
			   c-25.134-12.553-35.506-42.756-23.168-67.461L182.157,32.14C194.495,7.435,224.872-2.417,250.005,10.136z M65.494,4.682
			   c30.461,0,55.154,24.693,55.154,55.156c0,30.459-24.693,55.154-55.154,55.154c-30.461,0-55.155-24.695-55.155-55.154
			   C10.339,29.375,35.032,4.682,65.494,4.682z"/>
		   </svg>'
		));
	}
}

function pricing_block_render_callback( $block ) {
	
	// convert name ("acf/testimonial") into path friendly slug ("testimonial")
	$slug = str_replace('acf/', '', $block['name']);
	
	// include a template part from within the "parts/block" folder
	if( file_exists( get_theme_file_path("/parts/blocks/content-{$slug}.php") ) ) {
		include( get_theme_file_path("/parts/blocks/content-{$slug}.php") );
	}

}

// *************
// Business Sign up
//**************

add_action('acf/init', 'businesssignup_acf_init');
function businesssignup_acf_init() {
	
	// check function exists
	if( function_exists('acf_register_block') ) {
		
		// register a testimonial block
		acf_register_block(array(
			'name'				=> 'businesssignup',
			'title'				=> __('FMW Business Sign Up Form'),
			'description'		=> __(''),
			'render_callback'	=> 'businesssignup_block_render_callback',
			'category'			=> 'layout',
			'icon'				=> '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
			width="675.257px" height="322px" viewBox="0 0 675.257 322" enable-background="new 0 0 675.257 322" xml:space="preserve">
		   <polygon fill="#F58023" points="320.016,324 482.25,-2 6.646,-2 14.974,324 "/>
		   <polygon fill="#455560" points="670.364,324 672.635,-2 493.612,-2 336.889,324 "/>
		   <path fill="#FFFFFF" d="M675.257,324V-2H0v326H675.257z M670.843,260.225c0,30.46-24.693,55.154-55.154,55.154
			   s-55.154-24.694-55.154-55.154c0-30.462,24.693-55.155,55.154-55.155S670.843,229.763,670.843,260.225z M571.615,10.136l5.629,2.811
			   c25.135,12.554,35.508,42.757,23.168,67.462L496.771,287.925c-12.338,24.705-42.715,34.557-67.85,22.003l-5.629-2.811
			   c-25.135-12.553-35.507-42.756-23.168-67.461L503.765,32.14C516.103,7.435,546.48-2.417,571.615,10.136z M409.882,10.136
			   l5.629,2.811c25.135,12.554,35.508,42.757,23.168,67.462L335.039,287.925c-12.338,24.705-42.715,34.557-67.849,22.003l-5.63-2.811
			   c-25.134-12.553-35.506-42.756-23.168-67.461L342.033,32.14C354.371,7.435,384.748-2.417,409.882,10.136z M250.005,10.136
			   l5.63,2.811c25.134,12.554,35.506,42.757,23.168,67.462L175.162,287.925c-12.338,24.705-42.715,34.557-67.849,22.003l-5.63-2.811
			   c-25.134-12.553-35.506-42.756-23.168-67.461L182.157,32.14C194.495,7.435,224.872-2.417,250.005,10.136z M65.494,4.682
			   c30.461,0,55.154,24.693,55.154,55.156c0,30.459-24.693,55.154-55.154,55.154c-30.461,0-55.155-24.695-55.155-55.154
			   C10.339,29.375,35.032,4.682,65.494,4.682z"/>
		   </svg>'
		));
	}
}

function businesssignup_block_render_callback( $block ) {
	
	// convert name ("acf/testimonial") into path friendly slug ("testimonial")
	$slug = str_replace('acf/', '', $block['name']);
	
	// include a template part from within the "parts/block" folder
	if( file_exists( get_theme_file_path("/parts/blocks/content-{$slug}.php") ) ) {
		include( get_theme_file_path("/parts/blocks/content-{$slug}.php") );
	}
}


// *************
// Couple Sign up
//**************

add_action('acf/init', 'couplesignup_acf_init');
function couplesignup_acf_init() {
	
	// check function exists
	if( function_exists('acf_register_block') ) {
		
		// register a testimonial block
		acf_register_block(array(
			'name'				=> 'couplesignup',
			'title'				=> __('FMW Couples Sign Up Form'),
			'description'		=> __(''),
			'render_callback'	=> 'couplesignup_block_render_callback',
			'category'			=> 'layout',
			'icon'				=> '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
			width="675.257px" height="322px" viewBox="0 0 675.257 322" enable-background="new 0 0 675.257 322" xml:space="preserve">
		   <polygon fill="#F58023" points="320.016,324 482.25,-2 6.646,-2 14.974,324 "/>
		   <polygon fill="#455560" points="670.364,324 672.635,-2 493.612,-2 336.889,324 "/>
		   <path fill="#FFFFFF" d="M675.257,324V-2H0v326H675.257z M670.843,260.225c0,30.46-24.693,55.154-55.154,55.154
			   s-55.154-24.694-55.154-55.154c0-30.462,24.693-55.155,55.154-55.155S670.843,229.763,670.843,260.225z M571.615,10.136l5.629,2.811
			   c25.135,12.554,35.508,42.757,23.168,67.462L496.771,287.925c-12.338,24.705-42.715,34.557-67.85,22.003l-5.629-2.811
			   c-25.135-12.553-35.507-42.756-23.168-67.461L503.765,32.14C516.103,7.435,546.48-2.417,571.615,10.136z M409.882,10.136
			   l5.629,2.811c25.135,12.554,35.508,42.757,23.168,67.462L335.039,287.925c-12.338,24.705-42.715,34.557-67.849,22.003l-5.63-2.811
			   c-25.134-12.553-35.506-42.756-23.168-67.461L342.033,32.14C354.371,7.435,384.748-2.417,409.882,10.136z M250.005,10.136
			   l5.63,2.811c25.134,12.554,35.506,42.757,23.168,67.462L175.162,287.925c-12.338,24.705-42.715,34.557-67.849,22.003l-5.63-2.811
			   c-25.134-12.553-35.506-42.756-23.168-67.461L182.157,32.14C194.495,7.435,224.872-2.417,250.005,10.136z M65.494,4.682
			   c30.461,0,55.154,24.693,55.154,55.156c0,30.459-24.693,55.154-55.154,55.154c-30.461,0-55.155-24.695-55.155-55.154
			   C10.339,29.375,35.032,4.682,65.494,4.682z"/>
		   </svg>'
		));
	}
}

function couplesignup_block_render_callback( $block ) {
	
	// convert name ("acf/testimonial") into path friendly slug ("testimonial")
	$slug = str_replace('acf/', '', $block['name']);
	
	// include a template part from within the "parts/block" folder
	if( file_exists( get_theme_file_path("/parts/blocks/content-{$slug}.php") ) ) {
		include( get_theme_file_path("/parts/blocks/content-{$slug}.php") );
	}
}




/////////////////////
// Search Form //
/////////////////////

add_action('acf/init', 'fmwsearch_acf_init');
function fmwsearch_acf_init() {
	// check function exists
	if( function_exists('acf_register_block') ) {
		
		// register a testimonial block
		acf_register_block(array(
			'name'				=> 'fmwsearch',
			'title'				=> __('FMW Search Form'),
			'description'		=> __(''),
			'render_callback'	=> 'fmwsearch_block_render_callback',
			'category'			=> 'layout',
			'className'			=> '',
			'icon'				=> '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
			width="675.257px" height="322px" viewBox="0 0 675.257 322" enable-background="new 0 0 675.257 322" xml:space="preserve">
		   <polygon fill="#F58023" points="320.016,324 482.25,-2 6.646,-2 14.974,324 "/>
		   <polygon fill="#455560" points="670.364,324 672.635,-2 493.612,-2 336.889,324 "/>
		   <path fill="#FFFFFF" d="M675.257,324V-2H0v326H675.257z M670.843,260.225c0,30.46-24.693,55.154-55.154,55.154
			   s-55.154-24.694-55.154-55.154c0-30.462,24.693-55.155,55.154-55.155S670.843,229.763,670.843,260.225z M571.615,10.136l5.629,2.811
			   c25.135,12.554,35.508,42.757,23.168,67.462L496.771,287.925c-12.338,24.705-42.715,34.557-67.85,22.003l-5.629-2.811
			   c-25.135-12.553-35.507-42.756-23.168-67.461L503.765,32.14C516.103,7.435,546.48-2.417,571.615,10.136z M409.882,10.136
			   l5.629,2.811c25.135,12.554,35.508,42.757,23.168,67.462L335.039,287.925c-12.338,24.705-42.715,34.557-67.849,22.003l-5.63-2.811
			   c-25.134-12.553-35.506-42.756-23.168-67.461L342.033,32.14C354.371,7.435,384.748-2.417,409.882,10.136z M250.005,10.136
			   l5.63,2.811c25.134,12.554,35.506,42.757,23.168,67.462L175.162,287.925c-12.338,24.705-42.715,34.557-67.849,22.003l-5.63-2.811
			   c-25.134-12.553-35.506-42.756-23.168-67.461L182.157,32.14C194.495,7.435,224.872-2.417,250.005,10.136z M65.494,4.682
			   c30.461,0,55.154,24.693,55.154,55.156c0,30.459-24.693,55.154-55.154,55.154c-30.461,0-55.155-24.695-55.155-55.154
			   C10.339,29.375,35.032,4.682,65.494,4.682z"/>
		   </svg>'
		));
	}
}

function fmwsearch_block_render_callback( $block ) {
	
	// convert name ("acf/testimonial") into path friendly slug ("testimonial")
	$slug = str_replace('acf/', '', $block['name']);
	
	// include a template part from within the "parts/block" folder
	if( file_exists( get_theme_file_path("/parts/blocks/content-{$slug}.php") ) ) {
		include( get_theme_file_path("/parts/blocks/content-{$slug}.php") );
	}

}

add_action('acf/init', 'fmwsearchvenue_acf_init');
function fmwsearchvenue_acf_init() {
	// check function exists
	if( function_exists('acf_register_block') ) {
		
		// register a testimonial block
		acf_register_block(array(
			'name'				=> 'fmwsearchvenue',
			'title'				=> __('FMW Venue Search Form'),
			'description'		=> __(''),
			'render_callback'	=> 'fmwsearchvenue_block_render_callback',
			'category'			=> 'layout',
			'className'			=> '',
			'icon'				=> '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
			width="675.257px" height="322px" viewBox="0 0 675.257 322" enable-background="new 0 0 675.257 322" xml:space="preserve">
		   <polygon fill="#F58023" points="320.016,324 482.25,-2 6.646,-2 14.974,324 "/>
		   <polygon fill="#455560" points="670.364,324 672.635,-2 493.612,-2 336.889,324 "/>
		   <path fill="#FFFFFF" d="M675.257,324V-2H0v326H675.257z M670.843,260.225c0,30.46-24.693,55.154-55.154,55.154
			   s-55.154-24.694-55.154-55.154c0-30.462,24.693-55.155,55.154-55.155S670.843,229.763,670.843,260.225z M571.615,10.136l5.629,2.811
			   c25.135,12.554,35.508,42.757,23.168,67.462L496.771,287.925c-12.338,24.705-42.715,34.557-67.85,22.003l-5.629-2.811
			   c-25.135-12.553-35.507-42.756-23.168-67.461L503.765,32.14C516.103,7.435,546.48-2.417,571.615,10.136z M409.882,10.136
			   l5.629,2.811c25.135,12.554,35.508,42.757,23.168,67.462L335.039,287.925c-12.338,24.705-42.715,34.557-67.849,22.003l-5.63-2.811
			   c-25.134-12.553-35.506-42.756-23.168-67.461L342.033,32.14C354.371,7.435,384.748-2.417,409.882,10.136z M250.005,10.136
			   l5.63,2.811c25.134,12.554,35.506,42.757,23.168,67.462L175.162,287.925c-12.338,24.705-42.715,34.557-67.849,22.003l-5.63-2.811
			   c-25.134-12.553-35.506-42.756-23.168-67.461L182.157,32.14C194.495,7.435,224.872-2.417,250.005,10.136z M65.494,4.682
			   c30.461,0,55.154,24.693,55.154,55.156c0,30.459-24.693,55.154-55.154,55.154c-30.461,0-55.155-24.695-55.155-55.154
			   C10.339,29.375,35.032,4.682,65.494,4.682z"/>
		   </svg>'
		));
	}
}

function fmwsearchvenue_block_render_callback( $block ) {
	
	// convert name ("acf/testimonial") into path friendly slug ("testimonial")
	$slug = str_replace('acf/', '', $block['name']);
	
	// include a template part from within the "parts/block" folder
	if( file_exists( get_theme_file_path("/parts/blocks/content-{$slug}.php") ) ) {
		include( get_theme_file_path("/parts/blocks/content-{$slug}.php") );
	}

}



///////////////////////////
// Icon With Description //
///////////////////////////

add_action('acf/init', 'fmwiconwithdescription');
function fmwiconwithdescription() {
	// check function exists
	if( function_exists('acf_register_block') ) {
		
		// register a testimonial block
		acf_register_block(array(
			'name'				=> 'fmwiconwithdescription',
			'title'				=> __('FMW Icon With Description'),
			'description'		=> __(''),
			'render_callback'	=> 'fmwIWD_block_render_callback',
			'category'			=> 'layout',
			'className'			=> '',
			'icon'				=> '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
			width="675.257px" height="322px" viewBox="0 0 675.257 322" enable-background="new 0 0 675.257 322" xml:space="preserve">
		   <polygon fill="#F58023" points="320.016,324 482.25,-2 6.646,-2 14.974,324 "/>
		   <polygon fill="#455560" points="670.364,324 672.635,-2 493.612,-2 336.889,324 "/>
		   <path fill="#FFFFFF" d="M675.257,324V-2H0v326H675.257z M670.843,260.225c0,30.46-24.693,55.154-55.154,55.154
			   s-55.154-24.694-55.154-55.154c0-30.462,24.693-55.155,55.154-55.155S670.843,229.763,670.843,260.225z M571.615,10.136l5.629,2.811
			   c25.135,12.554,35.508,42.757,23.168,67.462L496.771,287.925c-12.338,24.705-42.715,34.557-67.85,22.003l-5.629-2.811
			   c-25.135-12.553-35.507-42.756-23.168-67.461L503.765,32.14C516.103,7.435,546.48-2.417,571.615,10.136z M409.882,10.136
			   l5.629,2.811c25.135,12.554,35.508,42.757,23.168,67.462L335.039,287.925c-12.338,24.705-42.715,34.557-67.849,22.003l-5.63-2.811
			   c-25.134-12.553-35.506-42.756-23.168-67.461L342.033,32.14C354.371,7.435,384.748-2.417,409.882,10.136z M250.005,10.136
			   l5.63,2.811c25.134,12.554,35.506,42.757,23.168,67.462L175.162,287.925c-12.338,24.705-42.715,34.557-67.849,22.003l-5.63-2.811
			   c-25.134-12.553-35.506-42.756-23.168-67.461L182.157,32.14C194.495,7.435,224.872-2.417,250.005,10.136z M65.494,4.682
			   c30.461,0,55.154,24.693,55.154,55.156c0,30.459-24.693,55.154-55.154,55.154c-30.461,0-55.155-24.695-55.155-55.154
			   C10.339,29.375,35.032,4.682,65.494,4.682z"/>
		   </svg>'
		));
	}
}

function fmwIWD_block_render_callback( $block ) {
	
	// convert name ("acf/testimonial") into path friendly slug ("testimonial")
	$slug = str_replace('acf/', '', $block['name']);
	
	// include a template part from within the "parts/block" folder
	if( file_exists( get_theme_file_path("/parts/blocks/content-{$slug}.php") ) ) {
		include( get_theme_file_path("/parts/blocks/content-{$slug}.php") );
	}

}





////////////////////////
// Featured Suppliers //
////////////////////////
add_action('acf/init', 'fmwfeatsuppliers');
function fmwfeatsuppliers() {
	// check function exists
	if( function_exists('acf_register_block') ) {
		
		// register a testimonial block
		acf_register_block(array(
			'name'				=> 'fmwfeatsuppliers',
			'title'				=> __('FMW Features Suppliers'),
			'description'		=> __(''),
			'render_callback'	=> 'fmwFS_block_render_callback',
			'category'			=> 'layout',
			'className'			=> '',
			'icon'				=> '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
			width="675.257px" height="322px" viewBox="0 0 675.257 322" enable-background="new 0 0 675.257 322" xml:space="preserve">
		   <polygon fill="#F58023" points="320.016,324 482.25,-2 6.646,-2 14.974,324 "/>
		   <polygon fill="#455560" points="670.364,324 672.635,-2 493.612,-2 336.889,324 "/>
		   <path fill="#FFFFFF" d="M675.257,324V-2H0v326H675.257z M670.843,260.225c0,30.46-24.693,55.154-55.154,55.154
			   s-55.154-24.694-55.154-55.154c0-30.462,24.693-55.155,55.154-55.155S670.843,229.763,670.843,260.225z M571.615,10.136l5.629,2.811
			   c25.135,12.554,35.508,42.757,23.168,67.462L496.771,287.925c-12.338,24.705-42.715,34.557-67.85,22.003l-5.629-2.811
			   c-25.135-12.553-35.507-42.756-23.168-67.461L503.765,32.14C516.103,7.435,546.48-2.417,571.615,10.136z M409.882,10.136
			   l5.629,2.811c25.135,12.554,35.508,42.757,23.168,67.462L335.039,287.925c-12.338,24.705-42.715,34.557-67.849,22.003l-5.63-2.811
			   c-25.134-12.553-35.506-42.756-23.168-67.461L342.033,32.14C354.371,7.435,384.748-2.417,409.882,10.136z M250.005,10.136
			   l5.63,2.811c25.134,12.554,35.506,42.757,23.168,67.462L175.162,287.925c-12.338,24.705-42.715,34.557-67.849,22.003l-5.63-2.811
			   c-25.134-12.553-35.506-42.756-23.168-67.461L182.157,32.14C194.495,7.435,224.872-2.417,250.005,10.136z M65.494,4.682
			   c30.461,0,55.154,24.693,55.154,55.156c0,30.459-24.693,55.154-55.154,55.154c-30.461,0-55.155-24.695-55.155-55.154
			   C10.339,29.375,35.032,4.682,65.494,4.682z"/>
		   </svg>'
		));
	}
}

function fmwFS_block_render_callback( $block ) {
	
	// convert name ("acf/testimonial") into path friendly slug ("testimonial")
	$slug = str_replace('acf/', '', $block['name']);
	
	// include a template part from within the "parts/block" folder
	if( file_exists( get_theme_file_path("/parts/blocks/content-{$slug}.php") ) ) {
		include( get_theme_file_path("/parts/blocks/content-{$slug}.php") );
	}

}





/////////////////////////////
// Before Footer Promotion //
/////////////////////////////
add_action('acf/init', 'fmwbeforefooterpromotion');
function fmwbeforefooterpromotion() {
	// check function exists
	if( function_exists('acf_register_block') ) {
		
		// register a testimonial block
		acf_register_block(array(
			'name'				=> 'fmwbeforefooterpromotion',
			'title'				=> __('FMW Before Footer Promotion'),
			'description'		=> __(''),
			'render_callback'	=> 'fmwBFP_block_render_callback',
			'category'			=> 'layout',
			'className'			=> '',
			'icon'				=> '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
			width="675.257px" height="322px" viewBox="0 0 675.257 322" enable-background="new 0 0 675.257 322" xml:space="preserve">
		   <polygon fill="#F58023" points="320.016,324 482.25,-2 6.646,-2 14.974,324 "/>
		   <polygon fill="#455560" points="670.364,324 672.635,-2 493.612,-2 336.889,324 "/>
		   <path fill="#FFFFFF" d="M675.257,324V-2H0v326H675.257z M670.843,260.225c0,30.46-24.693,55.154-55.154,55.154
			   s-55.154-24.694-55.154-55.154c0-30.462,24.693-55.155,55.154-55.155S670.843,229.763,670.843,260.225z M571.615,10.136l5.629,2.811
			   c25.135,12.554,35.508,42.757,23.168,67.462L496.771,287.925c-12.338,24.705-42.715,34.557-67.85,22.003l-5.629-2.811
			   c-25.135-12.553-35.507-42.756-23.168-67.461L503.765,32.14C516.103,7.435,546.48-2.417,571.615,10.136z M409.882,10.136
			   l5.629,2.811c25.135,12.554,35.508,42.757,23.168,67.462L335.039,287.925c-12.338,24.705-42.715,34.557-67.849,22.003l-5.63-2.811
			   c-25.134-12.553-35.506-42.756-23.168-67.461L342.033,32.14C354.371,7.435,384.748-2.417,409.882,10.136z M250.005,10.136
			   l5.63,2.811c25.134,12.554,35.506,42.757,23.168,67.462L175.162,287.925c-12.338,24.705-42.715,34.557-67.849,22.003l-5.63-2.811
			   c-25.134-12.553-35.506-42.756-23.168-67.461L182.157,32.14C194.495,7.435,224.872-2.417,250.005,10.136z M65.494,4.682
			   c30.461,0,55.154,24.693,55.154,55.156c0,30.459-24.693,55.154-55.154,55.154c-30.461,0-55.155-24.695-55.155-55.154
			   C10.339,29.375,35.032,4.682,65.494,4.682z"/>
		   </svg>'
		));
	}
}

function fmwBFP_block_render_callback( $block ) {
	
	// convert name ("acf/testimonial") into path friendly slug ("testimonial")
	$slug = str_replace('acf/', '', $block['name']);
	
	// include a template part from within the "parts/block" folder
	if( file_exists( get_theme_file_path("/parts/before-footer-promotion.php") ) ) {
		include( get_theme_file_path("/parts/before-footer-promotion.php") );
	}

}


/////////////////
// Log in form //
/////////////////
add_action('acf/init', 'fmwloginform');
function fmwloginform(){
	if( function_exists('acf_register_block') ) {
		
		// register a testimonial block
		acf_register_block(array(
			'name'				=> 'fmwloginform',
			'title'				=> __('FMW Log In FOrm'),
			'description'		=> __(''),
			'render_callback'	=> 'fmwLI_block_render_callback',
			'category'			=> 'layout',
			'className'			=> '',
			'icon'				=> '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
			width="675.257px" height="322px" viewBox="0 0 675.257 322" enable-background="new 0 0 675.257 322" xml:space="preserve">
		   <polygon fill="#F58023" points="320.016,324 482.25,-2 6.646,-2 14.974,324 "/>
		   <polygon fill="#455560" points="670.364,324 672.635,-2 493.612,-2 336.889,324 "/>
		   <path fill="#FFFFFF" d="M675.257,324V-2H0v326H675.257z M670.843,260.225c0,30.46-24.693,55.154-55.154,55.154
			   s-55.154-24.694-55.154-55.154c0-30.462,24.693-55.155,55.154-55.155S670.843,229.763,670.843,260.225z M571.615,10.136l5.629,2.811
			   c25.135,12.554,35.508,42.757,23.168,67.462L496.771,287.925c-12.338,24.705-42.715,34.557-67.85,22.003l-5.629-2.811
			   c-25.135-12.553-35.507-42.756-23.168-67.461L503.765,32.14C516.103,7.435,546.48-2.417,571.615,10.136z M409.882,10.136
			   l5.629,2.811c25.135,12.554,35.508,42.757,23.168,67.462L335.039,287.925c-12.338,24.705-42.715,34.557-67.849,22.003l-5.63-2.811
			   c-25.134-12.553-35.506-42.756-23.168-67.461L342.033,32.14C354.371,7.435,384.748-2.417,409.882,10.136z M250.005,10.136
			   l5.63,2.811c25.134,12.554,35.506,42.757,23.168,67.462L175.162,287.925c-12.338,24.705-42.715,34.557-67.849,22.003l-5.63-2.811
			   c-25.134-12.553-35.506-42.756-23.168-67.461L182.157,32.14C194.495,7.435,224.872-2.417,250.005,10.136z M65.494,4.682
			   c30.461,0,55.154,24.693,55.154,55.156c0,30.459-24.693,55.154-55.154,55.154c-30.461,0-55.155-24.695-55.155-55.154
			   C10.339,29.375,35.032,4.682,65.494,4.682z"/>
		   </svg>'
		));
	}
}
function fmwLI_block_render_callback($block){
	$slug = str_replace('acf/', '', $block['name']);
	
	// include a template part from within the "parts/block" folder
	if( file_exists( get_theme_file_path("/parts/blocks/content-loginform.php") ) ) {
		include( get_theme_file_path("/parts/blocks/content-loginform.php") );
	}
}


// *************
// Contact
//**************

add_action('acf/init', 'contact_acf_init');
function contact_acf_init() {
	
	// check function exists
	if( function_exists('acf_register_block') ) {
		
		// register a testimonial block
		acf_register_block(array(
			'name'				=> 'contact',
			'title'				=> __('FMW Contact Form'),
			'description'		=> __(''),
			'render_callback'	=> 'contact_block_render_callback',
			'category'			=> 'layout',
			'icon'				=> '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
			width="675.257px" height="322px" viewBox="0 0 675.257 322" enable-background="new 0 0 675.257 322" xml:space="preserve">
		   <polygon fill="#F58023" points="320.016,324 482.25,-2 6.646,-2 14.974,324 "/>
		   <polygon fill="#455560" points="670.364,324 672.635,-2 493.612,-2 336.889,324 "/>
		   <path fill="#FFFFFF" d="M675.257,324V-2H0v326H675.257z M670.843,260.225c0,30.46-24.693,55.154-55.154,55.154
			   s-55.154-24.694-55.154-55.154c0-30.462,24.693-55.155,55.154-55.155S670.843,229.763,670.843,260.225z M571.615,10.136l5.629,2.811
			   c25.135,12.554,35.508,42.757,23.168,67.462L496.771,287.925c-12.338,24.705-42.715,34.557-67.85,22.003l-5.629-2.811
			   c-25.135-12.553-35.507-42.756-23.168-67.461L503.765,32.14C516.103,7.435,546.48-2.417,571.615,10.136z M409.882,10.136
			   l5.629,2.811c25.135,12.554,35.508,42.757,23.168,67.462L335.039,287.925c-12.338,24.705-42.715,34.557-67.849,22.003l-5.63-2.811
			   c-25.134-12.553-35.506-42.756-23.168-67.461L342.033,32.14C354.371,7.435,384.748-2.417,409.882,10.136z M250.005,10.136
			   l5.63,2.811c25.134,12.554,35.506,42.757,23.168,67.462L175.162,287.925c-12.338,24.705-42.715,34.557-67.849,22.003l-5.63-2.811
			   c-25.134-12.553-35.506-42.756-23.168-67.461L182.157,32.14C194.495,7.435,224.872-2.417,250.005,10.136z M65.494,4.682
			   c30.461,0,55.154,24.693,55.154,55.156c0,30.459-24.693,55.154-55.154,55.154c-30.461,0-55.155-24.695-55.155-55.154
			   C10.339,29.375,35.032,4.682,65.494,4.682z"/>
		   </svg>'
		));
	}
}

function contact_block_render_callback( $block ) {
	
	// convert name ("acf/testimonial") into path friendly slug ("testimonial")
	$slug = str_replace('acf/', '', $block['name']);
	
	// include a template part from within the "parts/block" folder
	if( file_exists( get_theme_file_path("/parts/blocks/content-{$slug}.php") ) ) {
		include( get_theme_file_path("/parts/blocks/content-{$slug}.php") );
	}
}
