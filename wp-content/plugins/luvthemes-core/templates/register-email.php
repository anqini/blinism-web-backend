<?php
/**
 * New account email
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<p><?php printf( esc_html__( "You successfully registered on %s:", 'fevr' ), esc_html( $blogname ) ); ?></p>
<p><?php echo esc_html__( "Password: ", 'fevr' )?> <?php echo esc_html( $info['password']  ); ?></p>
