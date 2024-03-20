<?php

require_once realpath( __DIR__ ) . '/../utils/functions/hrc-calendar-api.php';
require_once realpath( __DIR__ ) . '/../utils/functions/get_classes.php';

?>

<section class="<?php echo get_classes( 'hrc-calendar', $block ); ?>" <?php echo get_anchor( $block ); ?> <?php /*echo is_nested( $block ); */ ?>>
	<div class="container wysiwyg__content">
		<?php echo get_field( 'heading' ) ? '<header class="t-h3">' . get_field( 'heading' ) . '</header>' : ''; ?>

		<?php echo butler_hrc_block_view( 'butlerHRC' )['content']; ?>
	</div>
</section>