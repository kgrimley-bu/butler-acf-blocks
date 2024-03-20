<?php

require_once realpath( __DIR__ ) . '/../utils/functions/get_classes.php';
$block_align = ( get_field( 'image_align' ) == 'left' ) ? 'two-column-text-links-image--imageLeft' : 'two-column-text-links-image--imageRight';
$has_links = ( get_field( 'items' ) ) ? '' : 'two-column-text-links-image--noLinks';
$image_option = get_field( 'hero_image' ) ? 'hero-standard--hasImage' : 'hero-standard--noImage';
$headline = get_field( 'headline' ) ? get_field( 'headline' ) : $args['headline'];
$color = get_field( 'headline_highlight' ) ? get_field( 'headline_highlight' )['value'] : '';

?>

<section class="<?php echo get_classes( 'two-column-text-links-image' . ' ' . $block_align . ' ' . $has_links, $block ); ?>" <?php echo get_anchor( $block ); ?>>
	<div class="two-column-text-links-image__imageWrapper">
		<?php
				$image = get_field( 'image' );
		if ( ! empty( $image ) ) {
			?>
				<?php
				echo wp_get_attachment_image(
					$image['ID'],
					array( 640 ),
					false,
					array(
						'class' => 'two-column-text-links-image__media-img',
						'sizes' => '50vw',
					)
				);
				?>
		<?php } ?>
	</div>
	<div class="container two-column-text-links-image__grid-default two-column-text-links-image__wrapper">
		<div class="two-column-text-links-image__content sketches__app">
			<?php if ( get_field( 'description' ) ) : ?>
				<p class="two-column-text-links-image__description t-h2">
					<?php echo get_field( 'description' ); ?>
				</p>
			<?php endif; ?>
			<?php
				$items = get_field( 'items' );
				$link_color = array( 'color' => '' );

			if ( get_field( 'items' ) ) {
				?>
				<div class="two-column-text-links-image__links">
				<?php
				foreach ( $items as $item ) :
					$link = $item['link']
					?>
					<?php require dirname( __DIR__, 2 ) . '/components/button-solid/template.php'; ?>
					<?php endforeach; ?>
				</div>
			<?php } ?>
		</div>
	</div>
</section>