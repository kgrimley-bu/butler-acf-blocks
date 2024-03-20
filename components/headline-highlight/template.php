<?php

$user_agent = $_SERVER['HTTP_USER_AGENT'];
$browser_css = ( strpos( $user_agent, 'Windows' ) > 0 ) ? 'headline-highlight__text--windows' : '';
$highlight_style = ( $headline['color_value'] == 'primary' || $headline['color_value'] == 'blue' || $headline['color_value'] == 'pink' || $headline['color_value'] == 'green' ) ? 'background-color: var(--color-theme-' . $headline['color_value'] . '); color: var(--color-theme-white);' : '--highlight-color: var(--color-theme-' . $headline['color_value'] . ');';
$headline_size = ( isset( $headline['size'] ) ) ? 'headline-' . $headline['size'] : 'headline-h1';
?>
<<?php echo $headline[ 'size' ]; ?> class="headline-highlight">
	<span 
		class="headline-highlight__text <?php echo "$browser_css $headline_size"; ?>"
		style="<?php echo $highlight_style; ?>"
	>
		<?php echo $headline['text']; ?>
	</span>
</<?php echo $headline['size']; ?>>