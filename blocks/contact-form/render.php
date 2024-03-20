<?php

$classes = array( '' );
if ( ! empty( $block['className'] ) ) {
	$classes = array_merge( $classes, explode( ' ', $block['className'] ) );
}
if ( ! empty( $block['data']['bottom_margin_zero'] ) ) {
	$classes[] = 'margin-bottom-0';
}
if ( ! empty( $block['align'] ) ) {
	$classes[] = 'align' . $block['align'];
}
?>
<section class="contact-form <?php echo esc_attr( join( ' ', $classes ) ); ?>"
	<?php echo get_anchor( $block ); ?>>
	<div class="container">
		<div class="description">
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
		<div class="form-container">
			<div id="contact-us-form">Loading...</div>
			<script>
				/*<![CDATA[*/
				var script = document.createElement('script');
				script.async = 1;
				script.src = 'https://adm.butler.edu/register/?id=be2249d7-7127-467c-91bb-ba927c79b2ee&amp;output=embed&amp;div=contact-us-form' + ((location.search.length > 1) ? '&amp;' + location.search.substring(1) : '');
				var s = document.getElementsByTagName('script')[0];
				s.parentNode.insertBefore(script, s);/*]]>*/
			</script>
		</div>
	</div>
	<script>
		// wrap inner header with a span
		const h2Element = document.querySelector('.contact-form .description h2');
		if (h2Element) {
			const spanElement = document.createElement('span');
			// Move the inner HTML of the <h2> element into the <span> element
			while (h2Element.firstChild) {
				spanElement.appendChild(h2Element.firstChild);
			}
			// Append the <span> element inside the <h2> element
			h2Element.appendChild(spanElement);
		}
	</script>
</section>

