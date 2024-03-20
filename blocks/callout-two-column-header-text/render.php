<?php
$headline            = $block['data']['headline'];
$body_text           = $block['data']['body_text'];
$bottom_margin_label = $block['data']['bottom_margin'];

$classes = array( 'callout-two-column-header-text' );
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
if ( $bottom_margin_label !== 'default' ) {
	$classes[] = 'margin-bottom-' . $bottom_margin_label;
}
// TODO: maybe add an option to highlight the headline
?>

<section class="<?php echo esc_attr( join( ' ', $classes ) ); ?>" <?php echo get_anchor( $block ); ?>>
	<div class="two-column-header-text-inner container">
		<?php if ( $headline ) : ?>
			<div class="headline-wrapper">
				<h2><?php echo $headline; ?></h2>
			</div>
		<?php endif; ?>
		<?php if ( $body_text ) : ?>
			<div class="text-wrapper">
				<p><?php echo $body_text; ?></p>
			</div>
		<?php endif; ?>
	</div>
</section>
