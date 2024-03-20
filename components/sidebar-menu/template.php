<?php
$menu_data = get_field( 'menu_link_items', $menu_id );
$menu_title = explode( ' Menu', get_the_title( $menu_id ) )[0] . ' Menu';

$has_hero_css = ( has_block_type( 'acf/hero-standard' ) || has_block_type( 'acf/hero-alternate' ) ) ? 'sidebar-menu--hasHero' : '';

$has_limit = get_field( 'limit_visible_items', $menu_id );

if ( $has_limit === true ) {
	$limit_items = true;
} else if ( is_null( $has_limit ) ) {
	$limit_items = true;
} else if ( $has_limit === false ) {
	$limit_items = false;
}

if ( $menu_data !== null ) { ?>
	<nav class="sidebar-menu <?php echo $has_hero_css; ?>" aria-label="Site Menu" id="page-nav">
		<div class="sidebar-menu__wrapper">
			<header class="sidebar-menu__header">
				<span class="sidebar-menu__headerLabel"><?php echo $menu_title; ?></span>

				<?php // if( $args[ 'preview' ] !== true ) { ?>
				<button class="sidebar-menu__mobileToggle" title="Toggle Menu" :aria-expanded="mobileOpen"></button>
				<?php // } ?>
			</header>

			<ul class="sidebar-menu__list" v-show="mobileOpen">
				<?php

				foreach ( $menu_data as $key => $item ) {
					$item = $item['menu_link_item'];
					$desktopShow = ( $key >= 8 && $limit_items == true ) ? 'hide-overflow' : '';
					$target = ( $item['target'] !== '' ) ? 'target="' . $item['target'] . '"' : '';
					?>
					<li class="sidebar-menu__listItem <?php echo $desktopShow; ?>">
						<a href="<?php echo $item['url']; ?>" class="sidebar-menu__listLink" <?php echo $target; ?>><?php echo $item['title']; ?></a>
					</li>
				<?php } ?>
			</ul>
		</div>
		<?php if ( /*$args[ 'preview' ] !== true &&*/ count( $menu_data ) > 8 && $limit_items == true ) { ?>
		<button class="sidebar-menu__desktopToggle" v-text="desktopLabel" :aria-expanded="desktopOpen">More Links</button>
		<?php } ?>
	</nav>
<?php } ?>
