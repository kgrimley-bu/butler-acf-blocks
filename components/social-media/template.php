<?php
/**
 * Template for creating a social media icon list.
 */
if ( isset( $social_media_options['option_new_tab'] ) ) {
	$target = $social_media_options['option_new_tab'] ? 'target="_blank"' : '';
} else {
	$target = '';
}
?>

<ul class="social-media__menuList">
	<?php
	if ( is_array( $social_media_options['links'] ) || is_object( $social_media_options['links'] ) ) {
		foreach ( $social_media_options['links'] as $key => $item ) {
			if ( isset( $item['link_url'] ) ) {
				?>
			<li>
				<a href="<?php echo $item['link_url']; ?>" class="social-media__menuLink" title="<?php echo $item['link_title']; ?>" <?php echo $target; ?>>
					<?php include dirname( __DIR__, 2 ) . '/assets/social-icons/social-media-' . $item['social_media_type'] . '.svg'; ?>
				</a>
			</li>
				<?php
			}
		}
	}
	?>
</ul>
