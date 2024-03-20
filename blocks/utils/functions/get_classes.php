<?php

function get_classes ( $classes, $block ): string {

    $top_margin = false;
    $bottom_margin = false;

    if ( get_field( 'top_spacing' ) != null) {
        $top_margin = get_field( 'top_spacing' );
    }
    if ( get_field( 'bottom_spacing' ) != null) {
        $bottom_margin = get_field( 'bottom_spacing' );
    }
    if ( gettype( $classes ) == 'string' ) {
        $classes = array( $classes );
    }
    if ( ! empty( $block['className'] ) ) {
        $classes = array_merge( $classes, explode( ' ', $block['className'] ) );
    }
    if ( ! empty( $block['align'] ) ) {
        $classes[] = 'align' . $block['align'];
    }
    if ( ! empty( $block['backgroundColor'] ) ) {
        $classes[] = 'has-background';
        $classes[] = 'has-' . $block['backgroundColor'] . '-background-color';
    }
    if ( ! empty( $block['textColor'] ) ) {
        $classes[] = 'has-text-color';
        $classes[] = 'has-' . $block['textColor'] . '-color';
    }
    if ( $top_margin ) {
        $classes[] = 'has-top-spacing';
    }
    if ( $bottom_margin ) {
        $classes[] = 'has-bottom-spacing';
    }

    return esc_attr( join( ' ', $classes ) );
}

?>
