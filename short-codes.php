<?php

/*--------------------------------------------------
	Remove Junk From Shortcode Content
----------------------------------------------------*/

function wpch_parse_shortcode_content( $content ) {

   /* Parse nested shortcodes and add formatting. */
    $content = trim( do_shortcode( shortcode_unautop( $content ) ) );

    /* Remove '' from the start of the string. */
    if ( substr( $content, 0, 4 ) == '' )
        $content = substr( $content, 4 );

    /* Remove '' from the end of the string. */
    if ( substr( $content, -3, 3 ) == '' )
        $content = substr( $content, 0, -3 );

    /* Remove any instances of ''. */
    $content = str_replace( array( '<p></p>' ), '', $content );
    $content = str_replace( array( '<p>  </p>' ), '', $content );

    return $content;
}

/*--------------------------------------------------
	Shortcode [lock_content]
----------------------------------------------------*/

add_shortcode('lock_content', 'wpch_render_shortcode');
function wpch_render_shortcode($atts, $content = null) {
	extract(shortcode_atts(array('role' => false, 'capability' => false, 'error'=> false), $atts));
	$content = wpch_parse_shortcode_content( $content );
	$wpch_settings = get_option('wpch_settings');
	$current_user_can =	('administrator' == $role && current_user_can('activate_plugins') ) ||
						('editor' == $role && current_user_can('moderate_comments') ) ||
						('author' == $role && current_user_can('edit_published_posts') ) ||
						('contributor' == $role && current_user_can('edit_posts') ) ||
						('subscriber' == $role && current_user_can('read') ) ||
						($capability && current_user_can($capability) ) ||
					 	(!$role && !$capability && $wpch_settings && current_user_can($wpch_settings['minimum_role'])) ||
					 	(!$role && !$capability && !$wpch_settings && is_user_logged_in());
	$error_string = ($error)?$error:(($wpch_settings['error_message'])?$wpch_settings['error_message']:'This part of the content is private.');
	if($current_user_can)
		return $content;
	return '<div class="wpch_error">'.$error_string.'</div>';
}
?>