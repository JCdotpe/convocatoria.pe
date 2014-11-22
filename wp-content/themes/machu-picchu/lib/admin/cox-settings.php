<?php
function cox_settings_defaults() {
	$defaults = array( // define our defaults
		
		'theme_font' => 'Quattrocento Sans',
		'theme_layout' => 'box',
		
		'slider_effect' => 'random',
		'slider_cat' => '-1',
		'slider_items' => '5',
		
		'script_left' => '© Cox Genesis Child Theme - Design by <a href="http://www.coxthemes.com">Cox Themes</a>',		
		'script_right' => 'Powered by Genesis Framework and Wordpress - <a href="#wrap">Top</a>'
	
	);
	return apply_filters('cox_settings_defaults', $defaults);
}

add_action('admin_init', 'cox_register_settings');
function cox_register_settings() {
	register_setting(COX_SETTINGS_FIELD, COX_SETTINGS_FIELD);
	add_option(COX_SETTINGS_FIELD, cox_settings_defaults(), '', 'yes');
	
	if ( !isset($_REQUEST['page']) || $_REQUEST['page'] != 'cox-settings' )
		return;
		
	if ( cox_get_option('reset',1) ) {
		update_option(COX_SETTINGS_FIELD, cox_settings_defaults());
		wp_redirect( admin_url( 'admin.php?page=cox-settings&reset=true' ) );
		exit;
	}
}

add_action('admin_notices', 'cox_settings_notice');
function cox_settings_notice() {
	
	if ( !isset($_REQUEST['page']) || $_REQUEST['page'] != 'cox-settings' )
		return;
	
	if ( isset($_REQUEST['settings-updated']) && $_REQUEST['settings-updated'] == 'true') {  
		echo '<div id="message" class="updated"><p>'.__('Cox Settings Saved', COX_DOMAIN).'</p></div>';
	}
	elseif ( isset( $_REQUEST['reset'] ) && $_REQUEST['reset'] == 'true' ) {
		echo '<div id="message" class="updated"><p>'.__('Cox Settings Reset', COX_DOMAIN).'</p></div>';
	}
}

add_action('admin_menu', 'cox_settings_init');
function cox_settings_init() {
	global $_cox_settings_pagehook;
        
	// Add "General Settings" submenu
	$_cox_settings_pagehook = current_theme_supports('machu-theme') ? add_submenu_page('machu-theme', __('General Settings', COX_DOMAIN), __('General Settings',COX_DOMAIN), 'manage_options', 'cox-settings', 'cox_settings_admin') : null;
	
	add_action('load-'.$_cox_settings_pagehook, 'cox_settings_styles');
	add_action('load-'.$_cox_settings_pagehook, 'cox_settings_scripts');
	add_action('load-'.$_cox_settings_pagehook, 'cox_settings_boxes');
}

function cox_settings_styles() {
        wp_enqueue_style('farbtastic');
        wp_enqueue_style('cox-admin-css', CHILD_URL . '/lib/admin/css/admin.css', array(), cox_get_version());
}

function cox_settings_scripts() {
    global $_cox_settings_pagehook;
	wp_enqueue_script('common');
	wp_enqueue_script('wp-lists');
	wp_enqueue_script('postbox');
    wp_enqueue_script('farbtastic');
    wp_enqueue_script('cox-admin', CHILD_URL.'/lib/admin/js/admin.js', array(), cox_get_version(), true);
        $params = array(
            'pageHook'      => $_cox_settings_pagehook,
            'firstTime'     => !is_array(get_user_option('closedpostboxes_'.$_cox_settings_pagehook)),
            'toggleAll'     => __('Toggle All', COX_DOMAIN),
            'warnUnsaved'   => __('The changes you made will be lost if you navigate away from this page.', COX_DOMAIN),
            'warnReset'     => __('Are you sure you want to reset?', COX_DOMAIN)
        );
        wp_localize_script('cox-admin', 'cox', $params);
}

add_filter('screen_layout_columns', 'cox_settings_layout_columns', 10, 2);
function cox_settings_layout_columns($columns, $screen) {
	global $_cox_settings_pagehook;
	if ($screen == $_cox_settings_pagehook) {
		// This page should have 2 column options
		$columns[$_cox_settings_pagehook] = 2;
	}
	return $columns;
}

