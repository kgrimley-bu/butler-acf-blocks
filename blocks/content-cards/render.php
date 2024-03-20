<?php

$callout_card_group_background_image =
	wp_get_attachment_url( $block['data']['callout_group_background_image'] ) ?:
		'';
$callout_card_headline               = nl2br( $block['data']['callout_card_headline'] ) ?: '';
$callout_card_heading_body           =
	nl2br( $block['data']['callout_card_heading_body'] ) ?: '';

if ( have_rows( 'callout_card_cards' ) ) :
	$cards         = array();
	$cards_counter = 0;

	while ( have_rows( 'callout_card_cards' ) ) :
		the_row();
		$cards[ $cards_counter ]['heading'] = nl2br( get_sub_field( 'callout_card_headline' ) ) ?: '';
		$cards[ $cards_counter ]['body']    = get_sub_field( 'callout_card_body' ) ?: '';
		++$cards_counter;
	endwhile;
endif;

$classes = array( 'content-cards alignfull' );
if ( empty( $callout_card_group_background_image ) ) {
	$classes[] = 'no-bg-image';
}

?>
<?php if ( $callout_card_group_background_image ) : ?>
	<style>
		.content-cards {
			background-image: url('<?php echo esc_url( $callout_card_group_background_image ); ?>');
		}
	</style>
<?php endif; ?>

<section class="<?php echo esc_attr( join( ' ', $classes ) ); ?> " <?php echo esc_attr( get_anchor( $block ) ); ?>>
	<div class="squiggly">
		<img src="/wp-content/themes/butler-majors/assets/images/content-cards-squiggly.svg" alt="">
	</div>
	<div class="container">
		<div class="description">
			<h2 class="headline"><span><?php echo $callout_card_headline; ?></span></h2>
			<p><?php echo $callout_card_heading_body; ?></p>
		</div>
		<div class="card-group">
			<?php
			$count                = 1;
			$odd_count            = 0;
			$even_count           = 0;
			$grid_string_template = 'grid-row-start: %s; grid-row-end: %s;';
			$grid_string          = '';

			foreach ( $cards as $card ) {
				if ( 1 === $count % 2 ) {
					++$odd_count;
					$grid_string = sprintf( $grid_string_template, $odd_count, $odd_count + 2 );
				} else {
					$even_count  = $odd_count + 1;
					$grid_string = sprintf( $grid_string_template, $even_count, $even_count + 2 );
				}
				?>
				<div class="card" style="<?php echo $grid_string; ?>">
					<h3><?php echo $card['heading']; ?></h3>
					<?php echo $card['body']; ?>
				</div>

			<?php } ?>
		</div>
	</div>
</section>
