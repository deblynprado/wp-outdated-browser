<?php
/**
* Plugin Name: WP Outdated Browser
* Description: This plugin show a message if your browser is outdated.
* Version: 2.0.0
* Author: Deblyn Prado
* Text Domain: outbws
* Domain Path: languages
* Author URI: http://deblynprado.com
* License: GPL2 or later
*/

/**
* This Plugin show a Message if user is using a Old version of any browser.
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class OutdatedBrowser {
 
	function __construct(){
		add_action( 'init', array( $this, 'outdated_textdomain' ) );
    add_action( 'admin_menu', array( $this, 'avalio_parametros_page' ) );
    add_action( 'admin_init', array( $this, 'outdated_settings_init' ) );    
    add_action( 'admin_enqueue_scripts', array( $this, 'add_color_picker' ) );
    add_action( 'wp_enqueue_scripts', array( $this, 'outdated_scripts' ) );
		add_action( 'wp_footer', array( $this, 'outdated_browser' ) );
		add_action( 'admin_notices', array( $this, 'outdated_messages' ));
	}
 
  function avalio_parametros_page() {
	  global $outdated_param;
	  $outdated_param = add_menu_page(
	  	__( 'Outdated Options', 'outbws' ),						// Page Title
	  	'Outdated Browser',														// Menu Name
	  	'activate_plugins',														// Capabilities
	  	'outdated-browser-options',										// Page Slug
	  	array( $this, 'print_html_options' ),					// Callback function to render HTML
	  	'dashicons-admin-site'												// Menu Icon
	  );	  
  }

  /**
	** Adding sections, fields and settings during admin_init
	*/
	 
	 
	 function outdated_settings_init() {
	 	// Creating Sections
	 	add_settings_section(
			'outdated_general_section',										// Section id
			__( 'General Options', 'outbws' ),						// Section title
			array( $this, 'general_section_callback' ),		// Callback with Section HTML
			'outdated-browser-options'										// Page slug where is section will apear
		);
	 	
	 	// Creating Settings
	 	add_settings_field(
			'background-color',														// Setting name
			__( 'Background color', 'outbws' ),						// Setting Label
			array( $this, 'color_setting_callback' ),			// Callback with the HTML of setting (any HTML element)
			'outdated-browser-options',										// Slug the page where he will apear
			'outdated_general_section'										// Section where he will apear
		);

		add_settings_field(
			'font-color',																	// Setting name
			__( 'Font color', 'outbws' ),									// Setting Label
			array( $this, 'font_setting_callback' ),			// Callback with the HTML of setting (any HTML element)
			'outdated-browser-options',										// Slug the page where he will apear
			'outdated_general_section'										// Section where he will apear
		);

		add_settings_field(
			'browser',																		// Setting name
			__( 'Lower than', 'outbws' ),									// Setting Label
			array( $this, 'browser_setting_callback' ),		// Callback with the HTML of setting (any HTML element)
			'outdated-browser-options',										// Slug the page where he will apear
			'outdated_general_section',										// Section where he will apear
			$browsers = array(
				'borderImage'		=> 'IE11',
				'transform'			=> 'IE10',
				'boxShadow'			=> 'IE9',
				'borderSpacing'	=> 'IE8'
			)			
		);		
	 	
	 	// Register all settings
	 	register_setting( 'outdated-browser-options', 'background-color' );
	 	register_setting( 'outdated-browser-options', 'font-color' );
	 	register_setting( 'outdated-browser-options', 'browser' );	 	
	 }
	 
	  
	 /**
	 ** Settings section callback function
	 */	 
	 function general_section_callback() {
	 	echo __( 'Customize the message apearance', 'outbws' );
	 }
	 
	 /**
	 ** Callback function for our example setting
	 */
	 
	 function color_setting_callback() {
	 	echo '<input name="background-color" id="bkg-color" type="text" value="' . get_option( 'background-color' ) . '" class="code"/>';	 	
	 }

	 function font_setting_callback() {
	 	echo '<input name="font-color" id="font-color" type="text" value="' . get_option( 'font-color' ) . '" class="code"/>';
	 }

	 function browser_setting_callback( $browsers ) {	
	 	echo '<select name="browser">';
	 	foreach( $browsers as $key => $browser ) :
	 		echo '<option id="language" value="' . $key . '" ' . selected( get_option( 'browser' ), $key, true ) . '>' . $browser . '</option>';
	 	endforeach;
	 	echo '</select>';
	 }

  /*
  ** Function to print a form with all the options in admin page
  */
  function print_html_options() { ?>
		<form method="POST" action="options.php">
			<?php settings_fields( 'outdated-browser-options' );
			do_settings_sections( 'outdated-browser-options' );
			submit_button();
			$result = $this->get_setting_saved();			
			?>
		</form>
  <?php }  

  /**
  * This function get the value of all the options and return them in an array
  * @return: array();
  */
  function get_setting_saved() {
  	$settings = array(
  		'fontColor'		=> get_option( 'font-color' ),
  		'bkgColor'		=> get_option( 'background-color' ),
  		'lang'				=> get_option( 'language' ),
  		'browser'			=> get_option( 'browser' )
  	);
  	return($settings);
  }

  /*
  ** Using default WordPress erros messages
  */
  function outdated_messages() {
  	settings_errors();
  }  

	function add_color_picker( $hook ) {
  	if( is_admin() ) {
    	// Add the color picker css file      
    	wp_enqueue_style( 'wp-color-picker' );     
    	// Include our custom jQuery file with WordPress Color Picker dependency
    	wp_enqueue_script( 'custom-script-handle', plugins_url( 'js/admin.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
  	}
	}

	/*
	** Default WordPress method to internationalize plugin
	*/
	function outdated_textdomain() {
		load_plugin_textdomain( 'outbws', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
	}	

	/**
	* Put the Outdated Browser HTML in theme.
	*/
	function outdated_browser() {
		echo ( '<div id="outdated"><h6>' );
		echo __( 'Your browser is out-of-date!', 'outbws' );
		echo ( '</h6><p>' );
		echo __( 'Update your browser to view this website correctly.', 'outbws' );
		echo ( '<a id="btnUpdateBrowser" href="http://outdatedbrowser.com/">' );
		echo __( 'Update my browser now', 'outbws' );
		echo ( '</a></p><p class="last"><a href="#" id="btnCloseUpdateBrowser" title="Close">&times;</a></p></div> ');		
		$this->outdated_scripts($this->get_setting_saved());
	}

	/*
	** Getting assets path and calling native functions of script and style.
	*/
	function outdated_scripts( $opt ){
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
		wp_localize_script( 'outdated-browser-main', 'outOptions', $opt);
	}	
}

/*
** Init the __construct
*/	
add_action( "init", "OutdatedInit", 1 );

function OutdatedInit() {
  global $OutdatedBrowser;
  $OutdatedBrowser = new OutdatedBrowser();
}