<?php
/*
Plugin Name: Content Hider
Plugin URI: http://wpgurus.net/
Description: Restrict access to your content by wrapping it in a simple shortcode. You can grant access to certain roles or users who have a certain capability.
Version: 0.1
Author: Hassan Akhtar
Author URI: http://wpgurus.net/
License: GPL2
*/

function wpch_add_styling(){
?>
	<style>.wpch_error{margin:20px 0;background:url('<?php echo plugins_url( 'static/img/error.png' , __FILE__ ); ?>') no-repeat scroll 10px 6px #CF4944; color: #FFFFFF; padding: 10px 10px 10px 50px;}</style>
<?php
}
add_action('wp_head', 'wpch_add_styling');

include('options-panel.php');

include('short-codes.php');

include('editor-buttons.php');