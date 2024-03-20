<?php

require_once realpath( __DIR__ ) . '/../utils/functions/get_classes.php';

$placeholder_text = nl2br( $block['data']['placeholder_text'] ) ?: '';
$items            = get_field( 'associated_callouts' );

?>

<!--<script type="text/javascript" src="/butler-new/wp-content/plugins/wp-search-with-algolia/js/autocomplete.js/dist/autocomplete.min.js?ver=2.7" id="algolia-autocomplete-js"></script>-->
<!--<script type="text/javascript" src="/butler-new/wp-content/plugins/wp-search-with-algolia/js/autocomplete-noconflict.js?ver=2.7" id="algolia-autocomplete-noconflict-js"></script>-->
<!--<link rel="stylesheet" id="algolia-autocomplete-css" href="https://www-uat.butler.edu/wp-content/plugins/wp-search-with-algolia/css/algolia-autocomplete.css?ver=2.6.2" type="text/css" media="all">-->

<section class="<?php echo get_classes( 'program-search-majors', $block ); ?>">
	<div class="container">
		<svg xmlns="http://www.w3.org/2000/svg" width="1354" height="475" viewBox="0 0 1354 475" fill="none"
			class="squiggly">
			<path class="stroke" opacity="0.33"
				d="M343.366 -473.05C56.2651 -440.366 -212.477 -272.071 -367.437 -28.0336C-412.037 42.2103 -444.709 141.921 -387.248 202.101C-320.036 272.552 -204.387 220.985 -117.572 176.888C-14.3692 124.283 96.6126 87.1373 210.602 67.0084C302.396 50.8222 428.21 69.3949 441.279 161.635C454.037 251.386 347.826 303.368 271.694 352.445C193.385 402.872 131.567 478.511 97.7536 565.252C82.9214 603.228 73.7939 647.636 92.9824 683.536C128.144 749.629 226.99 740.187 293.476 705.844C429.558 635.496 531.828 502.375 679.112 460.25C705.457 452.675 734.188 448.421 759.807 457.863C835.939 485.67 826.811 598.143 788.331 669.529C749.746 740.81 694.463 820.184 725.372 895.097C757.629 973.227 870.374 987.649 943.187 944.797C1016 902.049 1057.9 822.675 1096.18 747.347C1170.23 601.567 1244.19 455.788 1318.14 310.009C1334.63 277.429 1351.54 243.604 1352.57 207.081C1354.55 142.544 1304.55 85.166 1245.22 59.8491C1185.89 34.4285 1118.89 35.0511 1054.58 39.7202C993.906 44.1817 930.014 51.341 874.834 25.6091C770.802 -23.0532 750.68 -175.369 812.187 -272.383C853.156 -337.024 924.932 -402.91 898.172 -474.606C874.731 -537.172 792.687 -550.038 725.994 -547.755C589.393 -543.086 461.297 -486.434 343.366 -472.946"
				stroke-miterlimit="10"/>
		</svg>
		<div class="content">

			<InnerBlocks allowedBlocks="
			<?php
			echo esc_attr(
				wp_json_encode(
					array(
						'core/image',
						'core/heading',
					)
				)
			);
			?>
			"/>

			<form id="program-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>"
				class="wp-block-search__no-button wp-block-search ais-search-form">
				<div class="wp-block-search__inside-wrapper">
					<input type="search" id="wp-block-search__input-1"
							class="wp-block-search__input aa-input search-field"
							title="search butler majors" name="s" value=""
							placeholder="<?php echo $placeholder_text; ?>" required=""
							autocomplete="off"
							spellcheck="false" role="combobox" aria-autocomplete="list" aria-expanded="false"
							aria-owns="algolia-autocomplete-listbox-4" dir="auto" style="">
					<pre aria-hidden="true"
						style="position: absolute; visibility: hidden; white-space: pre; font-family: Sentinel, serif; font-size: 18px; font-style: normal; font-variant: normal; font-weight: 400; word-spacing: 0px; letter-spacing: normal; text-indent: 0px; text-rendering: auto; text-transform: none;"></pre>
				</div>
			</form>

			<?php


			if ( $items ) {
				$link_color = array(
					'color' => 'button-link-right--color-theme-primary t-p1',
					'style' => 'button-solid',
				);
				?>
				<div class="button-container">
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
	</div>
	<script type="text/html" id="tmpl-autocomplete-post-suggestion">
		<a class="suggestion-link" href="{{ data.permalink }}" title="{{ data.post_title }}">
			<div class="suggestion-post-attributes">
				<span class="suggestion-post-title">{{{ data._highlightResult.post_title.value }}}</span>
			</div>
			<?php
			do_action( 'algolia_autocomplete_after_hit' );
			?>
		</a>
	</script>

	<script type="text/html" id="tmpl-autocomplete-empty">
		<div class="autocomplete-empty">
			<?php esc_html_e( 'No results matched your query ', 'wp-search-with-algolia' ); ?>
			<span class="empty-query">"{{ data.query }}"</span>
		</div>
	</script>

</section>
