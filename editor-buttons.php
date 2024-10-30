<?php

/*--------------------------------------------------
	Adds a shiny new button to the editor
----------------------------------------------------*/

add_action( 'init', 'wpch_buttons' );
function wpch_buttons() {
    add_filter( 'mce_external_plugins', 'wpch_add_plugin' );
    add_filter( 'mce_buttons', 'wpch_register_buttons' );
}
function wpch_add_plugin( $plugin_array ) {
    $plugin_array['wpch_plugin'] = plugins_url( 'static/js/wpch-tinymce-plugin.js' , __FILE__ );
    return $plugin_array;
}
function wpch_register_buttons( $buttons ) {
    array_push( $buttons, 'wpch_lock_content' );
    return $buttons;
}

?>