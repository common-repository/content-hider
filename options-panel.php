<?php
/*
The settings page
*/

function wpch_menu_item() {
	global $wpch_settings_page_hook;
    $wpch_settings_page_hook = add_plugins_page(  
        'Content Hider Settings',            			// The title to be displayed in the browser window for this page.
        'Content Hider Settings',            			// The text to be displayed for this menu item
        'administrator',            				// Which type of users can see this menu item  
        'wpch_settings',    							// The unique ID - that is, the slug - for this menu item
        'wpch_render_settings_page'     				// The name of the function to call when rendering this menu's page  
    );
}
add_action( 'admin_menu', 'wpch_menu_item' );

function wpch_scripts_styles($hook) {
	global $wpch_settings_page_hook;
	if( $wpch_settings_page_hook != $hook )
		return;
	wp_enqueue_style("options_panel_stylesheet", plugins_url( "static/css/options-panel.css" , __FILE__ ), false, "1.0", "all");
	wp_enqueue_script("options_panel_script", plugins_url( "static/js/options-panel.js" , __FILE__ ), false, "1.0");
	wp_enqueue_script('common');
	wp_enqueue_script('wp-lists');
	wp_enqueue_script('postbox');
}
add_action( 'admin_enqueue_scripts', 'wpch_scripts_styles' );

function wpch_render_settings_page() {
?>
<div class="wrap">
<div id="icon-options-general" class="icon32"></div>
<h2>Content Hider Settings</h2>
	<?php settings_errors(); ?>
	<div class="clearfix paddingtop20">
		<div class="first ninecol">
			<form method="post" action="options.php">
				<?php settings_fields( 'wpch_settings' ); ?>
				<?php do_meta_boxes('wpch_metaboxes','advanced',null); ?>
				<?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
				<?php wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); ?>
			</form>
		</div>
		<div class="last threecol">
			<div class="side-block">
				Like the plugin? If yes please give it a good rating on WordPress.org.
			</div>
		</div>
	</div>
</div>
<?php }

function wpch_create_options() { 
	
	add_settings_section( 'wphc_settings_section', null, null, 'wpch_settings' );

	add_settings_field(
        'minimum_role', '', 'wpch_render_settings_field', 'wpch_settings', 'wphc_settings_section',
		array(
			'title' => 'Default access level required to view hidden content',
			'desc' => 'This can be overridden by setting the <i>role</i> attribute of the shortcode',
			'id' => 'minimum_role',
			'type' => 'select',
			'options' => array("read" => "Subscriber", "edit_posts" => "Contributor", "edit_published_posts" => "Author", "moderate_comments" => "Editor", "install_plugins" => "Administrator" ),
			'group' => 'wpch_settings'
		)
    );

	add_settings_field(
        'error_message', '', 'wpch_render_settings_field', 'wpch_settings', 'wphc_settings_section',
		array(
			'title' => 'Default error message',
			'desc' => 'Message to display when a user commes accross inaccessible content. This can be overridden by setting the <i>error</i> attribute of the shortcode',
			'id' => 'error_message',
			'type' => 'textarea',
			'group' => 'wpch_settings'
		)
    );
	
    // Finally, we register the fields with WordPress 
	register_setting('wpch_settings', 'wpch_settings', 'wpch_settings_validation');
	
} // end sandbox_initialize_theme_options 
add_action('admin_init', 'wpch_create_options');

function wpch_settings_validation($input){
	$allowed_html = array(
						'a' => array(
							'href' => array(),
							'title' => array()
						),
						'b' => array(),
						'em' => array(),
						'i' => array(),
						'strong' => array()
					);
	$input['error_message'] = wp_kses($input['error_message'], $allowed_html);
	return $input;
}

function wpch_add_meta_boxes(){
	add_meta_box("wpch_settings_metabox", 'Settings', "wpch_metaboxes_callback", "wpch_metaboxes", 'advanced', 'default', array('settings_section'=>'wphc_settings_section'));
}
add_action( 'admin_init', 'wpch_add_meta_boxes' );

function wpch_metaboxes_callback($post, $args){
	do_settings_fields( "wpch_settings", $args['args']['settings_section'] );
	submit_button('Save Changes', 'secondary');
}

function wpch_render_settings_field($args){
	$option_value = get_option($args['group']);
?>
	<div class="row clearfix">
		<div class="col colone"><?php echo $args['title']; ?></div>
		<div class="col coltwo">
<?php
	if ($args['type'] == 'select')
	{ 
?>
		<select name="<?php echo $args['group'].'['.$args['id'].']'; ?>" id="<?php echo $args['id']; ?>">
			<?php foreach ($args['options'] as $key=>$option) { ?>
				<option <?php selected($option_value[$args['id']], $key); echo 'value="'.$key.'"'; ?>><?php echo $option; ?></option><?php } ?>
		</select>
<?php
	}
	else if($args['type'] == 'textarea')
	{
?>
		<textarea name="<?php echo $args['group'].'['.$args['id'].']'; ?>" type="<?php echo $args['type']; ?>" cols="" rows=""><?php if ( $option_value[$args['id']] != "") { echo stripslashes(esc_textarea($option_value[$args['id']]) ); } ?></textarea>
<?php
	}
?>
		</div>
		<div class="col colthree"><small><?php echo $args['desc'] ?></small></div>
	</div>
<?php
}

?>