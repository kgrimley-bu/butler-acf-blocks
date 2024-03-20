<?php
	$url = ! empty( $link['url'] ) ? $link['url'] : '';
	$title = ! empty( $link['title'] ) ? $link['title'] : '';
	$target = ! empty( $link['target'] ) ? 'target="' . $link['target'] . '"' : '';
	$color = ! empty( $link_color['color'] ) ? $link_color['color'] : '';
	$hover = ! empty( $link_color['hover'] ) ? $link_color['hover'] : '';

if ( $url !== '' ) {
	?>

<a href="<?php echo $url; ?>" <?php echo $target; ?> class="button-solid <?php echo $color; ?> <?php echo $hover; ?> t-p1">
	<span class="button-solid__label">
	 <?php echo $title; ?>
	</span>
</a>

<?php } ?>