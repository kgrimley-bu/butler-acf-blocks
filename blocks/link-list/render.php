<?php
require_once realpath( __DIR__ ) . '/../utils/functions/get_classes.php';

$classes = array( 'link-list' );
$classes[] = 'layout-' . get_field( 'visual_layout' );
?>

<section class="<?php echo get_classes( $classes, $block ); ?>" <?php echo get_anchor( $block ); ?>>
	<div class="link-list__container link-list__grid-default">
		<?php if ( get_field( 'heading' ) ) { ?>
			<div class="link-list__heading">
				<?php
				$headline = array(
					'text' => get_field( 'heading' ),
					'color_value' => get_field( 'headline_highlight' )['value'],
					'size' => 'header',
				);
				require dirname( __DIR__, 2 ) . '/components/headline-highlight/template.php';
				?>
			</div>
		<?php } ?>
		<?php if ( get_field( 'description' ) ) { ?>
			<p class="link-list__description ">
				<?php echo get_field( 'description' ); ?>
			</p>
		<?php } ?>
		<div class="list-list__linkWrapper link-list__grid-default">
			<?php
			if ( get_field( 'column_1' ) ) {
				if ( 'links' == get_field( 'visual_layout' ) ) {
					?>
					<ul class="wysiwyg__ctaLinks">
						<?php
						foreach ( get_field( 'column_1' ) as $item ) {
							$target = ( $item['link_url']['target'] !== '' ) ? 'target=' . $item['link_url']['target'] . '"' : '';
							?>
							<li>
								<a href="<?php echo $item['link_url']['url']; ?>" class="button-link-right button-link-right--color-blue-bright" <?php echo $target; ?>><?php echo $item['link_url']['title']; ?></a>
							</li>
						<?php } ?>
					</ul>
					<?php
				} else {
					?>
					<ul class="link-list__list">
						<?php
						foreach ( get_field( 'column_1' ) as $item ) {
							$target = ( $item['link_url']['target'] !== '' ) ? 'target=' . $item['link_url']['target'] . '"' : '';
							?>
							<li class="link-list__listItem">
								<a href="<?php echo $item['link_url']['url']; ?>" <?php echo $target; ?> class="button-solid">
									<?php echo $item['link_url']['title']; ?>
								</a>
							</li>
						<?php } ?>
					</ul>
				<?php } ?>
			<?php } ?>
			<?php if ( get_field( 'column_2' ) ) { ?>
				<ul class="link-list__list">
					<?php
					foreach ( get_field( 'column_2' ) as $item ) {
						$target = ( $item['link_url']['target'] !== '' ) ? 'target=' . $item['link_url']['target'] . '"' : '';
						?>
						<li class="link-list__listItem">
							<a href="<?php echo $item['link_url']['url']; ?>" <?php echo $target; ?> class="button-solid">
								<?php echo $item['link_url']['title']; ?>
							</a>
						</li>
					<?php } ?>
				</ul>
			<?php } ?>
		</div>
	</div>
</section>
