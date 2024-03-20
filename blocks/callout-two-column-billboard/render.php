<?php
/**
 * Template part for displaying Two Column - Billboard
 */
require_once realpath( __DIR__ . '/..' ) . '/utils/functions/image_set.php';
require_once realpath( __DIR__ ) . '/../utils/functions/get_classes.php';

$has_cards = ( get_field( 'cards' ) == false ) ? 'callout-two-column-billboard--noCards' : '';
$has_title = ( get_field( 'headline' )['text'] ) ? 'callout-two-column-billboard--hasTitle' : '';
$classes = array( 'callout-two-column-billboard alignfull', $has_cards, $has_title );

?>
<section class="<?php echo get_classes( $classes, $block ); ?>" <?php echo get_anchor( $block ); ?>>
	<div class="callout-two-column-billboard__wrapper container grid-default">
	<?php
	$headline = get_field( 'headline' );
	$headline['size'] = 'h2';
	if ( $headline['text'] ) {
		?>
		<div class="callout-two-column-billboard__headline">
			<?php
				require dirname( __DIR__, 2 ) . '/components/headline-highlight/template.php';
			?>
		</div>
		<?php
	}

	if ( get_field( 'overview' ) ) {
		?>
		<div class="callout-two-column-billboard__overview wysiwyg__content">
			<?php
			the_field( 'overview' );
			?>
		</div>
		<?php
	}

	$cards = get_field( 'cards' );
	if ( $cards ) {
		?>
		<div class="callout-two-column-billboard__cards-wrapper">
			<div class="callout-two-column-billboard__cards grid-default">
				<?php foreach ( $cards as $card ) { ?>
					<div class="callout-two-column-billboard__card">
						<?php
						$image = $card['image'];
						if ( ! empty( $image ) ) {
							$srcset = image_set( $image, 'callout-two-column-billboard__card-img' );
							?>
							<div class="callout-two-column-billboard__card-img-wrapper">
								<?php echo $srcset; ?>
							</div>
						<?php } ?>
						
						<div class="callout-two-column-billboard__card-text">
							<?php
								$headline = $card['headline'];
							if ( $headline ) :
								?>
								<p class="callout-two-column-billboard__card-headline">
								<?php echo $headline; ?>
								</p>
							<?php endif; ?>
							<?php
								$description = $card['description'];
							if ( $description ) {
								?>
								<p class="callout-two-column-billboard__card-description">
								<?php echo $description; ?>
								</p>
							<?php } ?>
							<?php

							$item = $card;
							$link_color = array( 'color' => 'button-link-right--color-white' );
							if ( is_array( $item ) && $item['link'] ) {
								?>
								<div
									class="callout-two-column-billboard__card-link"
								>
									<?php require dirname( __DIR__, 2 ) . '/components/button/template.php'; ?>
								</div>
						<?php } ?>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
		<?php
	}
	?>

	</div>
</section>