function cox_settings_admin() { 
global $_cox_settings_pagehook, $screen_layout_columns;
if( $screen_layout_columns == 3 ) {
	$width = "width: 32.67%";
}
elseif( $screen_layout_columns == 2 ) {
	$width = "width: 49%;";
	$hide3 = " display: none;";
}
else {
	$width = "width: 99%;";
	$hide2 = $hide3 = " display: none;";
}
?>	
	<div id="cox-settings" class="wrap genesis-metaboxes">
	<form method="post" action="options.php">
		
		<?php wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false ); ?>
		<?php wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false ); ?>
		<?php settings_fields(COX_SETTINGS_FIELD); // important! ?>
		
		<?php screen_icon('themes'); ?>
		<h2 id="top-buttons">
			<?php _e('Machu Picchu Settings', COX_DOMAIN); ?>
			<input type="submit" class="button-primary" value="<?php _e('Save Settings', COX_DOMAIN) ?>" />
			<input type="submit" class="button-highlighted button-reset" name="<?php echo COX_SETTINGS_FIELD; ?>[reset]" value="<?php _e('Reset Settings', COX_DOMAIN); ?>" />
		</h2>
		
		<div class="metabox-holder">
			<div class="postbox-container" style="<?php echo $width;  ?>">
				<?php do_meta_boxes($_cox_settings_pagehook, 'column1', null); ?>
			</div>
			<div class="postbox-container" style="<?php echo $width; ?>">
				<?php do_meta_boxes($_cox_settings_pagehook, 'column2', null); ?>
			</div>
		</div>
		
		<div class="bottom-buttons">
			<input type="submit" class="button-primary" value="<?php _e('Save Settings', COX_DOMAIN) ?>" />
			<input type="submit" class="button-highlighted button-reset" name="<?php echo COX_SETTINGS_FIELD; ?>[reset]" value="<?php _e('Reset Settings', COX_DOMAIN); ?>" />
		</div>
	</form>
	</div>
<?php
}

function cox_settings_boxes() {
	global $_cox_settings_pagehook;
	add_meta_box('cox-theme-general-settings', __('General settings', COX_DOMAIN), 'cox_theme_general_settings', $_cox_settings_pagehook, 'column1');
	add_meta_box('cox-slider-general-settings', __('Slider settings', COX_DOMAIN), 'cox_slider_general_settings', $_cox_settings_pagehook, 'column1');
	add_meta_box('cox-theme-bottom-text-settings', __('Footer Text', COX_DOMAIN), 'cox_theme_bottom_text_settings', $_cox_settings_pagehook, 'column2');
}

function cox_theme_general_settings(){
	cox_setting_line(cox_add_select_setting('theme_layout', __('Select Layout', COX_DOMAIN),1, 'layout'));
	cox_setting_line(cox_add_select_setting('theme_font', __('Use font', COX_DOMAIN),1, 'family'));
	do_action('cox_theme_general_settings');
}

function cox_slider_general_settings(){
	?>
	<p>  
    <label for="home_news_cat"><?php _e('Select a category to show:', COX_DOMAIN); ?></label>
    <?php  
	 wp_dropdown_categories(array('selected' => genesis_get_option('slider_cat',COX_SETTINGS_FIELD), 'id' => 'slider_cat', 'name' => COX_SETTINGS_FIELD.'[slider_cat]', 'orderby' => 'Name' , 'hierarchical' => 1, 'hide_empty' => '0', 'show_option_none'=> 'None'));
	?></p><?php  
	cox_setting_line(cox_add_select_setting('slider_effect', __('Effect', COX_DOMAIN),1, 'effect'));
	cox_setting_line(cox_add_text_setting('slider_items', __('Number of items', COX_DOMAIN),1));
	do_action('cox_slider_general_settings');
}


function cox_theme_bottom_text_settings(){
	cox_setting_line(cox_add_textarea_setting('script_left', __('Text for the left section', COX_DOMAIN),1,38,10));
	cox_setting_line(cox_add_textarea_setting('script_right', __('Text for the right section', COX_DOMAIN),1,38,10));
	do_action('cox_theme_bottom_text_settings');
}