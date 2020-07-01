<?php

class Builder_Admin {

    /**
     * Constructor
     */
    public function __construct( ) {
        add_action( 'init', array( $this, 'admin_pages' ) );

//        add_action('init', array( $this, 'register_acf_fields') );
    }


    /**
     *	admin_pages()
     *
     *	@since 1.0.0
     */
    public static function admin_pages() {
        if( function_exists('acf_add_options_page') ) {

             acf_add_options_page( array(
                'page_title'    => 'Hello Builder',
                'menu_title'    => 'Hello Builder',
                'menu_slug'     => 'hello_builder',
                'capability'    => 'edit_posts',
                'redirect'  	=> false
            ) );
        }
    }

}