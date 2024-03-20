<?php
/**
 * Utility function to check if there's a WYSIWYG block containing a menu as the next sibling.
 */
require_once realpath( __DIR__ ) . '/is_non_empty_block.php';

function has_page_menu( $post_id = '', $block_name = '' ) {
	if ( ! empty( $post_id ) || ! empty( $block_name ) ) {
		$post_content = get_post_field( 'post_content', $post_id );
		$all_blocks = array_values( array_filter( parse_blocks( $post_content ), 'is_non_empty_block' ) );
		$current_block_key = (int) '';

		foreach ( $all_blocks as $key => $block ) {
			if ( isset( $block['attrs']['name'] ) && $block['attrs']['name'] == $block_name ) {
				$current_block_key = $key;
				break;
			}
		}
		$next_block = $all_blocks[ $current_block_key + 1 ];

		if ( $next_block && ( $next_block['blockName'] == 'acf/wysiwyg' || $next_block['blockName'] == 'butler/wysiwyg' ) ) {
			$has_menu = ! empty( $next_block['attrs']['data']['sidebar_menu'] ) ? true : false;
		} else {
			$has_menu = false;
		}
		return $has_menu;
	} else {
		return false;
	}
}
