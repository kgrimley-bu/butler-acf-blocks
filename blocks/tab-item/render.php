<?php
$classes = array( '' );
if ( ! empty( $block['className'] ) ) {
	$classes = array_merge( $classes, explode( ' ', $block['className'] ) );
}
$acc_is_editor = false;
$tab_title     = $block['data']['tab_title'] ?: '';
// $tab_unique_id = str_replace( '.', '', uniqid( floor( microtime( true ) * 1000 ), true ) );
$tab_unique_id = $tab_title ? sanitize_title( $tab_title ) : str_replace( '.', '', uniqid( floor( microtime( true ) * 1000 ), true ) );

if ( ! $tab_title ) {
	$tab_title = 'Tab Title';
}

?>
<div class="tabitem <?php echo esc_attr( join( ' ', $classes ) ); ?>"
	id="tab-item-<?php echo $tab_unique_id; ?>"
	data-tab-title="<?php echo $block['data']['tab_title'] ?: ''; ?>">
	<a class="tab"
		href="#tab-content-<?php echo $tab_unique_id; ?>"><?php echo $tab_title; ?></a>
	<InnerBlocks class="tabitem-content"/>
</div>

<script>
	document.addEventListener("DOMContentLoaded", function () {
		// move innerblocks to tabs-content
		var targetTabItem = document.getElementById("tab-item-<?php echo $tab_unique_id; ?>");
		var targetInnerBlocks = targetTabItem.querySelector(".tabitem-content");
		targetInnerBlocks.setAttribute("id", "tab-content-<?php echo $tab_unique_id; ?>");
		var parentTabgroup = targetTabItem.closest(".tabgroup");
		var destination = parentTabgroup.querySelector(".tabs-content");
		destination.appendChild(targetInnerBlocks);
	});
</script>

