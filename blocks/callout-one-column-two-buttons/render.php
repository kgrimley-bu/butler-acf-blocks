<?php
/**
 * Template part for displaying Callout - One column multiple buttons
 */

require_once realpath( __DIR__ ) . '/../utils/functions/get_classes.php';

$image = get_field( 'background_image' );
?>
<?php if ( $image ) { ?>
	<style>
		.callout-one-column-two-buttons__wrapper {
			--background-image: url('<?php echo esc_url( $image['url'] ); ?>');
		}
	</style>
<?php } ?>

<section class="<?php echo get_classes( 'callout-one-column-two-buttons block-precedence', $block ); ?>" <?php echo get_anchor( $block ); ?>>
	<div class="callout-one-column-two-buttons__wrapper">
		<div class="callout-one-column-two-buttons__content">
			<?php
			$heading = get_field( 'heading' );
			if ( $heading ) {
				?>
				<h2 class="callout-one-column-two-buttons__heading wysiwyg-content">
					<?php echo $heading['text']; ?>
				</h2>
			<?php } ?>
			<?php
			$items      = get_field( 'items' );
			$link_color = array( 'color' => 'button-solid--color-ghost-light' );
			if ( $items ) {
				?>
				<div class="callout-one-column-two-buttons__links">
					<?php
					foreach ( $items as $item ) {
						require dirname( __DIR__, 2 ) . '/components/button/template.php';
					}
					?>
				</div>
			<?php } ?>
		</div>
	</div>
</section>
