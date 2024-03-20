<?php
require_once realpath( __DIR__ ) . '/../utils/functions/get_classes.php';
?>

<section class="<?php echo get_classes( 'callout-two-column-two-buttons sketches__app', $block ); ?>"
		 style="background-color: var(--color-theme-<?php the_field( 'background_color' ); ?>);" <?php echo get_anchor( $block ); ?>>
	<div class="callout-two-column-two-buttons__wrapper container grid-default">
		<div class="callout-two-column-two-buttons__text">
			<InnerBlocks allowedBlocks="
			<?php
			echo esc_attr(
				wp_json_encode(
					array(
						'core/heading',
						'core/paragraph',
					)
				)
			);
			?>
			"/>
		</div>
		<?php
		$items = get_field( 'items' );

		if ( $items ) {
			if ( get_field( 'background_color' )[ 'value' ] == 'primary' || get_field( 'background_color' )[ 'value' ] == 'blue' || get_field( 'background_color' )[ 'value' ] == 'pink' || get_field( 'background_color' )[ 'value' ] == 'green' ) {
				$link_color = array(
					'color' => 'button-link-right--color-theme-white',
					'style' => 'button-link-right--hover-solid',
				);
			} else {
				$link_color = array(
					'color' => 'button-link-right--color-theme-primary',
					'style' => 'button-link-right--hover-solid',
				);
			}
			
			?>
			<div class="callout-two-column-two-buttons__links">
				<?php
				$visual_layout = get_field( 'visual_layout' );
				foreach ( $items as $item ) {
					if ( $item['link'] !== '' ) {
						$link = $item['link'];
						if ( 'buttons' == $visual_layout ) {
							require dirname( __DIR__, 2 ) . '/components/button-solid/template.php';
						} else {
							require dirname( __DIR__, 2 ) . '/components/button-link-right/template.php';
						}
					}
				}
				?>
			</div>
		<?php } ?>
	</div>
</section>
