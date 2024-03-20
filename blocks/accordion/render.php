<?php
/**
 * Template part for displaying Accordions
 */
require_once realpath( __DIR__ ) . '/../utils/functions/get_classes.php';

$acc_block_id        = $block['id'];
$acc_title           = get_field( 'acc_title' );
$acc_highlight_color = get_field( 'acc_highlight_color' );
$acc_initial_open    = get_field( 'acc_initial_open' );
$acc_is_editor       = false;

if ( is_admin() ) {
	$acc_is_editor = true;
}

if ( ! $acc_title ) {
	$acc_title = 'Title';
}
?>

<div class="<?php echo get_classes( 'acc-flex-container', $block ); ?>">
	<div>
		<button id='<?php echo $acc_block_id; ?>-acc-row' class='acc-row'
				aria-expanded='<?php echo( 1 == (int) $acc_initial_open ? 'true' : 'false' ); ?>'
				aria-owns='<?php echo $acc_block_id; ?>_acc-content-panel'>
			<div id='<?php echo $acc_block_id; ?>-acc-title' class='acc-title'>
				<?php echo $acc_title; ?>
			</div>
			<img alt="" id='<?php echo $acc_block_id; ?>-acc-img' class='acc-icon'
				src='/wp-content/plugins/butler-acf-blocks/assets/images/nav_main_icon_<?php echo( 1 == (int) $acc_initial_open ? 'close' : 'open' ); ?>.png'/>
		</button>
	</div>
	<div aria-hidden='<?php echo( 1 == (int) $acc_initial_open ? 'false' : 'true' ); ?>'
		id='<?php echo $acc_block_id; ?>-acc-content-panel' class='acc-panel'>
		<InnerBlocks/>
	</div>
	<script type="text/javascript">
		(function ($) {
			let panel = document.getElementById('<?php echo $acc_block_id; ?>-acc-content-panel');
			/*
			 * Need to set a value for maxHeight to initialize the accordion properly.
			 * If we don't include this conditional, the accordion doesn't nicely transition to open/close on the first click.
			 */
			if (1 == <?php echo (int) $acc_initial_open; ?> ) {
				panel.style.maxHeight = <?php echo (int) $acc_is_editor; ?> ==
				1 ? 'fit-content' : panel.scrollHeight + 'px';
			} else {
				panel.style.maxHeight = '0px';
			}
			
			$('#<?php echo $acc_block_id; ?>-acc-row').off('click').on('click', (function () {
				let row = document.getElementById('<?php echo $acc_block_id; ?>-acc-row');
				let acc_img = document.getElementById('<?php echo $acc_block_id; ?>-acc-img');
				/*
				* If the panel is open, close it by setting its height to 0px.
				* If it's closed, i.e. its height is 0px, open it b setting its height to fit-content if in backend, or scrollHeight if frontend.
				* This is necessary because transitions do not work on height: fit-content, causing the accordion to snap open and shut instantly.
				*/
				if (panel.style.maxHeight != '0px') {
					panel.style.maxHeight = '0px';
				} else {
					panel.style.maxHeight = <?php echo (int) $acc_is_editor; ?> ==
					1 ? 'fit-content' : panel.scrollHeight + 'px';
				}

				let expanded = row.getAttribute('aria-expanded');
				if (expanded == 'true') {
					row.setAttribute('aria-expanded', 'false');
					acc_img.src = '/wp-content/plugins/butler-acf-blocks/assets/images/nav_main_icon_open.png';
				} else {
					row.setAttribute('aria-expanded', 'true');
					acc_img.src = '/wp-content/plugins/butler-acf-blocks/assets/images/nav_main_icon_close.png';
				}
			})); //End .click

			let highlight_color = getComputedStyle(document.documentElement).getPropertyValue('--color-theme-<?php echo $acc_highlight_color; ?>');
			let title = document.getElementById('<?php echo $acc_block_id; ?>-acc-title');

			$('#<?php echo $acc_block_id; ?>-acc-row').hover(function () {
				title.style.backgroundColor = highlight_color;
			}, function () {
				title.style.backgroundColor = '';
			}); //End .hover

		})(jQuery);
	</script>
</div>
