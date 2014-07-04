<?php
/**
* Plugin Name: WP Outdated Browser
* Description: This plugin show a message if your browser is outdated.
* Version: 1.0.0
* Author: Deblyn Prado
* Text Domain: outdated-browser
* Domain Path: /languages
* Author URI: http://deblynprado.com
* License: GPL2
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class AvalioParametros {
 
    function __construct(){        
        add_action('admin_menu', array( $this, 'avalio_parametros_page' ));
    }
 
    function avalio_parametros_page() {
        global $avalio_parametros_admin;
 
        $avalio_parametros_admin = add_submenu_page(
            'options-general.php',               // The ID of the top-level menu page to which this submenu item belongs
            __( 'Outdated Browser Options', 'outdated-browser' ),              // The value used to populate the browser's title bar when the menu page is active
            'Outdated Browser',                              // The label of this submenu item displayed in the menu
            'administrator',                        // What roles are able to access this submenu item
            'outdated-browser-options',             // The ID used to represent this submenu item
            array($this, 'avalio_parametros_admin')// The callback function used to render the options for this submenu item
        );
 
        /*
        global $current_user;
        $user_id = $current_user->ID;
        $membership_levels = $current_user->membership_levels;
 
        if($membership_levels[0]->name == 'Top'){
            $avalio_parametros_top = add_submenu_page(
                'avalio',               // The ID of the top-level menu page to which this submenu item belongs
                'Plano Top',              // The value used to populate the browser's title bar when the menu page is active
                'Plano Top',                              // The label of this submenu item displayed in the menu
                'edit_posts',                        // What roles are able to access this submenu item
                'avalio-parametros-top',             // The ID used to represent this submenu item
                array($this, 'avalio_parametros_top')// The callback function used to render the options for this submenu item
            );
        }
        */
    }    

    function avalio_parametros_admin() {
        /*
        if($_POST['opcoes']){
            printr($_POST);
        }
        */
        $opcoes = $_POST['opcoes'];
        if( is_array($opcoes) ) {
            update_option( 'outdated_background_color', $opcoes['background_color'] );
            update_option( 'outdated_font_color', $opcoes['font_color'] );
            update_option( 'outdated_language', $opcoes['lang'] );
        }
    ?>
        <div class="wrap">
            <div id="icon-tools" class="icon32"></div>
            <h2><?php _e( 'Outdated Browser Settings','outdated-browser' )?></h2>
            <br><br>
            <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
 
                <table class="form-table">
                    <tr valign="top">
                        <td scope="row"><label for="background-color"><?php _e( 'Background Color', 'outdated-browser' ); ?></label></td>
                        <td><input name="opcoes[bkg_color]" id="bkg-color" type="text" value="<?php echo get_option('outdated_background_color');?>" class="regular-text" /></td>
                    </tr>
                    <tr valign="top">
                        <td scope="row"><label for="font-color"><?php _e( 'Font Color', 'outdated-browser' ); ?></label></td>
                        <td><input name="opcoes[font_color]" id="font-color" type="text" value="<?php echo get_option('outdated_font_color');?>" class="regular-text" /></td>
                    </tr>
                    <tr valign="top">
                        <td scope="row"><label for="select-language"><?php _e( 'Select Language', 'outdated-browser' ); ?></label></td>
                        <td>
                        	<select name="opcoes[lang]" id="select-language">                        		
                        		<option value=""><?php _e( 'Select a language', 'outdated-browser' ); ?></option>
                        		<option value="en" <?php selected( 'en' == get_option('lang') ); ?>><?php _e( 'English', 'outdated-browser' ); ?></option>
                        		<option value="pt" <?php selected( 'pt' == get_option('lang') ); ?>><?php _e( 'Portuguese', 'outdated-browser' ); ?></option>
                        	</select>
                        </td>
                    </tr>
                </table>
 					<?php print_r($opcoes);?>
                <br><br>
                <input type="submit" class="button-primary" value="Salvar">
            </form>
        </div><!-- wrap -->
    <?php
		return array($opcoes);    
    }
    
}

function outdated_browser(){
	/**
	* Setting the HTML content.
	*/
	echo ( '<div id="outdated"><h6>' );
	echo __( 'Your browser is out-of-date!', 'outdated-browser' );
	echo ( '</h6><p>' );
	echo __( 'Update your browser to view this website correctly.', 'outdated-browser' );
	echo ( '<a id="btnUpdateBrowser" href="http://outdatedbrowser.com/">' );
	echo __( 'Update my browser now', 'outdated-browser' );
	echo ( '</a></p><p class="last"><a href="#" id="btnCloseUpdateBrowser" title="Close">&times;</a></p></div> ');
}

function outdated_scripts(){
	/**
	* Define files path
	*/
	$outdated_browser_url =  plugin_dir_url( __FILE__ );
	$outdated_css = $outdated_browser_url . 'assets/outdatedbrowser/outdatedBrowser.min.css';
	$outdated_js = $outdated_browser_url . 'assets/outdatedbrowser/outdatedBrowser.min.js';
	$outdated_main = $outdated_browser_url . 'js/main.js';

	/**
	* Calling styles and scripts with WP native functions
	*/
	wp_enqueue_style( 'outdated-browser-style', $outdated_css );
	wp_enqueue_script( 'outdated-browser-js', $outdated_js);
	wp_enqueue_script( 'outdated-browser-main', $outdated_main, array(), "1.0.0", true );
}

function outdated_textdomain() {
	load_plugin_textdomain( 'outdated-browser', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
}

add_action( 'wp_enqueue_scripts', 'outdated_scripts' );
add_action( 'wp_footer', 'outdated_browser' );

///END of v1.0.0
 
add_action( "init", "AvalioParametrosInit", 1 );
 
function AvalioParametrosInit() {
    global $AvalioParametros;
    $AvalioParametros = new AvalioParametros();
}
// Color Picker
add_action( 'admin_enqueue_scripts', 'wptuts_add_color_picker' );
function wptuts_add_color_picker( $hook ) {
 
    if( is_admin() ) {
     
        // Add the color picker css file      
        wp_enqueue_style( 'wp-color-picker' );
         
        // Include our custom jQuery file with WordPress Color Picker dependency
        wp_enqueue_script( 'custom-script-handle', plugins_url( 'js/main.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
    }
}