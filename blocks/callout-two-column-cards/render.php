<?php
require_once realpath( __DIR__ ) . '/../utils/functions/get_classes.php';

$headline                = nl2br( $block['data']['title'] ) ?: '';
$show_background_graphic = $block['data']['show_background_graphic'] ?: '';

$left_text     = $block['data']['callout_left_title'] ?: '';
$left_image_id = $block['data']['callout_left_image_id'] ?: '';
$left_link     = $block['data']['callout_left_link'] ?: '';

$right_text     = $block['data']['callout_right_title'] ?: '';
$right_image_id = $block['data']['callout_right_image_id'] ?: '';
$right_link     = $block['data']['callout_right_link'] ?: '';

$classes = array( 'callout-two-column-cards' );

if ( ! empty( $block['align'] ) ) {
	$classes[] = 'align' . $block['align'];
}

if ( ! empty( $show_background_graphic ) ) {
	$classes[] = 'has-bg-graphic';
}
$size = 'full';
?>

<section class="<?php echo get_classes( $classes, $block ); ?>" <?php echo get_anchor( $block ); ?>>
	<div class="container">
		<h2 class=""><?php echo $headline; ?></h2>
		<div class="callout-two-column-cards--content">
			<div class="card">
				<?php
				if ( $left_image_id ) {
					// creates the img tag
					echo wp_get_attachment_image( $left_image_id, $size );
				}
				?>
				<div class="content">
					<h3><?php echo $left_text; ?></h3>
					<?php if ( ! empty( $left_link['url'] ) ) { ?>
						<a target="<?php echo $left_link['target']; ?>"
						   href="<?php echo $left_link['url']; ?>"
						   class="button-link-right button-link-right--color-white-over-dark">
							<?php echo $left_link['title']; ?></a>
					<?php } ?>
				</div>
			</div>
			<div class="card">
				<?php
				if ( $right_image_id ) {
					// creates the img tag
					echo wp_get_attachment_image( $right_image_id, $size );
				}
				?>
				<div class="content">
					<h3><?php echo $right_text; ?></h3>
					<?php if ( ! empty( $right_link['url'] ) ) { ?>
						<a target="<?php echo $right_link['target']; ?>"
						   href="<?php echo $right_link['url']; ?>"
						   class="button-link-right button-link-right--color-white-over-dark">
							<?php echo $right_link['title']; ?>
						</a>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</section>
