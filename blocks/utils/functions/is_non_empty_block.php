<?php
function is_non_empty_block( $block ) {
	return ! ( $block['blockName'] === null && empty( trim( $block['innerHTML'] ) ) );
}
