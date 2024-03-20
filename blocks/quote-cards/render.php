<?php

require_once realpath( __DIR__ ) . '/../utils/functions/get_classes.php';

$heading = get_field( 'heading' ) ?: '';

?>
<section class="<?php echo get_classes( 'quote-cards-wrapper', $block ); ?>">
	<?php if ( ! empty( $heading ) ) { ?>
		<h2><?php echo $heading; ?></h2>
	<?php } ?>
	<InnerBlocks allowedBlocks="
	<?php
	echo esc_attr(
		wp_json_encode(
			array(
				'butler/quote-card',
			)
		)
	);
	?>
	"/>
</section>

