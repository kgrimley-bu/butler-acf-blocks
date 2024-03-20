<?php
/**
 * Template part for displaying WYSIWYG
 */

require_once realpath( __DIR__ ) . '/../utils/functions/is_first_wysiwyg.php';
$classes = array( 'wysiwyg' );

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

$first_wysiwyg_id = get_first_wysiwyg_id();

$classes[] = ( $block['id'] == $first_wysiwyg_id ) ? "wysiwyg-primary-block" : 'wysiwyg-secondary-block';

$allowed_blocks = array( 
	'core/heading', 
	'core/image', 
	'core/list', 
	'core/paragraph', 
	'core/quote', 
	'core/table', 
	'core/group', 
	'core/spacer', 
	'core/separator', 
	'core/embed',
	'butler/accordion', 
	'butler/butler-directory', 
	'butler/ics-events', 
	'acf/hrc-calendar', 
	'acf/link-list',
);
$block_template = array( array( 'core/heading', array( 'level' => 1 ) ) );

$wrapper_css = ( get_field( 'sidebar_menu' ) || get_field( 'align_content' ) ) ? 'wysiwyg__wrapper--hasSidebar' : 'wysiwyg__wrapper--noSidebar';
	$wrapper_css .= get_field( 'center_content_area' ) ? ' wysiwyg__wrapper--center' : '';


$nested_directories = ! empty( get_field( 'nested_directories' ) ) ? 'data-nested-directories="' . implode( ',', get_field( 'nested_directories' ) ) . '"' : '';
?>
<section class="<?php echo esc_attr( join( ' ', $classes ) ); ?>" <?php echo get_anchor( $block ); ?>>
	<div class="container grid-default wysiwyg__container">
		<?php if ( get_field( 'sidebar_menu' ) ) { ?>
			<?php
				$menu_id = get_field( 'sidebar_menu' );
			if ( is_int( $menu_id ) ) {
				require dirname( __DIR__, 2 ) . '/components/sidebar-menu/template.php';
			}
			?>
		<?php } ?>
		<div class="wysiwyg__wrapper <?php echo $wrapper_css; ?>">
			<!-- content from editor -->
			<div class="wysiwyg__content wysiwyg__contentContainer">
				<?php
				echo '<InnerBlocks allowedBlocks="' . esc_attr( wp_json_encode( $allowed_blocks ) ) . '" template="' . esc_attr( wp_json_encode( $block_template ) ) . '" />';
				?>
			</div>
		</div>
		<?php
			$accent_text = get_field( 'accent_text' );
		if ( $accent_text ) {
			?>
		<aside class="wysiwyg__accentText col-span-12 order-3">
			<span class="wysiwyg__accentText--left"><?php echo $accent_text; ?></span>
			<span class="wysiwyg__accentText--right"><?php echo $accent_text; ?></span>
		</aside>
		<?php } ?>
	</div>
</section>
