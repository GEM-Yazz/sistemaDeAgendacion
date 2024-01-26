<?php

class BookingsOptionPage {
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
    }

    public function add_plugin_page() {
        if (current_user_can( 'manage_options' )) {
            add_menu_page(
                'Bookings',
                'Bookings',
                'manage_options',
                'bookings',
                array( $this, 'create_admin_page' ),
                'dashicons-groups',
                3
            );
        }
    }

    public function create_admin_page() {
        include_once __DIR__.'/view.php';
    }
    
}

if ( is_admin()) {
    $bookings = new BookingsOptionPage();
}
