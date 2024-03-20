<?php
add_action( 'wp_enqueue_scripts', 'load_assets' );
function load_assets() {
	wp_register_style( 'slick-styles', plugins_url( 'slick-1.8.1/slick/slick.css', __FILE__ ) );
	wp_register_script( 'slick-carousel', plugins_url( 'slick-1.8.1/slick/slick.min.js', __FILE__ ) );

	wp_enqueue_style( 'slick-styles' );
	wp_enqueue_script( 'slick-carousel' );
}
