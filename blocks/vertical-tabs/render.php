<?php
if ( ! class_exists( 'Tab' ) ) {
	class Tab {
		public $tab_heading;
		public $tab_body;
		public $tab_cta;
		public $tab_id;
	}
}

$tab_bg_image  = wp_get_attachment_url( $block['data']['tab_bg_image'] ) ?: '';
$tab_unique_id = 'tab-group-' . str_replace(
	'.',
	'',
	uniqid( floor( microtime( true ) * 1000 ), true )
);

$classes = array( '' );
if ( ! empty( $block['align'] ) ) {
	$classes[] = 'align' . $block['align'];
}

// Check rows exists.
if ( have_rows( 'tab_content' ) ) {
	$my_tabs      = array();
	$tabs_counter = 0;

	// Loop through rows.
	while ( have_rows( 'tab_content' ) ) {
		the_row();

		// Load sub field value.
		$my_tabs[ $tabs_counter ]              = new Tab();
		$my_tabs[ $tabs_counter ]->tab_heading = nl2br( get_sub_field( 'tab_heading' ) ) ?: '';
		$my_tabs[ $tabs_counter ]->tab_body    = get_sub_field( 'tab_body' ) ?: '';
		$my_tabs[ $tabs_counter ]->tab_cta     = get_sub_field( 'tab_cta_link' ) ?: '';
		$my_tabs[ $tabs_counter ]->tab_id      = 'tab-' . str_replace(
			'.',
			'',
			uniqid( floor( microtime( true ) * 1000 ), true )
		);

		++$tabs_counter;
		// End loop.
	}
}

$pause = true;
?>
<!--vertical Tabs-->
<?php if ( $tab_bg_image ) { ?>
	<style>
		.responsive-tabs > .left:before {
			background-image: url('<?php echo esc_url( $tab_bg_image ); ?>');
		}
	</style>
<?php } else { ?>
	<style>
		.responsive-tabs > .left:before {
			background-color: var(--color-theme-primary) !important;
		}
	</style>
<?php } ?>
<section id="<?php echo esc_attr( $tab_unique_id ); ?>"
		class="responsive-tabs vertical <?php echo esc_attr( join( ' ', $classes ) ); ?>" <?php echo esc_attr( get_anchor( $block ) ); ?>>
	<div class="left">
		<div class="editor-message">&#8593;editors might find it easier to edit in the main panel by clicking the
			pencil icon
		</div>
		<ul class="resp-tabs-list <?php echo esc_html( $tab_unique_id ); ?>">
			<?php
			foreach ( $my_tabs as $my_tab ) {
				echo '<li><button role="button">' . esc_js( $my_tab->tab_heading ) . "</button></li>\n";
			}
			?>
		</ul>
	</div>
	<div class="right">
		<div class="resp-tabs-container <?php echo esc_attr( $tab_unique_id ); ?>">
			<?php foreach ( $my_tabs as $my_tab ) { ?>
				<div>
					<?php if ( $my_tab->tab_body ) { ?>
						<?php echo $my_tab->tab_body; ?>
					<?php } ?>

					<?php if ( $my_tab->tab_cta ) { ?>
						<p><a class="button-link-right"
							href="<?php echo esc_url( $my_tab->tab_cta['url'] ); ?>"
							target="<?php echo esc_js( $my_tab->tab_cta['target'] ); ?>"><?php echo esc_js( $my_tab->tab_cta['title'] ); ?></a>
						</p>
					<?php } ?>
				</div>
			<?php } ?>
		</div>
	</div>
</section>
