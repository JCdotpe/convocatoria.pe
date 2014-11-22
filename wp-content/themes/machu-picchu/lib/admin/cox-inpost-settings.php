<?php
/**
*Add Cox Portfolio fields in post
*/

// Add Inpost Box
add_action('admin_menu', 'add_inpost_box');
function add_inpost_box() {
	add_meta_box('inpost_iframe_box', __('Iframe Load Content', 'genesis'), 'inpost_iframe_box', 'post', 'normal', 'high');
	add_meta_box('cox_inpost_slider_box', __('Slider Options', 'genesis'), 'cox_inpost_slider_box', 'post', 'normal', 'high');
	add_meta_box('cox_inpost_port_box', __('Cox Portfolio Options', 'genesis'), 'cox_inpost_port_box', 'post', 'normal', 'high');
}

function inpost_iframe_box() { ?>
	<input type="hidden" name="cox_inpost_nonce" value="<?php echo wp_create_nonce(plugin_basename(__FILE__)); ?>"  />
<?php
	echo '<p><label><b>URL<br /><input type="text" class="large-text" name="inpost[_iframe_url]" value="'.esc_attr(genesis_get_custom_field('_iframe_url')).'" /></b></label></p>';
}




function cox_inpost_slider_box() { ?>
	<input type="hidden" name="cox_inpost_nonce" value="<?php echo wp_create_nonce(plugin_basename(__FILE__)); ?>"  />
<?php
	echo '<p><input type="checkbox" name="cox_inpost[_cox_active_html]" id="_cox_active_html" value="1" ' . checked(1, genesis_get_custom_field('_cox_active_html'), false). ' /> <label for="_cox_active_html">Custom Html</label></p>';
	
	echo '<p><label><b>Html<br /><textarea class="large-text" rows="4" name="cox_inpost[_cox_html]"  >'.esc_attr(genesis_get_custom_field('_cox_html')).'</textarea></b></label></p>';
				
}

function cox_inpost_port_box() { 

	echo '<p><label><b>Portfolio Title<br /><input type="text" class="large-text" name="cox_inpost[_cox_port_title]" value="'.esc_attr(genesis_get_custom_field('_cox_port_title')).'" /></b></label></p>';
	
	echo '<p><label><b>Portfolio Title Link<br /><input type="text" class="large-text" name="cox_inpost[_cox_port_title_link]" value="'.esc_attr(genesis_get_custom_field('_cox_port_title_link')).'" /></b></label></p>';

	echo '<p><label><b>Portfolio Media URL (Clicking on Image)<br /><input type="text" class="large-text" name="cox_inpost[_cox_port_media]" value="'.esc_attr(genesis_get_custom_field('_cox_port_media')).'" /></b></label></p>';

	echo '<p><label><b>Portfolio External URL (Image Link)<br /><input type="text" class="large-text" name="cox_inpost[_cox_port_external]" value="'.esc_attr(genesis_get_custom_field('_cox_port_external')).'" /></b></label></p>';

	echo '<p><label><b>Portfolio Text<br /><textarea class="large-text" rows="4" name="cox_inpost[_cox_port_text]"  >'.esc_attr(genesis_get_custom_field('_cox_port_text')).'</textarea></b></label></p>';
				
}
add_action('save_post', 'cox_inpost_save', 1, 2);
function cox_inpost_save($post_id, $post) {
	
	//	verify the nonce
	if (!isset($_POST['cox_inpost_nonce']) || !wp_verify_nonce($_POST['cox_inpost_nonce'], plugin_basename(__FILE__)))
		return $post_id;
		
	//	don't try to save the data under autosave, ajax, or future post.
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
	if(defined('DOING_AJAX') && DOING_AJAX) return;
	if(defined('DOING_CRON') && DOING_CRON) return;

	//	is the user allowed to edit the post or page?
	if(('page' == $_POST['post_type'] && !current_user_can('edit_page', $post_id)) || !current_user_can('edit_post', $post_id ))
		return $post_id;

	// Define all as false, to be trumped by user submission
	$inpost_defaults = array(
		'_cox_active_html' => 0,
		'_cox_html' => '',
		'_cox_port_title' => '',
		'_cox_port_title_link' => '',
		'_cox_port_media' => '',
		'_cox_port_external' => '',
		'_cox_port_text' => ''
	); 

	$property_details = wp_parse_args($_POST['cox_inpost'], $inpost_defaults);
	//	store the custom fields
	foreach ($property_details as $key => $value) {
		if($post->post_type == 'revision') return; // don't try to store data during revision save
		
		//	save/update
		if ( $value ) {
			//	save/update
			update_post_meta($post->ID, $key, $value);
		} else {
			//	delete if blank
			delete_post_meta($post->ID, $key);
		}
	}
	
}