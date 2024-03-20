<?php
/**
 * Template part for displaying Callout - Three Column Text & Links
 */

require_once realpath( __DIR__ ) . '/../utils/functions/get_classes.php';

?>

<section class="<?php echo get_classes( "callout-three-column-text-action-links-right", $block ); ?>" <?php echo get_anchor( $block ); ?>>
	<div class="callout-three-column-text-action-links-right__wrapper">
		<div class="callout-three-column-text-action-links-right__heading">
			<?php if ( get_field( 'heading' ) ) { ?>
				<h2 class="wysiwyg-content">
					<?php the_field( 'heading' ); ?>
			</h2>
			<?php } ?>
		</div>
		<div class="callout-three-column-text-action-links-right__description">
			<?php if ( get_field( 'description' ) ) { ?>
				<p class="">
					<?php the_field( 'description' ); ?>
				</p>
			<?php } ?>
		</div>
		<div class="callout-three-column-text-action-links-right__items">
			<?php
				$items = get_field( 'items' );
			if ( $items ) {
				$link_color = array(
					'color' => '',
					'hover' => 'button-solid--hover-none',
				);
				?>
				  
				<?php
				foreach ( $items as $item ) {
					$link = $item['link'];
					require dirname( __DIR__, 2 ) . '/components/button/template.php';
				}
			}
			?>
		</div>

		
	</div>

	

</section>
