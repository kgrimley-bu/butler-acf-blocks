<?php
require_once realpath( __DIR__ ) . '/../utils/functions/get_classes.php';
$headline = get_field( 'headline' ) ?: '';
$accent_text = get_field( 'accent_text' ) ?: '';
?>

<section class="<?php echo get_classes( 'hero-primary', $block ); ?>">
	<button class="hero-primary__clearButton" id="canvas-clear-button">Clear Drawing</button>
	<div class="hero-primary__container">
		<div class="hero-primary__content">
			<h1 class="hero-primary__headline"><?php echo $headline; ?></h1>
			<p class="hero-primary__tagline hero-primary__tagline--left"><?php echo $accent_text; ?></p>
			<p class="hero-primary__tagline hero-primary__tagline--right"><?php echo $accent_text; ?></p>
		</div>
		
	</div>
	<canvas aria-hidden="true" class="hero-primary__canvas" id="hero-primary__canvas"></canvas>
</section>
