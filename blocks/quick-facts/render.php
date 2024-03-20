<?php
/**
 * Template part for displaying Quick Facts
 */
require_once realpath( __DIR__ ) . '/../utils/functions/get_classes.php';

$quick_facts = get_field( 'quick_facts' );
$quick_facts_count = $quick_facts ? count( $quick_facts ) : 0;

$classes = array( 'quick-facts' );
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
?>
<section class="<?php echo get_classes( 'quick-facts', $block ); ?>" <?php echo get_anchor( $block ); ?>>
	<div class="container grid-default quick-facts__wrapper">
		<?php
		if ( $quick_facts ) {
			foreach ( $quick_facts as $key => $item ) {
				$background_pattern = $item['background_pattern'];
				?>
				<figure class="quick-facts__card" style="--background-pattern-url: <?php echo 'url(../../assets/images/patterns/large/' . $background_pattern . '.png)'; ?>">
					<div class="quick-facts__data">
						<div class="quick-facts__dataValue"><?php echo $item['data_point']; ?></div>
					</div>
					<figcaption class="quick-facts__caption"><?php echo $item['caption']; ?></figcaption>
				</figure>
				<?php
			}
		}
		?>
	</div>
</section>