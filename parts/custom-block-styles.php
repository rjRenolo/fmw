<?php 


	/**
 * Register Custom Block Styles
 */
if ( function_exists( 'register_block_style' ) ) {
    function block_styles_register_block_styles() {


        register_block_style(
            'core/paragraph',
            array(
                'name'         => 'script',
                'label'        => 'Script Font',
                'style_handle' => 'block-styles-stylesheet',
            )
        );
        register_block_style(
            'core/heading',
            array(
                'name'         => 'script',
                'label'        => 'Script Font',
                'style_handle' => 'block-styles-stylesheet',
            )
        );
        register_block_style(
            'core/cover',
            array(
                'name'         => 'narrow',
                'label'        => 'Narrow Container',
                'style_handle' => 'block-styles-stylesheet',
            )
        );
        register_block_style(
            'core/group',
            array(
                'name'         => 'narrow',
                'label'        => 'Narrow Container',
                'style_handle' => 'block-styles-stylesheet',
            )
        );

    }

    add_action( 'init', 'block_styles_register_block_styles' );
}