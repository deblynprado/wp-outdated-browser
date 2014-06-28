<?php
/**
 * Plugin Name: WP Outdated Browser
 * Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
 * Description: A brief description of the Plugin.
 * Version: The Plugin's Version Number, e.g.: 1.0
 * Author: Name Of The Plugin Author
 * Author URI: http://URI_Of_The_Plugin_Author
 * License: A "Slug" license name e.g. GPL2
 */

function outdated_browser(){
	$outdated_browser_url =  plugin_dir_url( __FILE__ );
	$outdated_css = $outdated_browser_url . 'css/outdatedBrowser.min.css';
	$outdated_js = $outdated_browser_url . 'js/outdatedBrowser.min.js';
	$outdated_main = $outdated_browser_url . 'js/main.js';
	
	echo(
	'<div id="outdated">
     	<h6>Your browser is out-of-date!</h6>
     	<p>Update your browser to view this website correctly. <a id="btnUpdateBrowser" href="http://outdatedbrowser.com/">Update my browser now </a></p>
     	<p class="last"><a href="#" id="btnCloseUpdateBrowser" title="Close">&times;</a></p>
	</div>');

	wp_enqueue_style('outdated-browser-style', $outdated_css);
	wp_enqueue_script( 'outdated-browser-js', $outdated_js);
	wp_enqueue_script( 'outdated-browser-main', $outdated_main);	
}

add_action('wp_footer', 'outdated_browser');