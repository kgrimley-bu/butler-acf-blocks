<?php
/**
 * Plugin Name: Butler ACF Blocks
 * Plugin URI:        https://github.butler.edu/it/butler-acf-blocks
 * Description:       Collection of custom Butler blocks built with ACF
 * Version:           2.0.0
 * Requires at least: 6.0
 * Requires PHP:      7.2
 * Author:            Butler University
 * Author URI:        https://www.butler.edu
 * Text Domain:       butler-acf-blocks
 **/

/**
 * Register Blocks and register/enqueue styles.
 */
function load_blocks() {
	$plugin_data = get_file_data( __FILE__, array( 'Version' => 'Version' ), false );
	$blocks      = get_blocks();
	$components  = get_components();

	foreach ( $blocks as $block ) {
		if ( file_exists( plugin_dir_path( __FILE__ ) . 'blocks/' . $block . '/block.json' ) ) {
			register_block_type( plugin_dir_path( __FILE__ ) . 'blocks/' . $block . '/block.json' );
			wp_register_style( 'block-' . $block, plugin_dir_url( __FILE__ ) . 'blocks/' . $block . '/style.css', null, $plugin_data['Version'] );

			if ( file_exists( plugin_dir_path( __FILE__ ) . 'blocks/' . $block . '/init.php' ) ) {
				include_once plugin_dir_path( __FILE__ ) . 'blocks/' . $block . '/init.php';
			}

			if ( file_exists( plugin_dir_path( __FILE__ ) . 'blocks/' . $block . '/main.js' ) ) {
				wp_register_script(
					"block-$block",
					plugin_dir_url( __FILE__ ) . 'blocks/' . $block . '/main.js',
					array( 'jquery' ),
					$plugin_data['Version'],
					array(
						'strategy' => 'defer',
						true,
					)
				);
			}
		} elseif ( file_exists( plugin_dir_path( __FILE__ ) . 'blocks/' . $block . '/build/block.json' ) ) {
			register_block_type( plugin_dir_path( __FILE__ ) . "blocks/$block/build" );
			wp_enqueue_style( "block-$block", plugin_dir_url( __FILE__ ) . "blocks/$block/build/style-$block.css" );
		}
	}

	foreach ( $components as $component ) {
		if ( file_exists( plugin_dir_path( __FILE__ ) . 'components/' . $component . '/style.css' ) ) {
			wp_register_style( 'component-' . $component, plugin_dir_url( __FILE__ ) . 'components/' . $component . '/style.css', null, $plugin_data['Version'] );
		}

		if ( file_exists( plugin_dir_path( __FILE__ ) . 'components/' . $component . '/editor-style.css' ) ) {
			wp_enqueue_style( 'component-' . $component, plugin_dir_url( __FILE__ ) . 'components/' . $component . '/editor-style.css', null, $plugin_data['Version'] );
		}

		if ( file_exists( plugin_dir_path( __FILE__ ) . 'components/' . $component . '/main.js' ) ) {
			wp_register_script( "component-$component", plugin_dir_url( __FILE__ ) . 'components/' . $component . '/main.js', 'jquery', $plugin_data['Version'] );
		}
	}

	wp_register_style( 'plyr-custom', plugin_dir_url( __FILE__ ) . 'assets/css/plyr.css', 'plyr-main', $plugin_data['Version'] );
	wp_enqueue_style( 'butler-acf-blocks-common', plugin_dir_url( __FILE__ ) . 'assets/css/style.css' );
}
add_action( 'init', 'load_blocks', 5 );

/**
 * Register and enqueue additional and external CSS and JS
 */
