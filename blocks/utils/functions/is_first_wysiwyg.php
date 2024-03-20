<?php
function get_first_wysiwyg_id() {
    $post = get_post(); 

    if ( has_blocks( $post->post_content ) ) {
        $blocks = parse_blocks( $post->post_content );

        foreach ( $blocks as $key => $block ) {
        	if ( 'butler/wysiwyg' == $block['blockName'] ) {
        		$first_wysiwyg_attrs[$key] = $blocks[$key]['attrs'];
        	}
        }

        if ( null == $first_wysiwyg_attrs ) {
            return;
        }

        $first_element = reset( $first_wysiwyg_attrs );
        
        if ( array_key_exists( 'id', $first_element ) ) {
            return $first_element['id'];
        }
    }
}