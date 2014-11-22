<?php
add_action('admin_menu', 'add_admin_menu');
function add_admin_menu() {
	global $menu;
	
	// Create the new separator
	$menu['59.997'] = array( '', 'manage_options', 'separator-genesis', '', 'wp-menu-separator' );
	
	// Create the new top-level Menu
	add_menu_page('Cox', 'Theme Settings', 'cox_manage_options', 'machu-theme', 'cox_theme_settings_admin', CHILD_URL.'/images/theme-settings.png', '59.996');
}