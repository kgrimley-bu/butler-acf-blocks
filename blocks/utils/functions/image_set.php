<?php
/**
 * Wrap supplied `media` with supplied `CSS` in a way consistent with `WP Core`.
 *
 * Constructs an `<img>` tag using the supplied `media` and `CSS` mimicking `WP Core`.
 * This ensures we have consistent behavior across the site along with proper accessibility attributes.
 *
 * @param mixed  $media `media object` from `WP Core`.
 * @param string $css Optional. `string` containing `CSS` markup to be applied to the supplied `media`. Default `""`.
 *
 * @return string `string` containing HTML data to be echoed out onto the page.
 */

function image_set( $media, $css = '' ) {
	if ( is_object( $media ) ) {
		$data_type = 'object';
	} elseif ( is_array( $media ) ) {
		$data_type = 'array';
	} else {
		$data_type = 'other';
	}

	$classes = ( $css !== '' ) ? "$css" : '';
	$sizes   = array( 'medium', 'medium_large', 'large' );
	switch ( $data_type ) {
		case 'object':
			$media_sizes = (array) $media->media_details->sizes;
			$alt         = ( $media->alt_text ) ? $media->alt_text : '';
			$width       = $media->media_details->width;
			$height      = $media->media_details->height;
			
			if ( ! empty( $media_sizes ) ) {
				$srcset_string = '';
				$width       = $media->media_details->sizes->medium->width;
				$height      = $media->media_details->sizes->medium->height;
				foreach ( $sizes as $size ) {
					if ( array_key_exists( $size, $media_sizes ) ) {
						$img_size      = $media_sizes[ $size ];
						$srcset_string .= $img_size->source_url . ' ' . $img_size->width . 'w, ';
					}
				}
				$img_tag = "<img srcset='$srcset_string' src='$media->source_url' sizes='' alt='$alt' class='$classes' width='$width' height='$height' />";
			} else {
				
				$img_tag = "<img src='$media->source_url' alt='$alt' class='$classes' width='$width' height='$height' />";
			}

			
			break;

		case 'array':
			$media_sizes = (array) $media['sizes'];
			$alt         = ( $media['alt'] ) ? $media['alt'] : '';
			$width       = $media['width'];
			$height      = $media['height'];

			if ( ! empty( $media_sizes ) ) {
				$srcset_string = '';

				foreach ( $sizes as $size ) {
					if ( array_key_exists( $size, $media_sizes ) ) {
						$img_url       = $media_sizes[ $size ];
						$img_width     = $media_sizes[ $size . '-width' ];
						$srcset_string .= $img_url . ' ' . $img_width . 'w, ';
					}
				}
			}

			$img_tag = "<img srcset='$srcset_string' alt='$alt' class='$classes' width='$width' height='$height' />";
			break;

		default:
			$src     = ( $media['url'] ) ? $media['url'] : '';
			$alt     = $media['url'] ?? '';
			$img_tag = "<img src='$src' alt='$alt' class='$classes' />";
			break;
	}

	return $img_tag;
}