function setup_additional_css_js() {
	/**
	 * Load and register Plyr
	 *
	 * Used in the following blocks:
	 * - full-width-video-image
	 * - callout-two-column-full-width-image-video
	 *
	 * @see https://github.com/sampotts/plyr#javascript
	 */
	wp_register_script( 'plyr', 'https://cdn.plyr.io/3.7.8/plyr.js', array( 'jquery' ) );
	wp_register_style( 'plyr-main', 'https://cdn.plyr.io/3.7.8/plyr.css' );

	/**
	 * Load and register GSAP
	 *
	 * Used in the following blocks:
	 * - callout-two-column-quote
	 * - full-width-video-image
	 *
	 * @see https://greensock.com/docs/v3/Installation#cdn
	 */
	wp_register_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.0/gsap.min.js', array( 'jquery' ) );
	wp_register_script( 'gsap-scrollTrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.0/ScrollTrigger.min.js', array( 'gsap' ) );
	wp_register_script( 'gsap-scrollToPlugin', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.0/ScrollToPlugin.min.js', array( 'gsap' ) );

	/**
	 * Load and register Swiper
	 *
	 * Used in the following blocks:
	 * - gallery-carousel
	 *
	 * @see https://swiperjs.com/get-started#use-swiper-from-cdn
	 */
	wp_register_script( 'swiper', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js', array( 'jquery' ) );
	wp_register_style( 'swiper-main', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css' );
}
add_action( 'init', 'setup_additional_css_js', 5 );

/**
 * Add global editor css.
 */
function add_butler_acf_blocks_editor_css() {
	wp_enqueue_style( 'butler-acf-blocks-common-editor', plugin_dir_url( __FILE__ ) . 'assets/css/editor-style.css' );
}
add_action( 'admin_init', 'add_butler_acf_blocks_editor_css' );

/**
 * Get an array of all the blocks.
 *
 * @return Array All the blocks in the /block folder.
 */
function get_blocks() {
	$plugin_data = get_file_data( __FILE__, array( 'Version' => 'Version' ), false );
	$blocks      = get_option( 'butler_blocks' );
	$version     = get_option( 'butler_blocks_version' );
	$blocks      = scandir( plugin_dir_path( __FILE__ ) . 'blocks/' );
	$blocks      = array_values( array_diff( $blocks, array( '..', '.', '.DS_Store', '_base-block' ) ) );

	update_option( 'butler_blocks', $blocks );
	update_option( 'butler_blocks_version', $plugin_data['Version'] );

	return $blocks;
}

/**
 * Get an array of all the components.
 *
 * @return Array All the components in the /components folder.
 */
function get_components() {
	$plugin_data = get_file_data( __FILE__, array( 'Version' => 'Version' ), false );
	$components  = get_option( 'butler_components' );
	$version     = get_option( 'butler_blocks_version' );
	$components  = scandir( plugin_dir_path( __FILE__ ) . 'components/' );
	$components  = array_values( array_diff( $components, array( '..', '.', '.DS_Store', '_base-block' ) ) );

	update_option( 'butler_components', $components );
	update_option( 'butler_blocks_version', $plugin_data['Version'] );

	return $components;
}

/**
 * Get the custom anchor ID set by the user.
 *
 * @param array $block The full data for the block.
 *
 * @return string The custom anchor as an ID attribute.
 */
function get_anchor( $block ) {
	if ( ! is_null( $block ) && array_key_exists( 'anchor', $block['supports'] ) && isset( $block['anchor'] ) ) {
		$anchor_id = 'id="' . $block['anchor'] . '"';
	} else {
		$anchor_id = '';
	}

	return $anchor_id;
}

/**
 * Set the save location for acf json files.
 *
 * @param string $path The default save location for acf json files.
 *
 * @return string The url to the save folder
 */
function butler_blocks_acf_save_point( $path ) {
	$path = plugin_dir_path( __FILE__ ) . 'acf-json';

	return $path;
}
add_filter( 'acf/settings/save_json', 'butler_blocks_acf_save_point' );

/**
 * Set the load location for acf json files.
 *
 * @param array $paths All possible load locations for acf json files.
 *
 * @return string The url to the load folder
 */
function butler_blocks_acf_load_point( $paths ) {
	unset( $paths[0] );
	$paths[] = plugin_dir_path( __FILE__ ) . 'acf-json';

	return $paths;
}
add_filter( 'acf/settings/load_json', 'butler_blocks_acf_load_point' );

/**
 * Determine if supplied block type exists on the page.
 *
 * @param string $block_type The slug of the block to check for.
 *
 * @return bool True if block is on page. False if block is not on page.
 */
function has_block_type( $block_type = '' ) {
	if ( '' !== $block_type && null !== $block_type ) {
		global $post;

		if ( ! is_null( $post ) ) {
			$all_blocks = parse_blocks( $post->post_content );

			$has_block_type = array_filter(
				$all_blocks,
				function ( $item ) use ( $block_type ) {
					return ( $item['blockName'] == $block_type ) ? true : false;
				}
			);

			return ! empty( $has_block_type ) ? true : false;
		} else {
			return false;
		}
	} else {
		return null;
	}
}

/**
 * Disable the Gold color choice for any user below admin.
 *
 * @param array $field The field array containing all settings (including value).
 *
 * @return array The altered field.
 */
function disable_gold_color_choice( $field ) {
	global $current_user;
	if ( 'administrator' !== $current_user->roles[0] ) {
		$field['disabled'] = array(
			'gold',
		);
	}

	return $field;
}
add_filter( 'acf/load_field/key=field_61116917c3070', 'disable_gold_color_choice' );
