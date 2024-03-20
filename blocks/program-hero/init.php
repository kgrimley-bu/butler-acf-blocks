<?php

function reindex_array( &$arr ): void {
	if ( is_array( $arr ) ) {
		$arr = array_values( $arr );
	}
}

function flatten_if_array( &$arr ): void {
	if ( is_array( $arr ) ) {
		$arr = count( $arr ) === 0 ? $arr : $arr[0];
	}
}

function writeTermIfExists( $term_object ): void {
	if ( $term_object && $term_object->name ) {
		echo '<span class="program-type">' . esc_html( $term_object->name ) . '</span>';
	}
}

function writeEachTermInArray( $term_array ): void {
	foreach ( $term_array as $term_object ) {
		if ( $term_object && $term_object->name ) {
			echo '<span class="program-type">' . esc_html( $term_object->name ) . '</span>';
		}
	}
}

function transform_three_year( &$obj ): void {
	if ( $obj && '3-Year Degree' === $obj->name ) {
		$obj->name = '3YR';
	}
}

function get_term_info( $terms_array, $name_on_which_to_filter ) {
	$this_term = null;
	if ( '' !== $name_on_which_to_filter ) {
		$this_term = array_filter(
			$terms_array,
			function ( $term ) use ( $name_on_which_to_filter ) {
				return $name_on_which_to_filter === $term->name;
			}
		);
	} else {
		$this_term = $terms_array;
	}

	reindex_array( $this_term );
	flatten_if_array( $this_term );

	if ( '3-Year Degree' === $name_on_which_to_filter ) {
		transform_three_year( $this_term );
	}

	return $this_term;
}
