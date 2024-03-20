<?php
require_once realpath( __DIR__ ) . '/../utils/functions/get_classes.php';

$tab_id   = $block['id'];
$headline = $block['data']['tab_group_intro_headline'];

// $tab_orientation = $block['data']['tab_orientation'];
// $tab_bg_image    = wp_get_attachment_url( $block['data']['tab_selector_bg_image'] ) ?: '';

?>
<section class="<?php echo get_classes( 'tabgroup-wrapper', $block ); ?>">
	<?php if ( $headline ) { ?>
		<div class="tabgroup-headline">
			<h2><?php echo $headline; ?></h2>
		</div>
	<?php } ?>
	<div class="tabgroup js-tablist horizontal">
		<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( array( 'acf/tab-item' ) ) ); ?>"
				   template="<?php echo esc_attr( wp_json_encode( array( array( 'acf/tab-item' ) ) ) ); ?>"/>
		<div class="tabs-content"></div>
	</div>
</section>

