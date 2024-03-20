<?php declare( strict_types=1 );

$color = ! empty( $link_color['color'] ) ? $link_color['color'] : '';
$style = ! empty( $link_color['style'] ) ? $link_color['style'] : '';
?>

<a
	href="<?php echo $link['url']; ?>"
	target="<?php echo $link['target']; ?>"
	class="button-link-right <?php echo $style; ?> <?php echo $color; ?>"
>
	<?php echo $link['title']; ?>
</a>